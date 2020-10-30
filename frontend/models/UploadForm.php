<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Upload form
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'java, zip, text'],
        ];
    }

    /**
     * 文件上传
     *
     * @param $model HomeworkFinished model
     * @param $homework common\models\Homework 作业的一些信息用以生成对应文件夹名
     * @param $user common\models\User 用户名用以生成对应文件名
     * @return boolean
     */
    public function upload($model, $homework, $user)
    {
        if ($this->validate()) {
            $rootPath = 'java-homework';
            $homeworkPath = $rootPath . '/' . $homework->order;
            if (!is_dir($homeworkPath)) {
                mkdir($homeworkPath);
            }
            $filePath = $homeworkPath . '/' . $user->real_name . '-' . $this->file->baseName . '.' . $this->file->extension;

            $extraFile = '';
            if (!empty($model->file)) {
                $extraFile = $model->file;
            }
            $model->file = $filePath;
            $model->save();
            if (!empty($extraFile)) {
                unlink($extraFile);
            }
            $this->file->saveAs($filePath);
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file' => '请选择你的代码文件',
        ];
    }
}
