<?php

/**
 * Proxy PHP file generated by Composer
 *
 * This file includes the referenced bin path (../cebe/markdown/bin/markdown)
 * using a stream wrapper to prevent the shebang from being output on PHP<8
 *
 * @generated
 */

namespace app\controllers;

use app\models\CommentPhone;
use Yii;
use FrontEndCotroller;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Forum;
use app\models\Cody;
use app\models\Organization;
use yii\data\Pagination;


/**
 * Implements hook_help().
 */
class SiteController extends FrontEndController
{
    public function actionTest()
    {

        $cody = Cody::find('value=:value', ['value' => '41.20'])->one();
        print_r($cody);
        $cody = Cody::find('value=:value', ['value' => '41.20'])->one();
        print_r($cody);
        exit;
        $data = ['secret_scrf' => 'xxxyyyiii'];
        $row = [];
        $data['name'] = 'name23';
        $data['city_id'] = 28;
        $data['phone'] = '9997776644';
        $data['datetime'] = 1665600666; //1665691467

        // $data['comments1'] = [];
        // $data['comments1'][] = $row;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://bl-front.xx/api.php/phone/info");
        //curl_setopt($ch, CURLOPT_URL, "http://ya.ru");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        print_r($info);
        print_r($server_output);

        exit;
        $data = ['secret_scrf' => 'xxxyyyiii'];
        $row = [];
        $data['name'] = 'name23';
        $data['comment'] = 'comment23';
        $data['phone'] = '9997776644';
        $data['type'] = 1;
        $data['datetime'] = 1665691666; //1665691467
        $data['global_id'] = '100_1';
        $data['status'] = 1;
        // $data['comments1'] = [];
        // $data['comments1'][] = $row;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://bl-front.xx/api.php/phone/comment");
        //curl_setopt($ch, CURLOPT_URL, "http://ya.ru");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        print_r($info);
        // print_r($error);

        print_r($server_output);
        exit;
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $connection = Yii::$app->db;
        //     $command = $connection->CreateCommand("SELECT * FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND  schemaname != 'information_schema';");
        //     $rows = $command->queryAll();
        //     print_r($rows);
        //     exit;
        //     $connection = Yii::$app->db;
        //     $command = $connection->CreateCommand("SELECT * FROM city;");
        //     $rows = $command->queryAll();
        //     foreach ($rows as $row){
        //         echo $row['name']."<br>";
        //     }
        //     exit;
        // $city = City::findOne(28);
        // print_r($city);
        // exit;
        // $meta = Meta::find('url LIKE \'index\'');
        // $this->view->title = '111';

        $forums = Forum::find()->where('tpl_id=0 AND status=:status', ['status' => Forum::STATUS_APPROVED])->orderBy('datetime_create DESC')->limit(10)->all();

        $organizations = Organization::find()->select('fullname, ogrn, type, inn')->orderBy('id DESC')->limit(12)->all();

        // $criteria = new CDbCriteria;
        // $criteria->limit = '30';
        // $criteria->order = 'datetime DESC';
        // $commentPhones = CommentPhone::model()->findAll($criteria);

        // $amountComment = CommentPhone::model()->count('status=:status', ['status' => CommentPhone::STATUS_OK]);
        // $amountPages = ceil($amountComment / 60);

        // $query = CommentPhone::find()->where(['status' => CommentPhone::STATUS_OK]);
        // $countQuery = clone $query;
        // $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 60, 'route' => 'phone/index']);
        // $commentPhones = $query->offset($pages->offset)
        //     ->limit($pages->limit)
        //     ->all();
        $commentPhones = CommentPhone::find()->where('status=:status', ['status' => CommentPhone::STATUS_OK])->orderBy('datetime DESC')->limit(30)->all();

        $this->metaUrl = 'index';
        $this->canonical = '/';

        return $this->render('index', ['forums' => $forums, 'organizations' => $organizations, 'commentPhones' => $commentPhones]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSearch()
    {

        $s = preg_replace('/[^0-9]/', '', Yii::$app->request->post('s'));
        if (strlen($s) == 10 || strlen($s) == 11) {
            if (substr($s, 0, 1) == '7' && strlen($s) == 11) {
                $s = substr($s, -10);
            }
            return $this->redirect(['phone/info', 'number' => '7' . $s]);
        }

        $this->setError('Информация не найдена');
        return $this->redirect(['site/index']);
    }
}
