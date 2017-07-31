<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access_user_control".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $controller_id
 * @property integer $active
 *
 * @property Controller $controller
 * @property User $user
 */
class AccessUserControl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_user_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'controller_id'], 'required'],
            [['user_id', 'controller_id', 'active'], 'integer'],
            [['controller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Controller::className(), 'targetAttribute' => ['controller_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'controller_id' => 'Controller ID',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getController()
    {
        return $this->hasOne(Controller::className(), ['id' => 'controller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
