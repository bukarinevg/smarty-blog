<?php

declare(strict_types=1);

namespace app\repositories;

use PDO;

final readonly class CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @return array<int, array{
     *   id:int,
     *   name:string,
     *   description:string,
     *   articles:array<int, array{
     *     id:int,
     *     title:string,
     *     description:string,
     *     image:string,
     *     views_count:int,
     *     published_at:int
     *   }>
     * }>
     */
    public function findCategoriesWithLatestArticles(int $limitPerCategory): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.id AS category_id,
                    c.name AS category_name,
                    c.description AS category_description,
                    a.id AS article_id,
                    a.title AS article_title,
                    a.description AS article_description,
                    a.image AS article_image,
                    a.views_count AS article_views_count,
                    a.published_at AS article_published_at
             FROM category c
             JOIN (
                SELECT ac.category_id,
                       a.id,
                       a.title,
                       a.description,
                       a.image,
                       a.views_count,
                       a.published_at,
                       ROW_NUMBER() OVER (
                           PARTITION BY ac.category_id
                           ORDER BY a.published_at DESC, a.id DESC
                       ) AS rn
                FROM article_category ac
                JOIN article a ON a.id = ac.article_id
             ) AS a ON a.category_id = c.id AND a.rn <= :limit_count
             ORDER BY c.name, a.published_at DESC, a.id DESC'
        );
        $stmt->bindValue(':limit_count', $limitPerCategory, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        $categories = [];
        foreach ($rows as $row) {
            $categoryId = (int)$row['category_id'];
            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'id' => $categoryId,
                    'name' => (string)$row['category_name'],
                    'description' => (string)$row['category_description'],
                    'articles' => [],
                ];
            }

            $categories[$categoryId]['articles'][] = [
                'id' => (int)$row['article_id'],
                'title' => (string)$row['article_title'],
                'description' => (string)$row['article_description'],
                'image' => (string)$row['article_image'],
                'views_count' => (int)$row['article_views_count'],
                'published_at' => (int)$row['article_published_at'],
            ];
        }

        return array_values($categories);
    }

    /**
     * @return array{
     *   id:int,
     *   name:string,
     *   description:string
     * }|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description FROM category WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();

        return $category !== false ? $category : null;
    }

    public function countArticlesByCategory(int $categoryId): int
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*)
             FROM article_category ac
             JOIN article a ON a.id = ac.article_id
             WHERE ac.category_id = :category_id'
        );
        $stmt->execute(['category_id' => $categoryId]);

        return (int)$stmt->fetchColumn();
    }

    /**
     * @return array<int, array{
     *   id:int,
     *   title:string,
     *   description:string,
     *   image:string,
     *   views_count:int,
     *   published_at:int
     * }>
     */
    public function findArticlesByCategory(int $categoryId, string $sort, int $page, int $limit): array
    {
        $orderBy = match ($sort) {
            'views' => 'a.views_count DESC, a.published_at DESC, a.id DESC',
            'date' => 'a.published_at DESC, a.id DESC',
            default => 'a.title ASC',
        };

        $sql = sprintf(
            'SELECT a.id, a.title, a.description, a.image, a.views_count, a.published_at
             FROM article_category ac
             JOIN article a ON a.id = ac.article_id
             WHERE ac.category_id = :category_id
             ORDER BY %s
             LIMIT :limit_count OFFSET :offset_count',
            $orderBy
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit_count', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset_count', ($page - 1) * $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
