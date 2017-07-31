<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $user_type_id
 * @property integer $user_state_id
 * @property string $name
 * @property string $lastname
 * @property string $identificator
 * @property integer $identificator_type_id
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $username
 * @property string $password
 * @property string $sex
 * @property string $birthday
 * @property string $auth_key
 * @property string $access_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $image
 * @property integer $active
 *
 * @property AccessUserControl[] $accessUserControls
 * @property Logs[] $logs
 * @property IdentificatorType $identificatorType
 * @property UserState $userState
 * @property UserType $userType
 * @property UserLikeProperty[] $userLikeProperties
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_type_id', 'user_state_id', 'name', 'lastname', 'identificator', 'identificator_type_id', 'email', 'phone', 'username', 'password'], 'required'],
            [['user_type_id', 'user_state_id', 'identificator_type_id', 'created_at', 'updated_at', 'active'], 'integer'],
            [['birthday'], 'safe'],
            [['name', 'lastname', 'identificator', 'username', 'password', 'access_token'], 'string', 'max' => 50],
            [['email', 'image'], 'string', 'max' => 100],
            [['phone', 'fax'], 'string', 'max' => 20],
            [['sex'], 'string', 'max' => 1],
            [['auth_key'], 'string', 'max' => 400],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['identificator_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => IdentificatorType::className(), 'targetAttribute' => ['identificator_type_id' => 'id']],
            [['user_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserState::className(), 'targetAttribute' => ['user_state_id' => 'id']],
            [['user_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['user_type_id' => 'id']],
        ];
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_type_id' => 'User Type ID',
            'user_state_id' => 'User State ID',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'identificator' => 'Identificator',
            'identificator_type_id' => 'Identificator Type ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'username' => 'Username',
            'password' => 'Password',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'image' => 'Image',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessUserControls() {
        return $this->hasMany(AccessUserControl::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs() {
        return $this->hasMany(Logs::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdentificatorType() {
        return $this->hasOne(IdentificatorType::className(), ['id' => 'identificator_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserState() {
        return $this->hasOne(UserState::className(), ['id' => 'user_state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType() {
        return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLikeProperties() {
        return $this->hasMany(UserLikeProperty::className(), ['user_id' => 'id']);
    }

    public static function findByEmail($email) {
        return User::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password) {
        return $this->password === $password;
    }

    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = NULL) {
        return static::findOne(['access_token' => $token]);
    }

    public function loginByAccessToken($token, $type = null) {
        /* @var $class IdentityInterface */
        $class = $this->identityClass;
        $identity = $class::findIdentityByAccessToken($token, $type);
        if ($identity && $this->login($identity)) {
            return $identity;
        }
        return null;
    }

    public static function findIdentityByAuthKey($authKey, $type = NULL) {
        return static::findOne(['auth_key' => $authKey]);
    }

    public static function findByUsernameAndPassword($username, $password) {
        return User::findOne(['username' => $username, 'password' => $password]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    public function getAccessToken() {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($auth_key) {
        return $this->auth_key === $auth_key;
    }

}
