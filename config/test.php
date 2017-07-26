<?php

$params = require(__DIR__ . '/params.php');
$dbParams = require(__DIR__ . '/test_db.php');

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'components' => [
//        'jwt' => [
//            'class' => 'sizeg\jwt\Jwt',
//            'key' => 'inmobiliario',
//        ],
//        'jwsManager' => [
//            'class' => 'thamtech\jws\components\JwsManager',
//            'pubkey' => '@app/cert/www.inmobiliario.com.pe.crt',
//            'pvtkey' => '@app/cert/www.inmobiliario.com.pe.crt',
        // The settings below are optional. Defaults will be used if not set here.
        //'encoder' => 'Namshi\JOSE\Base64\Base64UrlSafeEncoder',
        //'refreshExp' => '24 hours',
        //'exp' =>  1 hour',
        //'alg' => 'RS256',
        //'jwsClass' => 'Namshi\JOSE\SimpleJWS',
//        ],
        'db' => $dbParams,
        'urlManager' => [
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes, index.php?r=gii
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
//            'suffix' => '.html',
            'rules' => array(
//              http://localhost/path/to/index.php/gii.html
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['property', 'user'], 'extraPatterns' => ['GET search' => 'search'], 'pluralize' => false],
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession' => false,
            'loginUrl' => null,
//            'enableAutoLogin' => true,
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
        ],
    ],
    'params' => $params,
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
    ]
];
