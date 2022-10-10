<?php

namespace app\controllers_api;

use app\models\CommentPhone;
use yii\web\Controller;
use Yii;


class TestController extends ApiController
{


    public function actionTest()
    {
        // echo 5;
        // echo Yii::$app->urlManager->createUrl(['site/test']);
        return [['id' => 2], ['id' => 5]];
        //print_r($this->viewPath);
        exit;
    }
}
