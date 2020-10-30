<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%homework}}`.
 */
class m201025_024855_create_homework_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%homework}}', [
            'id' => $this->primaryKey(),
            'order' => $this->integer()->comment('第几次'),
            'content' => $this->text()->notNull()->comment('作业内容'),
            'is_image' => $this->integer()->notNull()->defaultValue(0)->comment('有些时候可能是作业文件图片。并非文字'),
            'image' => $this->string(64)->comment('图片文件链接'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%homework}}');
    }
}
