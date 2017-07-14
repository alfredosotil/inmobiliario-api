<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property".
 *
 * @property integer $id
 * @property integer $property_type_id
 * @property integer $property_state_id
 * @property double $price
 * @property string $money
 * @property double $comission
 * @property double $area
 * @property double $bathroom
 * @property double $bedroom
 * @property string $longitude
 * @property string $latitude
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_start
 * @property string $date_end
 * @property string $owner
 * @property string $owner_email
 * @property string $owner_phone
 * @property string $adress
 * @property string $video_url
 *
 * @property AccessPropertyDetails[] $accessPropertyDetails
 * @property PropertyState $propertyState
 * @property PropertyType $propertyType
 * @property PropertyImages[] $propertyImages
 * @property UserLikeProperty[] $userLikeProperties
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_type_id', 'property_state_id', 'price', 'money', 'comission', 'owner', 'owner_email', 'owner_phone'], 'required'],
            [['property_type_id', 'property_state_id'], 'integer'],
            [['price', 'comission', 'area', 'bathroom', 'bedroom'], 'number'],
            [['created_at', 'updated_at', 'date_start', 'date_end'], 'safe'],
            [['money'], 'string', 'max' => 1],
            [['longitude', 'latitude'], 'string', 'max' => 45],
            [['owner'], 'string', 'max' => 50],
            [['owner_email', 'adress'], 'string', 'max' => 100],
            [['owner_phone'], 'string', 'max' => 20],
            [['video_url'], 'string', 'max' => 150],
            [['property_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyState::className(), 'targetAttribute' => ['property_state_id' => 'id']],
            [['property_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyType::className(), 'targetAttribute' => ['property_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_type_id' => 'Property Type ID',
            'property_state_id' => 'Property State ID',
            'price' => 'Price',
            'money' => 'Money',
            'comission' => 'Comission',
            'area' => 'Area',
            'bathroom' => 'Bathroom',
            'bedroom' => 'Bedroom',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'owner' => 'Owner',
            'owner_email' => 'Owner Email',
            'owner_phone' => 'Owner Phone',
            'adress' => 'Adress',
            'video_url' => 'Video Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessPropertyDetails()
    {
        return $this->hasMany(AccessPropertyDetails::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyState()
    {
        return $this->hasOne(PropertyState::className(), ['id' => 'property_state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyType()
    {
        return $this->hasOne(PropertyType::className(), ['id' => 'property_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyImages()
    {
        return $this->hasMany(PropertyImages::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLikeProperties()
    {
        return $this->hasMany(UserLikeProperty::className(), ['property_id' => 'id']);
    }
}
