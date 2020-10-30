<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "homework".
 *
 * @property int $id
 * @property int $order 第几次
 * @property string $content 作业内容
 * @property int $is_image 有些时候可能是作业文件图片。并非文字
 * @property string $image 图片文件链接
 * @property string $created_at
 * @property string|null $updated_at
 */
class Homework extends \yii\db\ActiveRecord
{
    const IS_IMAGE_YES = 1;
    const IS_IMAGE_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'homework';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'created_at', 'order'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => '第几次',
            'content' => '内容',
            'created_at' => '布置时间',
            'updated_at' => '何时修改',
        ];
    }
}
