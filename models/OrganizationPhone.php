<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_phone".
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int|null $number
 *
 * @property Organization $organization
 */
class OrganizationPhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'number'], 'default', 'value' => null],
            [['organization_id', 'number'], 'integer'],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'number' => 'Number',
        ];
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    static public function add($number, $organization_id, $note = null)
    {
        $organizationPhone = Organization::find(
            'number=:number AND orgranization_id=:organization_id',
            [
                'number' => $number,
                'orgranization_id' => $organization_id
            ]
        );
        if ($organizationPhone == null) {
            $organizationPhone = new OrganizationPhone;
        }
        $organizationPhone->number = $number;
        $organizationPhone->organization_id = $organization_id;
        $organizationPhone->note = $note;
        return $organizationPhone->save();
    }
}
