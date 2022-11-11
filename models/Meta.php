<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "meta".
 *
 * @property int $id
 * @property bool $is_ok
 * @property bool $is_use_current
 * @property string $url
 * @property string $title
 * @property string $alt
 * @property string $description
 * @property string $keyword
 * @property string $h1
 * @property string $text_top
 * @property string $text_bottom
 * @property string $google_search
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['id'], 'integer'],
            [['is_ok', 'is_use_current'], 'boolean'],
            [['description', 'text_top', 'text_bottom', 'google_search'], 'string'],
            [['url', 'title', 'alt', 'keyword', 'h1'], 'string', 'max' => 255],
            [['url'], 'unique'],
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
            'is_ok' => 'Is Ok',
            'is_use_current' => 'Is Use Current',
            'url' => 'Url',
            'title' => 'Title',
            'alt' => 'Alt',
            'description' => 'Description',
            'keyword' => 'Keyword',
            'h1' => 'H1',
            'text_top' => 'Text Top',
            'text_bottom' => 'Text Bottom',
            'google_search' => 'Google Search',
        ];
    }
}
