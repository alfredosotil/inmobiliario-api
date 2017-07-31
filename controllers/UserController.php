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
class UserController extends ActiveController {

    //put your code here
    public $modelClass = 'app\models\User';
    public $expand = [];

    public function behaviors() {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'except' => ['create', 'login', 'resetpassword'],
//            'class' => HttpBasicAuth::className(),
//            'auth' => function($username, $password) {
//                return \app\models\User::findByUsernameAndPassword($username, $password);
//            },
//            'only' => ['*'],
//        ];
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                [
//            'except' => ['create', 'login', 'resetpassword'],
                    'class' => HttpBasicAuth::className(),
                    'auth' => function($username, $password) {
                        return \app\models\User::findByUsernameAndPassword($username, $password);
                    },
                ],
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
//        $behaviors['access'] = [
//            'class' => AccessControl::className(),
//            'only' => ['*'],
//            'rules' => [
//                [
//                    'actions' => ['*'],
//                    'allow' => true,
//                    'roles' => ['@'],
//                ],
//            ],
//        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];
        return $behaviors;
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate() {
        $model = new $this->modelClass;
        $model->load(Yii::$app->request->post(), '');
        $key = md5((isset($model->password)) ? $model->password : "nodata");
        $access_token = base64_encode("$model->username:$model->password");
        $token = array(
            "id" => uniqid('inmo_', true),
            "iss" => "http://www.inmobiliario.com.pe",
            "aud" => "http://www.inmobiliario.com.pe",
//            "iat" => time(),
//            "nbf" => time() + 60,
//            "exp" => time() + 3600,            
        );
//        $model->birthday = date('Y-m-d', strtotime($this->birthday));
        $model->auth_key = JWT::encode($token, $key);
        $model->access_token = $access_token;
        $model->user_state_id = 1;
        $model->active = 1;
        $model->save();
        return $model;
    }

    public function actionSearch() {
        if (!empty($_GET)) {
            $model = new $this->modelClass;
            foreach ($_GET as $key => $value) {
                if (!$model->hasAttribute($key)) {
                    throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
                }
            }
            try {
                $provider = new ActiveDataProvider([
                    'query' => $model->find()->where($_GET)->with($this->expand)->asArray(),
                    'pagination' => false
                ]);
            } catch (Exception $ex) {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }
//            if ($provider->getCount() <= 0) {
//                throw new \yii\web\HttpException(404, 'No entries found with this query string');
//            } else {
//                return $provider;
//            }
            return $provider;
        } else {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }

    public function actionLogin() {
        $post = Yii::$app->request->post();
        $model = \app\models\User::findOne(["email" => $post["email"]]);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('User not found');
        }
        if ($model->validatePassword($post["password"])) {
//            $model->last_login = Yii::$app->formatter->asTimestamp(date_create());
            $model->save(false);
            return $model; //return whole user model including auth_key or you can just return $model["auth_key"];
        } else {
            throw new \yii\web\ForbiddenHttpException();
        }
    }

}
