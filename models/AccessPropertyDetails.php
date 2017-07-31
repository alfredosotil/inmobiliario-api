<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access_property_details".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $property_details_id
 * @property double $quantity
 * @property integer $active
 *
 * @property Property $property
 * @property PropertyDetails $propertyDetails
 */
class AccessPropertyDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_property_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'property_details_id'], 'required'],
            [['property_id', 'property_details_id', 'active'], 'integer'],
            [['quantity'], 'number'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            [['property_details_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyDetails::className(), 'targetAttribute' => ['property_details_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'property_details_id' => 'Property Details ID',
            'quantity' => 'Quantity',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyDetails()
    {
        return $this->hasOne(PropertyDetails::className(), ['id' => 'property_details_id']);
    }
}
