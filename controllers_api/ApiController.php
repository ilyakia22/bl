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
    private $isSuperUser = false;
    private $msg = '';
    protected $required = [];
    protected $data = [];

    public function beforeAction($action)
    {
        if (Yii::$app->request->getBodyParam('secret_scrf') != null && md5(Yii::$app->request->getBodyParam('secret_scrf')) === '45db0cb82d0dc8d967c0ef23232bf9f3') {
            $this->enableCsrfValidation = false;
            $this->isSuperUser = true;
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    protected function isSuperUser()
    {
        return $this->isSuperUser;
    }

    protected function checkRequired()
    {
        foreach ($this->required as $field) {
            if (empty($this->data[$field])) {
                $this->msg = $field . ' is required. error 1';
                return false;
            }
        }
        return true;
    }

    protected function request400()
    {
        Yii::$app->response->statusCode = 400;
        return ['error' => $this->msg];
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
