<?php

namespace app\controllers_api;

use app\models\CommentPhone;
use app\models\Organization;
use yii\web\Controller;
use Yii;

class OrganizationController extends ApiController
{
    public function actionIndex()
    {
        return ['org1', 'org2'];
    }


    public function actionIpAdd()
    {
        $this->required = ['name', 'inn', 'ogrnip'];
        if (!$this->checkRequired()) return $this->request400();

        $data = Yii::$app->request->bodyParams;

        $organization = Organization::find()
            ->where(
                'inn=:inn AND ogrn=:ogrn',
                ['inn' => $data['inn'], 'ogrn' => $data['ogrnip']]
            )
            ->one();
        $isNew = false;
        if ($organization == null) {
            $isNew = true;
            $organization = new Organization;
            $organization->type = Organization::TYPE_IP;
        }
        $organization->ogrn = $data['ogrnip'];
        $organization->inn = $data['inn'];
        $organization->fullname = $data['name'];
        $info = $organization->info;
        if (!is_array($info)) $info = [];

        unset($data['secret_scrf']);
        unset($data['name']);
        unset($data['inn']);
        unset($data['ogrnip']);

        $info = $organization->info;

        foreach ($data as $key => $field) {
            if (mb_strlen($field) != 0) {
                $info[$key] = $field;
            }
        }

        foreach ($info as $key => $value) {
            if (mb_strlen($info[$key]) == 0) unset($info[$key]);
        }


        $organization->info = $info;

        if ($organization->save()) {
            return ['success' => 'ok', 'organization_id' => $organization->id, 'info' => $isNew ? 'added' : 'updated'];
        } else {
            return ['error' => $organization->getErrors()];
        }

        return $this->saveComment(Yii::$app->request->bodyParams);
    }
}
