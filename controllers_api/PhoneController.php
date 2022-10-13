<?php

namespace app\controllers_api;

use app\models\CommentPhone;
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
}
