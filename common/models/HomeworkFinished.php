<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "homework_finished".
 *
 * @property int $id
 * @property int $homework_id 哪个作业
 * @property int $user_id 哪名同学
 * @property string $content_md Markdown 内容
 * @property string $content_html Markdown 转义 HTML 内容
 * @property string $finished_at
 * @property string $updated_at
 * @property int $view_times 观看次数
 * @property string|null $file 作业文件下载链接
 * @property int $file_download_times 作业文件下载次数
 * @property int $status 10正常 0删除
 */
class HomeworkFinished extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $real_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'homework_finished';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['homework_id', 'user_id', 'content_md', 'finished_at', 'content_html'], 'required'],
            [['homework_id', 'user_id', 'view_times', 'file_download_times'], 'integer'],
            [['content_md', 'content_html'], 'string'],
            [['finished_at', 'updated_at'], 'safe'],
            [['file'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'homework_id' => '作业ID',
            'user_id' => '英雄名单',
            'content_md' => '内容',
            'content_html' => 'html内容',
            'finished_at' => '完成时间',
            'updated_at' => '最后修改时间',
            'view_times' => '浏览次数',
            'file' => '作业文件',
            'file_download_times' => '作业文件下载次数',
            'real_name' => '英雄名称',
        ];
    }

    /**
     * 填充 HomeworkFinished 模型
     *
     * @param $params array
     * @return boolean
     */
    public function selfLoad($params)
    {
        if (!empty($params)) {

            if ($this->getIsNewRecord()) {
                $this->finished_at = date('Y-m-d H:i:s');
                $this->user_id = Yii::$app->user->id;
            } else {
                $this->updated_at = date('Y-m-d H:i:s');
            }

            $this->content_md = $params['java-homework-md-markdown-doc'];
            $this->content_html = $params['java-homework-md-html-code'];
            return true;
        }

        return false;
    }

    /**
     * 关联User模型
     *
     * @return Object
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * 移动到回收站
     */
    public function moveToTrash()
    {
        $this->status = SELF::STATUS_DELETED;
        return $this->save();
    }
}
