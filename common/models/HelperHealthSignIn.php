<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "helper_health_sign_in".
 *
 * @property int $id
 * @property int $user_id 哪名同学
 * @property int $remind_type 提醒方式：1 邮件，2 短信，3 邮件和短信
 * @property int $remind_time 提醒时间：1 七点，2 七点五十，3 八点四十五
 * @property int $status 10已打卡 0未打卡
 */
class HelperHealthSignIn extends \yii\db\ActiveRecord
{
    const CALLBACK_TOKEN_LENGTH = 12; //腾讯云短信限制长度

    const TYPE_EMAIL = 1;
    const TYPE_MESSAGE = 2;
    const TYPE_ALL = 3;

    const TIME_SEVEN = 1;
    const TIME_SEVEN_FIFTY = 2;
    const TIME_EIGHT_FORTY_FIVE = 3;
    const TIME_NINE_FORTY = 4;

    const STATUS_OK = 10;
    const STATUS_NO = 0;

    const IS_OPEN_YES = 1;
    const IS_OPEN_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'helper_health_sign_in';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'remind_type', 'remind_time', 'is_open'], 'required'],
            [['user_id', 'remind_type', 'remind_time', 'status', 'is_open'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'remind_type' => '如何提醒你？',
            'remind_time' => '在什么时候提醒你？',
            'status' => '状态',
            'is_open' => '开启本服务',
        ];
    }

    /**
     * 发送打卡提示邮件
     *
     * @param User $user user model to with email should be send
     * @param callbackToken string
     * @return bool whether the email was sent
     */
    public static function sendEmail($user, $callbackToken)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'healthSignInRemind-html', 'text' => 'healthSignInRemind-text'],
                [
                    'user' => $user,
                    'callbackToken' => $callbackToken,
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Piaoyii'])
            ->setTo($user->email)
            ->setSubject('健康打卡提醒 ------ ng.piaoyii.com')
            ->send();
    }
}
