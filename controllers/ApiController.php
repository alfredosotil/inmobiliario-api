<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ImgUser;
use app\models\ImgProperty;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;

class ApiController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['dashboard'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        return $behaviors;
    }

    public function actionUploadimgproperty() {
        $response = [
            'jwt' => 'U3UvsPYGRWZJv8NGW2I-eTiT-ZUk9OmT',
        ];
        $model = new ImgProperty();

        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $response['saved'] = 'yes';
            } else {
                $response['saved'] = 'no';
            }
        }
        return $response;
    }

    public function actionUploadimguser() {
        $response = [
            'jwt' => 'U3UvsPYGRWZJv8NGW2I-eTiT-ZUk9OmT',
        ];
        $model = new ImgUser();

        if (Yii::$app->request->isPost) {
            if ($model->upload()) {
                $response['saved'] = 'yes';
            } else {
                $response['saved'] = 'no';
            }
        }
        return $response;
    }

    public function actionLogin() {
//        $str = '';
//        foreach (Yii::$app->getRequest()->getBodyParams() as $key => $value) {
//            $str .= "$key: $value, ";
//        }
//        return ['access_token' => $str];
        $model = new LoginForm();
//        $model->email = 'alfredo_sotil@hotmail.com';//Yii::$app->request->getBodyParam('email');
//        $model->password = 'amorciego';//Yii::$app->request->getBodyParam('password');
//                return ['access_token' => Yii::$app->request->getBodyParam('email')];

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['auth_key' => Yii::$app->user->identity->getAuthKey()];
//            return ['access_token' => '1234567890'];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionDashboard() {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];
        return $response;
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'There was an error sending email.',
                    ]
                ];
            }
            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }

}
