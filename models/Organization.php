<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $fullname
 * @property string|null $shortname
 * @property int|null $ogrn
 * @property int|null $ogrnip
 * @property int|null $type
 * @property string|null $info
 *
 * @property OrganizationPhone[] $organizationPhones
 */
class Organization extends \yii\db\ActiveRecord
{
    const TYPE_MAN = 1;
    const TYPE_IP = 2;
    const TYPE_OOO = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname'], 'required'],
            [['ogrn', 'type'], 'default', 'value' => null],
            [['ogrn', 'type'], 'integer'],
            [['info'], 'safe'],
            [['fullname', 'shortname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'shortname' => 'Shortname',
            'ogrn' => 'Ogrn',
            'ogrnip' => 'Ogrnip',
            'type' => 'Type',
            'info' => 'Info',
        ];
    }

    /**
     * Gets query for [[OrganizationPhones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationPhones()
    {
        return $this->hasMany(OrganizationPhone::class, ['organization_id' => 'id']);
    }
}
