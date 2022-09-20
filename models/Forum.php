<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum".
 *
 * @property int $id
 * @property int|null $internal_id
 * @property bool $type_link
 * @property int $forum_category_id
 * @property int $user_id
 * @property int $city_id
 * @property int $gk_id
 * @property int $region_id
 * @property int $country_id
 * @property int $tpl_id
 * @property int $amount_comment
 * @property int $vote_plus
 * @property int $vote_minus
 * @property bool $status
 * @property string $link
 * @property string|null $user_name
 * @property int $position
 * @property int $datetime_create
 * @property int $datetime_update
 * @property int $datetime_comment
 * @property int $ip
 * @property string $title
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 * @property string $text
 * @property bool $type
 * @property int $site_id
 * @property bool $rating
 */
class Forum extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_APPROVED = 1;
    const STATUS_AD = 2;
    const STATUS_QUERY = 3;
    const STATUS_ABUSE = 4;
    const STATUS_QUERY2 = 5;
    const STATUS_DRAFT = 9;
    const STATUS_DELETED = 10;

    public static $statusAvailable = array(Forum::STATUS_NEW, Forum::STATUS_APPROVED);

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'forum_category_id', 'user_id', 'city_id', 'tpl_id', 'link', 'title', 'meta_title', 'meta_keyword', 'meta_description', 'text'], 'required'],
            [['id', 'internal_id', 'forum_category_id', 'user_id', 'city_id', 'gk_id', 'region_id', 'country_id', 'tpl_id', 'amount_comment', 'vote_plus', 'vote_minus', 'position', 'datetime_create', 'datetime_update', 'datetime_comment', 'ip', 'site_id'], 'default', 'value' => null],
            [['id', 'internal_id', 'forum_category_id', 'user_id', 'city_id', 'gk_id', 'region_id', 'country_id', 'tpl_id', 'amount_comment', 'vote_plus', 'vote_minus', 'position', 'datetime_create', 'datetime_update', 'datetime_comment', 'ip', 'site_id'], 'integer'],
            [['type_link', 'status', 'type', 'rating'], 'boolean'],
            [['text'], 'string'],
            [['link', 'user_name', 'title', 'meta_title', 'meta_keyword', 'meta_description'], 'string', 'max' => 255],
            [['internal_id'], 'unique'],
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
            'internal_id' => 'Internal ID',
            'type_link' => 'Type Link',
            'forum_category_id' => 'Forum Category ID',
            'user_id' => 'User ID',
            'city_id' => 'City ID',
            'gk_id' => 'Gk ID',
            'region_id' => 'Region ID',
            'country_id' => 'Country ID',
            'tpl_id' => 'Tpl ID',
            'amount_comment' => 'Amount Comment',
            'vote_plus' => 'Vote Plus',
            'vote_minus' => 'Vote Minus',
            'status' => 'Status',
            'link' => 'Link',
            'user_name' => 'User Name',
            'position' => 'Position',
            'datetime_create' => 'Datetime Create',
            'datetime_update' => 'Datetime Update',
            'datetime_comment' => 'Datetime Comment',
            'ip' => 'Ip',
            'title' => 'Title',
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'text' => 'Text',
            'type' => 'Type',
            'site_id' => 'Site ID',
            'rating' => 'Rating',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getCity()
    {
        return $this->hasOne(\app\model\City::class, ['id' => 'city_id']);
    }
    public function getRegion()
    {
        return $this->hasOne(\app\model\Region::class, ['id' => 'region_id']);
    }
    public function getCountry()
    {
        return $this->hasOne(\app\model\Country::class, ['id' => 'country_id']);
    }
    public function getTags()
    {
        return $this->hasMany(ForumTag::class, ['id' => 'forum_tag_id'])
            ->viaTable('forum_to_forum_tag', ['forum_id' => 'id']);
    }

    public function getLink()
    {
        return Yii::$app->urlManager->createUrl(['forum/show', 'id' => $this->id, 'title' => $this->title]);
    }

    public function getFormattedText($forUpdate = false)
    {
        return \app\lib\TextLib::ckeDecodeText($this->text, $forUpdate);
    }

    public function isAvailable()
    {
        if (in_array($this->status, Forum::$statusAvailable)) return true;
        return false;
    }
}
