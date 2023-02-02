<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cody_to_organization".
 *
 * @property int $id
 * @property int|null $cody_id
 * @property int|null $organization_id
 *
 * @property Cody $cody
 * @property Organization $organization
 */
class CodyToOrganization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cody_to_organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cody_id', 'organization_id'], 'default', 'value' => null],
            [['cody_id', 'organization_id'], 'integer'],
            [['cody_id', 'organization_id'], 'unique', 'targetAttribute' => ['cody_id', 'organization_id']],
            [['cody_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cody::class, 'targetAttribute' => ['cody_id' => 'id']],
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
            'cody_id' => 'Cody ID',
            'organization_id' => 'Organization ID',
        ];
    }

    /**
     * Gets query for [[Cody]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCody()
    {
        return $this->hasOne(Cody::class, ['id' => 'cody_id']);
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
}
