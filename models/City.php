<?php

namespace app\models;

use Yii;
use app\lib\CommonLib;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property int $country_id
 * @property bool $is_forum
 * @property float|null $x широта latitude
 * @property float|null $y долгота longitude
 * @property string $name
 * @property string $name_v
 * @property string $name_net
 * @property string $name_vin
 * @property int $region_id
 * @property string|null $link
 * @property int $cnt_avito
 * @property bool $is_has_district
 * @property bool $is_vo
 * @property bool $is_vk
 * @property int $vk_id
 * @property string $vk_hash
 * @property bool $vk_is_hide_admin
 * @property bool $vk_is_set_place
 * @property bool $vk_is_main_photo
 * @property int $vk_default_album_id
 * @property int $vk_city_id
 * @property int $vk_amount_users
 * @property string|null $datetime_wall_post
 * @property string|null $datetime_get_info
 * @property string|null $datetime_position_up
 * @property bool $is_double
 * @property string $link_avito
 * @property bool $is_use
 * @property bool $is_ok
 * @property bool $is_on
 * @property string $original_name
 * @property string $synonym
 * @property string $about
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'name', 'name_v', 'name_net', 'link_avito', 'about'], 'required'],
            [['id', 'country_id', 'region_id', 'cnt_avito', 'vk_id', 'vk_default_album_id', 'vk_city_id', 'vk_amount_users'], 'default', 'value' => null],
            [['id', 'country_id', 'region_id', 'cnt_avito', 'vk_id', 'vk_default_album_id', 'vk_city_id', 'vk_amount_users'], 'integer'],
            [['is_forum', 'is_has_district', 'is_vo', 'is_vk', 'vk_is_hide_admin', 'vk_is_set_place', 'vk_is_main_photo', 'is_double', 'is_use', 'is_ok', 'is_on'], 'boolean'],
            [['x', 'y'], 'number'],
            [['datetime_wall_post', 'datetime_get_info', 'datetime_position_up'], 'safe'],
            [['about'], 'string'],
            [['name', 'name_v', 'name_net', 'name_vin', 'link', 'vk_hash', 'link_avito', 'original_name', 'synonym'], 'string', 'max' => 255],
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
            'country_id' => 'Country ID',
            'is_forum' => 'Is Forum',
            'x' => 'X',
            'y' => 'Y',
            'name' => 'Name',
            'name_v' => 'Name V',
            'name_net' => 'Name Net',
            'name_vin' => 'Name Vin',
            'region_id' => 'Region ID',
            'link' => 'Link',
            'cnt_avito' => 'Cnt Avito',
            'is_has_district' => 'Is Has District',
            'is_vo' => 'Is Vo',
            'is_vk' => 'Is Vk',
            'vk_id' => 'Vk ID',
            'vk_hash' => 'Vk Hash',
            'vk_is_hide_admin' => 'Vk Is Hide Admin',
            'vk_is_set_place' => 'Vk Is Set Place',
            'vk_is_main_photo' => 'Vk Is Main Photo',
            'vk_default_album_id' => 'Vk Default Album ID',
            'vk_city_id' => 'Vk City ID',
            'vk_amount_users' => 'Vk Amount Users',
            'datetime_wall_post' => 'Datetime Wall Post',
            'datetime_get_info' => 'Datetime Get Info',
            'datetime_position_up' => 'Datetime Position Up',
            'is_double' => 'Is Double',
            'link_avito' => 'Link Avito',
            'is_use' => 'Is Use',
            'is_ok' => 'Is Ok',
            'is_on' => 'Is On',
            'original_name' => 'Original Name',
            'synonym' => 'Synonym',
            'about' => 'About',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(\app\models\Region::class, ['id' => 'region_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(\app\models\Country::class, ['id' => 'country_id']);
    }

    public function getLink()
    {
        if (empty($this->link)) {
            $this->link = CommonLib::str2url($this->name);
            $tmpLink = $this->link;
            $i = 0;
            do {
                $checkRegion = self::find()->where('link LIKE :link AND id!=:id', array('link' => $tmpLink, 'id' => $this->id))->one();
                if ($checkRegion != null) {
                    $tmpLink = $this->link . '-' . ++$i;
                }
            } while ($checkRegion != null);
            $this->link = $tmpLink;
            $this->update(['link']);
        }
        return Yii::$app->urlManager->createUrl(['forum/city', 'link' => $this->link]);
    }
}
