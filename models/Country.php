<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property bool $is_abroad
 * @property string|null $link
 * @property string $name
 * @property string $name_v
 * @property string $name_net
 * @property string $name_vin
 * @property string $phone_code
 * @property string $phone_mask
 * @property string $iso_code
 * @property string $v_vo_na
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'name_v', 'name_net', 'name_vin', 'phone_code', 'phone_mask', 'v_vo_na'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['is_abroad'], 'boolean'],
            [['link', 'name', 'name_v', 'name_net', 'name_vin', 'phone_code', 'phone_mask'], 'string', 'max' => 255],
            [['iso_code', 'v_vo_na'], 'string', 'max' => 2],
            [['name'], 'unique'],
            [['link'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_abroad' => 'Is Abroad',
            'link' => 'Link',
            'name' => 'Name',
            'name_v' => 'Name V',
            'name_net' => 'Name Net',
            'name_vin' => 'Name Vin',
            'phone_code' => 'Phone Code',
            'phone_mask' => 'Phone Mask',
            'iso_code' => 'Iso Code',
            'v_vo_na' => 'V Vo Na',
        ];
    }
}
