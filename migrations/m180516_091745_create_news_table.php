<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180516_091745_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
        ]);
    }

    /**
    Note：并不是所有迁移都是可恢复的。例如，如果 up() 方法删除了表中的一行数据， 这将无法通过 down() 方法来恢复这条数据。有时候，你也许只是懒得去执行 down() 方法了， 因为它在恢复数据库迁移方面并不是那么的通用。在这种情况下， 你应当在 down() 方法中返回 false 来表明这个 migration 是无法恢复的。
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
