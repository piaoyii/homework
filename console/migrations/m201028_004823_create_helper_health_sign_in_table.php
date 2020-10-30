<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%helper_health_sign_in}}`.
 */
class m201028_004823_create_helper_health_sign_in_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%helper_health_sign_in}}', [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer()->notNull()->comment('哪名同学'),
            'remind_type' => $this->smallInteger()->notNull()->comment('提醒方式：1 邮件，2 短信，3 邮件和短信'),
            'remind_time' => $this->smallInteger()->notNull()->comment('提醒时间：1 七点，2 七点五十，3 八点四十五'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('10已打卡 0未打卡'),
            'is_open' => $this->smallInteger()->notNull()->defaultValue(1)->comment('1开启 0关闭'),
            'callback_token' => $this->string()->comment('回调 token 以确认身份'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%helper_health_sign_in}}');
    }
}
