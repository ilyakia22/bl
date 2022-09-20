<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $name
 * @property string $name_v
 * @property string $name_net
 * @property string|null $link
 * @property string $link_old
 * @property string $text
 * @property int $vk_id
 * @property string $vk_name
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'name_v', 'name_net', 'link_old', 'text', 'vk_name'], 'required'],
            [['id', 'vk_id'], 'default', 'value' => null],
            [['id', 'vk_id'], 'integer'],
            [['text'], 'string'],
            [['name', 'name_v', 'name_net', 'link', 'link_old', 'vk_name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'name_v' => 'Name V',
            'name_net' => 'Name Net',
            'link' => 'Link',
            'link_old' => 'Link Old',
            'text' => 'Text',
            'vk_id' => 'Vk ID',
            'vk_name' => 'Vk Name',
        ];
    }
}
