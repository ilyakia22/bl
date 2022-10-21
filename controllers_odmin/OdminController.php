<?php

namespace app\controllers_odmin;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\lib\CommonLib;

class OdminController extends Controller
{

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
