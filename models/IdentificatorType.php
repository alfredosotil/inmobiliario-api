<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "identificator_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $active
 *
 * @property User[] $users
 */
class IdentificatorType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'identificator_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['identificator_type_id' => 'id']);
    }
}
