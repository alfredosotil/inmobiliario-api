<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

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
//            //'class' => HttpBasicAuth::className(), 
//            'class' => HttpBearerAuth::className(), 
//            //'class' => QueryParamAuth::className(),
//            'only' => ['*'],
//        ];
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

}
