<?php

namespace app\controllers_odmin;

use app\models\CommentPhone;
use app\models\PhoneInfo;
use app\models\PhoneSearch;
use app\lib\PhoneTool;
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
        $commentPhone = CommentPhone::findOne($id);
        $commentPhone->updateAttributes(['status' => $status]);
        return $this->redirect(['phone/comments', 'status' => $goStatus]);
    }


    public function actionSetStatusPhoneInfo($phone, $status)
    {
        $phoneInfo = PhoneInfo::findOne($phone);
        if ($phoneInfo == null) {
            if ($status == PhoneInfo::STATUS_PD) {
                $phoneInfo = new PhoneInfo;
                $phoneInfo->name = 'PD';
                $phoneInfo->id = PhoneTool::phoneIn($phone);
                $phoneInfo->city_id = null;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        $phoneInfo->status = $status;
        if (!$phoneInfo->save()) {

            throw new NotFoundHttpException('The requested page does not exist.');
        }
        die(json_encode(['status' => $status, 'statusTitle' => PhoneInfo::statusTitle($status), 'phone' => $phone]));
    }
}
