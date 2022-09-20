<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Meta;
use app\lib\CommonLib;
use yii\helpers\Url;

class FrontEndController extends Controller
{


    protected $metaUrl = null;
    protected $metaFrom = [];
    protected $metaTo = [];
    protected $canonical = null;
    protected $h1 = null;
    protected $pageTitle = null;
    protected $pageKeywords = null;
    protected $pageDescription = null;
    // protected $cityV = null;
    // protected $regionV = null;
    // protected $countryV = null;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function render($view, $params = [])
    {
        $this->setMeta();
        $this->setCanonical();
        if (!empty($this->h1)) $this->view->params['h1'] = $this->h1;
        return parent::render($view, $params);
    }

    private function setMeta()
    {
        if (empty($this->metaUrl)) {
            if (!empty($this->pageTitle)) $this->view->title = $this->pageTitle;
            if (!empty($this->pageKeywords)) $this->view->registerMetaTag(['name' => 'keywords', 'content' => $this->pageKeywords]);
            if (!empty($this->pageDescription)) $this->view->registerMetaTag(['name' => 'description', 'content' => $this->pageDescription]);
        } else {
            $meta = Meta::findOne(['url' => $this->metaUrl]);
            if ($meta == null) return false;
            $this->view->title = $meta->title;
            $this->view->title = str_replace($this->metaFrom, $this->metaTo, $this->view->title);
        }
        // $this->pageDescription = str_replace($from, $to, $this->pageDescription);
        // $this->pageKeywords = str_replace($from, $to, $this->pageKeywords);
        // $this->h1 = str_replace($from, $to, $this->h1);
        // $this->textTop = str_replace($from, $to, $this->textTop);
        // $this->textBottom = str_replace($from, $to, $this->textBottom);
    }
    private function setCanonical()
    {
        if ($this->canonical == null) return false;
        \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::to($this->canonical, true)]); //Url::to(['hello'], true)
    }
}
