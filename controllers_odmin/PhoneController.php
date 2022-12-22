<?php

namespace app\controllers_odmin;

use app\models\CommentPhone;
use app\models\PhoneSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetaController implements the CRUD actions for Meta model.
 */
class PhoneController extends OdminController
{
    /**
     * Lists all Meta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PhoneSearch::find(),

            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionComments($status = CommentPhone::STATUS_NEW)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CommentPhone::find()->where('status=:status', ['status' => $status]),

            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],

        ]);

        return $this->render('comments', [
            'dataProvider' => $dataProvider,
            'status' => $status,
        ]);
    }

    public function actionSetStatus($id, $goStatus, $status)
    {
        $forum = CommentPhone::findOne($id);
        $forum->updateAttributes(['status' => $status]);
        return $this->redirect(['forum/index', 'status' => $goStatus]);
    }
}
