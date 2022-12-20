<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phone_search".
 *
 * @property int $id
 * @property int $phone_number
 * @property string $secret
 * @property int|null $status
 */
class PhoneSearch extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_OK = 2;
    const STATUS_DELETED = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone_search';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number'], 'required'],
            [['phone_number', 'status'], 'default', 'value' => null],
            [['phone_number', 'status', 'ip', 'datetime'], 'integer'],
            [['secret'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_number' => 'Phone Number',
            'secret' => 'Secret',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->status = self::STATUS_NEW;
            $this->ip = ip2long(Yii::$app->getRequest()->getUserIP());
            if (empty($this->datetime)) $this->datetime = new \yii\db\Expression('extract(epoch from now())');
            if (empty($this->secret)) $this->secret = Yii::$app->params['countr'];
        }
        return true;
    }
}
