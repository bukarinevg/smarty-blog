<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class BlogSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $now = time();

        $categories = [
            [
                'name' => 'Technology',
                'description' => 'Articles about latest technology trends and innovations',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Web Development',
                'description' => 'Tips and tricks for web developers',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'PHP',
                'description' => 'PHP programming language tutorials and best practices',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Database',
                'description' => 'Database design and optimization guides',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'DevOps',
                'description' => 'DevOps practices and infrastructure management',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->table('category')->insert($categories)->saveData();

        $images = [
            'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
        ];
        $content = "
        What is Lorem Ipsum?
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        
        Why do we use it?
        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
        ";

        $articles = [];
        $articleCategories = [];
        $categoriesAmount = count($categories);
        $articlesAmount = 1000;

        for ($i = 1; $i <= $articlesAmount; $i++) {
            $categoryId = random_int(1, $categoriesAmount);
            $secondaryCategoryId = random_int(1, $categoriesAmount);
            while ($secondaryCategoryId === $categoryId) {
                $secondaryCategoryId = random_int(1, $categoriesAmount);
            }

            $articles[] = [
                'image' => $images[random_int(0, count($images) - 1)],
                'title' => sprintf('Article %d', $i),
                'description' => sprintf('Article %d description', $i),
                'content' => $content,
                'views_count' => random_int(0, 1000),
                'published_at' => $now - random_int(0, 30) * 24 * 60 * 60,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $articleCategories[] = [
                'article_id' => $i,
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $articleCategories[] = [
                'article_id' => $i,
                'category_id' => $secondaryCategoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }


        $this->table('article')->insert($articles)->saveData();
        $this->table('article_category')->insert($articleCategories)->saveData();
    }
}
