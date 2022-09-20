<?php

namespace app\models;

use Yii;
use app\lib\CommonLib;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property bool $is_deleted
 * @property bool $is_banned
 * @property bool $is_company
 * @property int $vk_id
 * @property int|null $ok_id
 * @property bool $odmin_status
 * @property string|null $email
 * @property int $country_id
 * @property string $phone_original
 * @property string|null $phone_str
 * @property string|null $phone_str1
 * @property string|null $phone_str2
 * @property string $whatsapp
 * @property string $viber
 * @property string $telegram
 * @property bool $gender
 * @property string $name
 * @property string $password
 * @property string $description
 * @property string $address
 * @property string $date
 * @property int $city_id
 * @property int $time_restore_password
 * @property bool $is_need_payment
 * @property string|null $datetime_login
 * @property string|null $datetime_login_vk
 * @property string|null $datetime_login_ok
 * @property string|null $date_banned
 * @property string|null $date_deleted
 * @property string|null $photo
 * @property int $last_news_id
 * @property string|null $referer
 * @property string|null $sub
 * @property bool $is_spiti
 * @property bool $is_av
 * @property bool $is_our
 * @property int $prian_id
 * @property bool $is_ban_checked
 * @property int $amount_posts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'whatsapp', 'viber', 'telegram', 'name', 'password', 'description', 'date', 'city_id', 'prian_id'], 'required'],
            [['id', 'vk_id', 'ok_id', 'country_id', 'city_id', 'time_restore_password', 'last_news_id', 'prian_id', 'amount_posts'], 'default', 'value' => null],
            [['id', 'vk_id', 'ok_id', 'country_id', 'city_id', 'time_restore_password', 'last_news_id', 'prian_id', 'amount_posts'], 'integer'],
            [['is_deleted', 'is_banned', 'is_company', 'odmin_status', 'gender', 'is_need_payment', 'is_spiti', 'is_av', 'is_our', 'is_ban_checked'], 'boolean'],
            [['description'], 'string'],
            [['date', 'datetime_login', 'datetime_login_vk', 'datetime_login_ok', 'date_banned', 'date_deleted'], 'safe'],
            [['email', 'phone_original', 'phone_str', 'phone_str1', 'phone_str2', 'whatsapp', 'viber', 'telegram', 'name', 'password', 'address', 'photo', 'referer', 'sub'], 'string', 'max' => 255],
            [['email'], 'unique'],
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
            'is_deleted' => 'Is Deleted',
            'is_banned' => 'Is Banned',
            'is_company' => 'Is Company',
            'vk_id' => 'Vk ID',
            'ok_id' => 'Ok ID',
            'odmin_status' => 'Odmin Status',
            'email' => 'Email',
            'country_id' => 'Country ID',
            'phone_original' => 'Phone Original',
            'phone_str' => 'Phone Str',
            'phone_str1' => 'Phone Str1',
            'phone_str2' => 'Phone Str2',
            'whatsapp' => 'Whatsapp',
            'viber' => 'Viber',
            'telegram' => 'Telegram',
            'gender' => 'Gender',
            'name' => 'Name',
            'password' => 'Password',
            'description' => 'Description',
            'address' => 'Address',
            'date' => 'Date',
            'city_id' => 'City ID',
            'time_restore_password' => 'Time Restore Password',
            'is_need_payment' => 'Is Need Payment',
            'datetime_login' => 'Datetime Login',
            'datetime_login_vk' => 'Datetime Login Vk',
            'datetime_login_ok' => 'Datetime Login Ok',
            'date_banned' => 'Date Banned',
            'date_deleted' => 'Date Deleted',
            'photo' => 'Photo',
            'last_news_id' => 'Last News ID',
            'referer' => 'Referer',
            'sub' => 'Sub',
            'is_spiti' => 'Is Spiti',
            'is_av' => 'Is Av',
            'is_our' => 'Is Our',
            'prian_id' => 'Prian ID',
            'is_ban_checked' => 'Is Ban Checked',
            'amount_posts' => 'Amount Posts',
        ];
    }

    public function getSrc()
    {
        if (!empty($this->photo)) {
            return '/photos/users/' . $this->photo;
        } else {
            return CommonLib::getAvatarLetter($this->name, $this->id);
        }
    }
}
