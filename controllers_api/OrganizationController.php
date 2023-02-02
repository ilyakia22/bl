<?php

namespace app\controllers_api;

use app\models\Cody;
use app\models\CommentPhone;
use app\models\Organization;
use app\models\OrganizationPhone;
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
        $this->data = Yii::$app->request->bodyParams;
        $this->required = ['name', 'inn', 'ogrnip'];
        if (!$this->checkRequired()) return $this->request400();
        $data = $this->data;

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
        $skip = ['phone', 'cody'];
        foreach ($data as $key => $field) {
            if (in_array($key, $skip)) continue;
            if (mb_strlen($field) != 0) {
                $info[$key] = $field;
            }
        }

        foreach ($info as $key => $value) {
            if (mb_strlen($info[$key]) == 0) unset($info[$key]);
        }
        foreach ($skip as $key) {
            if (isset($info[$key])) unset($info[$key]);
        }
        $organization->info = $info;

        if ($organization->save()) {
            if (is_array($data['cody']))
                Cody::setToOrganization($data['cody'], $organization->id);
            return ['success' => 'ok', 'organization_id' => $organization->id, 'info' => $isNew ? 'added' : 'updated'];
        } else {
            return ['error' => $organization->getErrors()];
        }

        return $this->saveComment(Yii::$app->request->bodyParams);
    }

    public function actionCompanyAdd($data = null)
    {
        if ($data == null)
            $this->data = Yii::$app->request->bodyParams;
        else
            $this->data = $data;
        $this->required = ['name', 'inn', 'ogrn'];
        if (!$this->checkRequired()) return $this->request400();
        $data = $this->data;

        $organization = Organization::find()
            ->where(
                'inn=:inn AND ogrn=:ogrn',
                ['inn' => $data['inn'], 'ogrn' => $data['ogrn']]
            )
            ->one();

        $isNew = false;

        if ($organization == null) {
            $isNew = true;
            $organization = new Organization;
            if (isset($data['is_ip']) && $data['is_ip'] = 1) {
                $organization->type = Organization::TYPE_IP;
                unset($data['is_ip']);
            } else {
                $organization->type = Organization::TYPE_COMPANY;
            }
        }
        $organization->ogrn = $data['ogrn'];
        $organization->inn = $data['inn'];
        $organization->fullname = $data['name'];
        $info = $organization->info;
        if (!is_array($info)) $info = [];

        unset($data['secret_scrf']);
        unset($data['name']);
        unset($data['inn']);
        unset($data['ogrnip']);

        $info = $organization->info;
        $skip = ['phone', 'cody'];
        foreach ($data as $key => $field) {
            if (in_array($key, $skip)) continue;
            if (mb_strlen($field) != 0) {
                $info[$key] = $field;
            }
        }

        foreach ($info as $key => $value) {
            if (mb_strlen($info[$key]) == 0) unset($info[$key]);
        }
        foreach ($skip as $key) {
            if (isset($info[$key])) unset($info[$key]);
        }
        $organization->info = $info;

        if ($organization->save()) {
            if (isset($data['phone']) && !empty($data['phone']))
                OrganizationPhone::add($data['phone'], $organization->id);
            if (isset($data['cody']) && is_array($data['cody']))
                Cody::setToOrganization($data['cody'], $organization->id);
            return ['success' => 'ok', 'organization_id' => $organization->id, 'info' => $isNew ? 'added' : 'updated'];
        } else {
            return ['error' => $organization->getErrors()];
        }
    }

    public function actionCompanyMassAdd()
    {
        $data = Yii::$app->request->bodyParams;
        $return = [];
        foreach ($data['data'] as $k => $row) {
            $return[$k] = $this->actionCompanyAdd($row);
        }
        return $return;
    }
}
