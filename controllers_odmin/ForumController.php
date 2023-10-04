<?php

namespace app\controllers_odmin;

use app\models\Forum;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetaController implements the CRUD actions for Meta model.
 */
class ForumController extends OdminController
{
    /**
     * @inheritDoc
     */


    /**
     * Lists all Meta models.
     *
     * @return string
     */
    public function actionIndex($status = Forum::STATUS_NEW)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Forum::find()->where('status=:status', ['status' => $status]),
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'status' => $status
        ]);
    }

    public function actionSetStatus($id, $goStatus, $status)
    {
        $forum = Forum::findOne($id);
        $forum->updateAttributes(['status' => $status]);
        return $this->redirect(['forum/index', 'status' => $goStatus]);
    }

    public function actionEdit($forum_id)
    {
        $model = Forum::findOne($forum_id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', "forum updated");
            return $this->redirect(['forum/edit', 'forum_id' => $forum_id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }
}
