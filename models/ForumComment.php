<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum_comment".
 *
 * @property int $id
 * @property bool $type_link
 * @property int $root_forum_comment_id
 * @property int $parent_forum_comment_id
 * @property bool $status
 * @property string $md5
 * @property int $forum_id
 * @property int $user_id
 * @property int|null $ip
 * @property int $datetime_create
 * @property string $name
 * @property string $text
 * @property string $note
 */
class ForumComment extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_APPROVED = 1;
    const STATUS_SPAM = 2;
    const STATUS_DELETED = 10;
    const STATUS_DELETED2 = 11;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'md5', 'forum_id', 'datetime_create', 'text', 'note'], 'required'],
            [['id', 'root_forum_comment_id', 'parent_forum_comment_id', 'forum_id', 'user_id', 'ip', 'datetime_create'], 'default', 'value' => null],
            [['id', 'root_forum_comment_id', 'parent_forum_comment_id', 'forum_id', 'user_id', 'ip', 'datetime_create'], 'integer'],
            [['type_link', 'status'], 'boolean'],
            [['text'], 'string'],
            [['md5'], 'string', 'max' => 32],
            [['name', 'note'], 'string', 'max' => 255],
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
            'type_link' => 'Type Link',
            'root_forum_comment_id' => 'Root Forum Comment ID',
            'parent_forum_comment_id' => 'Parent Forum Comment ID',
            'status' => 'Status',
            'md5' => 'Md5',
            'forum_id' => 'Forum ID',
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'datetime_create' => 'Datetime Create',
            'name' => 'Name',
            'text' => 'Text',
            'note' => 'Note',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getFormattedText($forUpdate = false)
    {
        if ($forUpdate) return \app\lib\TextLib::ckeDecodeText($this->text, $forUpdate);
        return nl2br(\app\lib\TextLib::ckeDecodeText($this->text, $forUpdate));
    }
}
