<?php

namespace app\controllers_api;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\lib\CommonLib;

class ApiController extends Controller
{
    public function beforeAction($action)
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    // public function actionError()
    // {
    //     // $exception = Yii::$app->errorHandler->exception;
    //     // if ($exception !== null) {
    //     //     return  ['exception' => $exception];
    //     // }
    //     throw new \yii\web\NotFoundHttpException();
    // }
}
