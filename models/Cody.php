<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cody".
 *
 * @property int $id
 * @property string $value
 * @property string|null $description
 *
 * @property CodyToOrganization[] $codyToOrganizations
 * @property Organization[] $organizations
 */
class Cody extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cody';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value', 'description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[CodyToOrganizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodyToOrganizations()
    {
        return $this->hasMany(CodyToOrganization::class, ['cody_id' => 'id']);
    }

    /**
     * Gets query for [[Organizations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::class, ['id' => 'organization_id'])->viaTable('cody_to_organization', ['cody_id' => 'id']);
    }

    static public function setToOrganization(array $codyValues, int $organization_id)
    {
        $ids = [];
        foreach ($codyValues as $codyValue) {

            $codyValue = trim($codyValue);
            $codyValue = strtolower($codyValue);
            $cody = Cody::findOne(['value' => $codyValue]);
            if ($cody == null) {
                $cody = new Cody;
                $cody->value = $codyValue;
                $cody->save();
            }
            $codyToOrganization = CodyToOrganization::findOne(
                [
                    'cody_id' => $cody->id,
                    'organization_id' => $organization_id
                ]
            );
            if ($codyToOrganization == null) {
                $codyToOrganization = new CodyToOrganization;
                $codyToOrganization->cody_id = $cody->id;
                $codyToOrganization->organization_id = $organization_id;
                $codyToOrganization->save();
            }
            $ids[] = $codyToOrganization->id;
        }
        $allCodyToOrganizations =
            CodyToOrganization::findAll(
                [
                    'organization_id' => $organization_id
                ]
            );
        if (is_array($allCodyToOrganizations)) {
            foreach ($allCodyToOrganizations as $codyToOrganization) {
                if (!in_array($codyToOrganization->id, $ids)) {
                    $codyToOrganization->delete();
                }
            }
        }
    }
}
