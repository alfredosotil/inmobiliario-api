<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;

class ImgUser extends Model {

    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules() {
        return [
            [['imageFile'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, gif, png'],
        ];
    }

    public function upload() {
        $this->imageFile = UploadedFile::getInstanceByName('file');
        if (empty($this->imageFile)) {
            return false;
        }
        $ext = end((explode(".", $this->imageFile->name)));
        $filename = Yii::$app->security->generateRandomString() . ".{$ext}";
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::$app->basePath . Yii::$app->params['sourceDirUser'] . $filename);
            Image::thumbnail(Yii::$app->basePath . Yii::$app->params['sourceDirUser'] . $filename, 524, 354)
                    ->save(Yii::$app->basePath . Yii::$app->params['sourceDirUser'] . 'md_' . $filename, ['quality' => 100]);
            Image::thumbnail(Yii::$app->basePath . Yii::$app->params['sourceDirUser'] . $filename, 140, 80)
                    ->save(Yii::$app->basePath . Yii::$app->params['sourceDirUser'] . 'sm_' . $filename, ['quality' => 100]);
            return true;
        } else {
            return false;
        }
    }

}
