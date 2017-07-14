<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_details".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $active
 *
 * @property AccessPropertyDetails[] $accessPropertyDetails
 */
class PropertyDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_details';
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
    public function getAccessPropertyDetails()
    {
        return $this->hasMany(AccessPropertyDetails::className(), ['property_details_id' => 'id']);
    }
}
