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
    const TYPE_COMPANY = 3;
    public static $typeTitles = [
        Organization::TYPE_MAN => 'Физлицо',
        Organization::TYPE_IP => 'Индивидуальный предприниматель',
        Organization::TYPE_COMPANY => 'Компания'
    ];

    public static $infoTitles = [
        'name_en' => 'Иностранное название',
        'date_reg' => 'Дата регистрации',
        'country_reg' => 'Страна регистрации',
        'is_small' => 'Малое предприятие',
        'address' => 'Адрес',
        'email' => 'Email',
        'site' => 'Site',
        'cody' => 'Коды по ОКВЭД',
        'date_beg_eis' => 'Дата регистрации в ЕИС',
        'date_end_eis' => 'Дата прекращения в ЕИС',
        'phone' => 'Телефон',
        'kpp' => 'КПП',
        'man_fio' => 'ФИО',
        'man_job_title' => 'Должность',
        'man_inn' => 'ИНН',
    ];


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
    public function getCodys()
    {
        return $this->hasMany(Cody::class, ['id' => 'cody_id'])->viaTable('cody_to_organization', ['organization_id' => 'id']);
    }

    public function getTypeTitle()
    {
        if (isset(self::$typeTitles[$this->type])) return self::$typeTitles[$this->type];
        else return false;
    }

    public function getOgrnTitle()
    {
        if ($this->type == Organization::TYPE_IP) return 'ОГРНИП';
        return 'ОГРН';
    }

    public function getInfoByKey($idx)
    {
        if (!isset($this->info[$idx])) return false;
        if ($idx == 'is_small') {
            if (in_array($this->info[$idx], [0, '0'])) return 'Нет';
            else if (in_array($this->info[$idx], [1, '1'])) return 'Да';
        }
        return $this->info[$idx];
    }

    public function getUrl()
    {
        if ($this->type == Self::TYPE_IP) return Yii::$app->urlManager->createUrl(['organization/ip', 'ogrnip' => $this->ogrn]);
        if ($this->type == Self::TYPE_COMPANY) return Yii::$app->urlManager->createUrl(['organization/company', 'ogrn' => $this->ogrn]);
    }
}
