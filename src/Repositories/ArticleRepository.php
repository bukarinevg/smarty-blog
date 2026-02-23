<?php

declare(strict_types=1);

namespace app\repositories;

use PDO;

final readonly class ArticleRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @return array{
     *   id:int,
     *   title:string,
     *   description:string,
     *   content:string,
     *   image:string,
     *   views_count:int,
     *   published_at:int,
     *   category_names:string|null
     * }|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT a.id, a.title, a.description, a.content, a.image, a.views_count, a.published_at,
                    GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ", ") AS category_names
             FROM article a
             JOIN article_category ac ON ac.article_id = a.id
             JOIN category c ON c.id = ac.category_id
             WHERE a.id = :id
             GROUP BY a.id
             LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();

        if (!$article) {
            return null;
        }

        return $this->mapRowToArray($article);
    }

    public function incrementViews(int $articleId): void
    {
        $stmt = $this->pdo->prepare('UPDATE article SET views_count = views_count + 1 WHERE id = :id');
        $stmt->execute(['id' => $articleId]);
    }

    /**
     * @return array<int, array{
     *   id:int,
     *   title:string,
     *   description:string,
     *   content:string,
     *   image:string,
     *   views_count:int,
     *   published_at:int,
     *   category_names:string|null
     * }>
     */
    public function findSimilarArticles(int $articleId, int $limit): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT a.id, a.title, a.description, a.image, a.views_count, a.published_at,
                    COUNT(*) AS shared_categories
             FROM article a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE a.id <> :article_id
               AND ac.category_id IN (
                  SELECT category_id
                  FROM article_category
                  WHERE article_id = :article_id
               )
             GROUP BY a.id
             ORDER BY shared_categories DESC, a.views_count DESC, a.id DESC
             LIMIT :limit_count'
        );
        $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue(':limit_count', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        $articles = [];
        foreach ($rows as $row) {
            $articles[] = $this->mapRowToArray($row);
        }

        return $articles;
    }

    /**
     * @param array<string, mixed> $row
     */
    private function mapRowToArray(array $row): array
    {
        return [
            'id' => array_key_exists('id', $row) ? (int)$row['id'] : 0,
            'title' => array_key_exists('title', $row) ? (string)$row['title'] : '',
            'description' => array_key_exists('description', $row) ? (string)$row['description'] : '',
            'content' => array_key_exists('content', $row) ? (string)$row['content'] : '',
            'image' => array_key_exists('image', $row) ? (string)$row['image'] : '',
            'views_count' => array_key_exists('views_count', $row) ? (int)$row['views_count'] : 0,
            'published_at' => array_key_exists('published_at', $row) ? (int)$row['published_at'] : 0,
            'category_names' => array_key_exists('category_names', $row) && $row['category_names']
                ? (string)$row['category_names']
                : null,
        ];
    }
}
