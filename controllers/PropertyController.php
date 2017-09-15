<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\Cors;
use \Firebase\JWT\JWT;

/**
 * Description of UserController
 *
 * @author asotilp
 */
class PropertyController extends ActiveController {

    //put your code here
    public $modelClass = 'app\models\Property';
    public $expand = [];

    public function behaviors() {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => CompositeAuth::className(),
////            'except' => [''],
//            'authMethods' => [
////                [
////                    'class' => HttpBasicAuth::className(),
////                    'auth' => function($username, $password) {
////                        return \app\models\User::findByUsernameAndPassword($username, $password);
////                    },
////                ],
//                HttpBearerAuth::className(),
//                QueryParamAuth::className(),
//            ],
//        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
            ],
        ];
        return $behaviors;
    }

//    public function actions() {
//        $actions = parent::actions();
//        unset($actions['create']);
//        return $actions;
//    }
//    public function actionCreate() {
//        $model = new $this->modelClass;
//        $model->load(Yii::$app->request->post(), '');
//        $key = md5((isset($model->password)) ? $model->password : "nodata");
//        $access_token = base64_encode("$model->username:$model->password");
//        $token = array(
//            "id" => uniqid('inmo_', true),
//            "iss" => "http://www.inmobiliario.com.pe",
//            "aud" => "http://www.inmobiliario.com.pe",
////            "iat" => time(),
////            "nbf" => time() + 60,
////            "exp" => time() + 3600,            
//        );
////        $model->birthday = date('Y-m-d', strtotime($this->birthday));
//        $model->auth_key = JWT::encode($token, $key);
//        $model->access_token = $access_token;
//        $model->user_state_id = 1;
//        $model->active = 1;
//        $model->save();
//        return $model;
//    }

    public function actionSearch() {
        if (!empty($_GET)) {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) {
                if (!$model->hasAttribute($key)) {
                    throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try {
                return $model->find()->select('*')->where($_GET)->with($this->expand)->asArray()->all();
//                $provider = new ActiveDataProvider([
//                    'query' => $model->find()->select('name')->where($_GET)->with($this->expand)->asArray(),
//                    'pagination' => false
//                ]);
            } catch (Exception $ex) {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }
//            if ($provider->getCount() <= 0) {
//                throw new \yii\web\HttpException(404, 'No entries found with this query string');
//            } else {
//                return $provider;
//            }
//            return $provider;
        } else {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }

    public function actionCreatedetailsproperty() {
        $result = [];
        if (Yii::$app->request->isPost) {
            $propertyId = Yii::$app->request->post('property');
            $details = Yii::$app->request->post('details');
            foreach ($details as $value) {
                $apd = new \app\models\AccessPropertyDetails();
                $apd->property_id = $propertyId;
                $apd->property_details_id = $value;
                if ($apd->save()) {
                    array_push($result, $value);
                }
            }
        }
        return $result;
    }

    public function actionCreateimgproperty() {        
        $result = [];
        if (Yii::$app->request->isPost) {
            $propertyId = Yii::$app->request->post('property');
            $$imgs = Yii::$app->request->post('imgs');
            foreach ($$imgs as $value) {
                $pi = new \app\models\PropertyImages();
                $pi->property_id = $propertyId;
                $pi->name = $value;
                if ($pi->save()) {
                    array_push($result, $value);
                }
            }
        }
        return $result;
    }

    public function actionGetlistpropertytype() {
        return (new \app\models\PropertyType())->find()->asArray()->all();
    }

    public function actionGetlistpropertystate() {
        return (new \app\models\PropertyState())->find()->asArray()->all();
    }

    public function actionGetlistdetailsproperty() {
        return (new \app\models\PropertyDetails())->find()->asArray()->all();
    }

}
