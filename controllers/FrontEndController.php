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
    protected $metaReplace = [];
    protected $canonical = null;
    protected $h1 = null;
    protected $pageTitle = null;
    protected $pageKeywords = null;
    protected $pageDescription = null;
    public $errorMessage = '';
    public $noticeMessage = '';
    public $successMessage = '';

    public function setNotice($message)
    {
        return Yii::$app->session->setFlash('notice', $message);
    }

    public function setSuccess($message)
    {
        return Yii::$app->session->setFlash('success', $message);
    }

    public function setError($message)
    {
        return Yii::$app->session->setFlash('error', $message);
    }

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

    public function beforeAction($action)
    {
        $countr = Yii::$app->request->cookies->get('countr');

        Yii::$app->params['countr'] = $countr;
        if (!preg_match('/[0-9a-zA-Z]{32}/', $countr)) {;
            Yii::$app->params['countr'] = mb_substr(time() . md5(Yii::$app->getRequest()->getUserIP()), 0, 32);
            $cookie = new \yii\web\Cookie([
                'name' => 'countr',
                'value' => Yii::$app->params['countr'],
                'expire' => time() + 60 * 60 * 24 * 365
            ]);
            Yii::$app->response->cookies->add($cookie);
        }

        return parent::beforeAction($action);
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
        if (count($this->metaReplace) > 0) {
            $this->metaFrom = array_keys($this->metaReplace);
            $this->metaTo = array_values($this->metaReplace);
        }
        if (!empty($this->metaUrl)) {
            $meta = Meta::findOne(['url' => $this->metaUrl]);
            if ($meta == null) return false;
            $this->pageTitle = str_replace($this->metaFrom, $this->metaTo, $meta->title);
            $this->pageKeywords = str_replace($this->metaFrom, $this->metaTo, $meta->keyword);
            $this->pageDescription = str_replace($this->metaFrom, $this->metaTo, $meta->description);
            $this->h1 = str_replace($this->metaFrom, $this->metaTo, $meta->h1);
        }

        if (!empty($this->pageTitle)) $this->view->title = $this->pageTitle;
        if (!empty($this->pageKeywords)) $this->view->registerMetaTag(['name' => 'keywords', 'content' => $this->pageKeywords]);
        if (!empty($this->pageDescription)) $this->view->registerMetaTag(['name' => 'description', 'content' => $this->pageDescription]);
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
