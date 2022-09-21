<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forum_tag".
 *
 * @property int $id
 * @property string $value
 * @property string|null $link
 */
class ForumTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'value'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['value', 'link'], 'string', 'max' => 255],
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
            'value' => 'Value',
            'link' => 'Link',
        ];
    }

    public function getLink($regionLink)
    {
        return Yii::$app->urlManager->createUrl(['forum/tag', 'regionLink' => $regionLink, 'tagLink' => $this->link]);
    }
}
