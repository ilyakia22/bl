<?php

namespace app\controllers_api;

use app\models\CommentPhone;
use app\models\PhoneInfo;
use app\models\City;
use yii\web\Controller;
use Yii;

class PhoneController extends ApiController
{
    public function actionCommentIndex()
    {
        return ['a', 'b'];
    }

    protected function saveComment($data)
    {
        if ($this->isSuperUser() && isset($data['global_id'])) {
            $commentPhone = CommentPhone::find()
                ->where(
                    'phone_number=:phone AND global_id=:global_id',
                    [
                        'phone' => CommentPhone::getPhoneIn($data['phone']),
                        'global_id' => $data['global_id']
                    ]
                )->one();
        }

        if ($commentPhone == null) {
            $commentPhone = new CommentPhone;
        }

        $commentPhone->name = $data['name'];
        $commentPhone->comment = $data['comment'];
        $commentPhone->phone_number = $data['phone'];
        $commentPhone->type = $data['type'];

        if ($this->isSuperUser() && isset($data['global_id']))
            $commentPhone->global_id = $data['global_id'];

        if ($this->isSuperUser() && isset($data['status']))
            $commentPhone->status = $data['status'];

        if ($this->isSuperUser() && isset($data['datetime']))
            $commentPhone->datetime = $data['datetime'];

        if ($this->isSuperUser())
            $commentPhone->secret = 'superuser';

        if ($commentPhone != null && empty($data['comment'])) {
            $commentPhone->delete();
            return ['success' => 'ok'];
        } else if ($commentPhone->save()) {
            return ['success' => 'ok'];
        } else {
            return ['error' => $commentPhone->getErrors()];
        }
    }

    public function actionCommentAdd()
    {
        $this->required = ['comment', 'phone', 'type', 'name'];

        if (!$this->checkRequired()) return $this->request400();

        return $this->saveComment(Yii::$app->request->bodyParams);
    }
    public function actionInfoMassAdd()
    {
        $data = Yii::$app->request->bodyParams;
        $return = [];
        foreach ($data['rows'] as $row) {
            $return[$row['phone']] = $this->actionInfoAdd($row);
        }
        return $return;
    }

    public function actionInfoAdd($data = null)
    {
        $this->required = ['city_id', 'name', 'phone'];
        if ($data == null)
            $this->data = Yii::$app->request->bodyParams;
        else
            $this->data = $data;

        if (!$this->checkRequired()) return $this->request400();

        $phoneInfo = PhoneInfo::find()
            ->where('id=:id', ['id' => $this->data['phone']])->one();

        if ($phoneInfo == null)
            $phoneInfo = new PhoneInfo;

        $phoneInfo->id = $this->data['phone'];
        $phoneInfo->city_id = $this->data['city_id'];
        $phoneInfo->name = $this->data['name'];

        $city = City::findOne($this->data['city_id']);
        if (!empty($this->data['comment'])) {
            $dataComment = [];
            $dataComment['name'] = $this->data['name'];
            $dataComment['phone'] = $this->data['phone'];
            $dataComment['type'] = 1;
            $dataComment['status'] = 1;
            $dataComment['datetime'] = $this->data['datetime'];
            $dataComment['global_id'] = 'info';
            $dataComment['comment'] = $this->data['comment'];
            $saveComment = $this->saveComment($dataComment);
            if (isset($saveComment['error'])) return $saveComment;
        }

        if ($phoneInfo->save()) {
            return ['success' => 'ok'];
        } else {
            return ['error' => $phoneInfo->getErrors()];
        }
    }
}
