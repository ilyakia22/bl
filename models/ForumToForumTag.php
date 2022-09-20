<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum_to_forum_tag".
 *
 * @property int $id
 * @property int $forum_id
 * @property int $forum_tag_id
 */
class ForumToForumTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum_to_forum_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'forum_id', 'forum_tag_id'], 'required'],
            [['id', 'forum_id', 'forum_tag_id'], 'default', 'value' => null],
            [['id', 'forum_id', 'forum_tag_id'], 'integer'],
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
            'forum_id' => 'Forum ID',
            'forum_tag_id' => 'Forum Tag ID',
        ];
    }
}
