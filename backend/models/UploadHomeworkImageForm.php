<?php

namespace backend\models;

use yii\base\Model;
use common\models\Homework;

/**
 * 作业图片上传
 */
class UploadHomeworkImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * 上传操作
     *
     * @param $homework common\models\Homework 作业的一些信息用以生成对应文件夹名
     * @return boolean
     */
    public function upload($homework)
    {
        if ($this->validate()) {
            $rootPath = 'java-homework';
            $homeworkPath = $rootPath . '/' . $homework->order;
            if (!is_dir($homeworkPath)) {
                mkdir($homeworkPath);
            }
            $imagePath = $homeworkPath . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;

            $extraImage = '';
            if (!empty($homework->image)) {
                $extraImage = $homework->image;
            }

            $homework->is_image = Homework::IS_IMAGE_YES;
            $homework->image = $imagePath;
            $homework->updated_at = date("Y-m-d H:i:s");
            if (!$homework->save()) {
                return false;
            }
            if (!empty($extraImage)) {
                unlink($extraImage);
            }
            $this->imageFile->saveAs($imagePath);
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
            'imageFile' => '请选择图片文件',
        ];
    }
}
