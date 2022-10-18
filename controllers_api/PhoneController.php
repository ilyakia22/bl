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

        if ($commentPhone->save()) {
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

    public function actionInfoAdd()
    {
        $this->required = ['city_id', 'name', 'phone', 'comment'];
        if (!$this->checkRequired()) return $this->request400();

        $data = Yii::$app->request->bodyParams;

        $phoneInfo = PhoneInfo::find()
            ->where('id=:id', ['id' => $data['phone']])->one();

        if ($phoneInfo == null)
            $phoneInfo = new PhoneInfo;

        $phoneInfo->id = $data['phone'];
        $phoneInfo->city_id = $data['city_id'];
        $phoneInfo->name = $data['name'];

        $city = City::findOne($data['city_id']);
        $dataComment = [];
        $dataComment['name'] = $data['name'];
        $dataComment['phone'] = $data['phone'];
        $dataComment['type'] = 1;
        $dataComment['status'] = 1;
        $dataComment['datetime'] = $data['datetime'];
        $dataComment['global_id'] = 'info';
        $dataComment['comment'] = $data['comment'];

        $saveComment = $this->saveComment($dataComment);

        if (isset($saveComment['error'])) return $saveComment;

        if ($phoneInfo->save()) {
            return ['success' => 'ok'];
        } else {
            return ['error' => $phoneInfo->getErrors()];
        }
    }
}
