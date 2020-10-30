<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%homework_finish_md}}`.
 */
class m201025_141020_create_homework_finished_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%homework_finished}}', [
            'id' => $this->primaryKey(),
            'homework_id' =>  $this->integer()->notNull()->comment('哪个作业'),
            'user_id' => $this->integer()->notNull()->comment('哪名同学'),
            'content_md' => $this->text()->notNull()->comment('Markdown 内容'),
            'content_html' => $this->text()->notNull()->comment('Markdown 转义 HTML 内容'),
            'finished_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'view_times' => $this->integer()->notNull()->defaultValue(0)->comment('观看次数'),
            'file' => $this->string(64)->comment('作业文件下载链接'),
            'file_download_times' => $this->integer()->notNull()->defaultValue(0)->comment('作业文件下载次数'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('10正常 0删除'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%homework_finished}}');
    }
}
