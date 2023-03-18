<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phone_info".
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 *
 * @property City $city
 */
class PhoneInfo extends \yii\db\ActiveRecord
{
    const STATUS_OK = 0;
    const STATUS_PD = 1;
    public static $statuses = [
        PhoneInfo::STATUS_OK => 'OK',
        PhoneInfo::STATUS_PD => 'PD',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'city_id'], 'default', 'value' => null],
            [['id', 'status', 'city_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
    public function getStatusTitle()
    {
        return PhoneInfo::statusTitle($this->status);
    }
    public static function  statusTitle($status)
    {
        if (isset(PhoneInfo::$statuses[$status])) return PhoneInfo::$statuses[$status];
        return '??';
    }
}
