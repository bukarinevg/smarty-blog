<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateBlogTables extends AbstractMigration
{
    public function change(): void
    {
        $this->table('category')
            ->addColumn('name', MysqlAdapter::PHINX_TYPE_STRING, ['limit' => MysqlAdapter::TEXT_SMALL])
            ->addColumn('description', MysqlAdapter::PHINX_TYPE_TEXT, ['limit' => MysqlAdapter::TEXT_REGULAR])
            ->addColumn('created_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->addColumn('updated_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->create();

        $this->table('article')
            ->addColumn('image', MysqlAdapter::PHINX_TYPE_STRING, ['limit' => MysqlAdapter::TEXT_SMALL])
            ->addColumn('title', MysqlAdapter::PHINX_TYPE_STRING, ['limit' => MysqlAdapter::TEXT_SMALL])
            ->addColumn('description', MysqlAdapter::PHINX_TYPE_TEXT, ['limit' => MysqlAdapter::TEXT_REGULAR])
            ->addColumn('content', MysqlAdapter::PHINX_TYPE_TEXT, ['limit' => MysqlAdapter::TEXT_MEDIUM])
            ->addColumn('views_count', MysqlAdapter::PHINX_TYPE_INTEGER, ['default' => 0])
            ->addColumn('published_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->addColumn('created_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->addColumn('updated_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->create();

        $this->table('article_category')
            ->addColumn('article_id', MysqlAdapter::PHINX_TYPE_INTEGER, ['signed' => false, 'null' => false])
            ->addColumn('category_id', MysqlAdapter::PHINX_TYPE_INTEGER, ['signed' => false, 'null' => false])
            ->addColumn('created_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->addColumn('updated_at', MysqlAdapter::PHINX_TYPE_INTEGER)
            ->addIndex(['article_id', 'category_id'], ['unique' => true])
            ->addForeignKey('article_id', 'article', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('category_id', 'category', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
 