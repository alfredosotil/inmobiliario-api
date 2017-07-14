<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "controller".
 *
 * @property integer $id
 * @property string $controller
 * @property string $name
 * @property string $description
 * @property integer $active
 *
 * @property AccessUserControl[] $accessUserControls
 */
class Controller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'controller';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller'], 'required'],
            [['active'], 'integer'],
            [['controller', 'name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessUserControls()
    {
        return $this->hasMany(AccessUserControl::className(), ['controller_id' => 'id']);
    }
}
