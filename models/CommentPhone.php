<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment_phone".
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property int $phone_number
 * @property bool $status
 * @property string $comment
 * @property int $ip
 * @property int $user_id
 * @property int $datetime
 * @property string $secret
 */
class CommentPhone extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_OK = 1;
    const STATUS_SPAM = 10;
    static public  $statusList = [
        CommentPhone::STATUS_NEW => 'Новый',
        CommentPhone::STATUS_OK => 'Решен',
        CommentPhone::STATUS_SPAM => 'Спам',
    ];

    const TYPE_OTHER = 1;
    const TYPE_SCAMMER = 2;
    const TYPE_AD = 3;
    const TYPE_COLLECTOR = 4;
    const TYPE_SURVEY = 5;
    const TYPE_BULLY = 6;
    const TYPE_CALL_CENTER = 7;
    const TYPE_INADEQUATE = 8;
    static public  $typeList = [
        CommentPhone::TYPE_OTHER => 'Другое',
        CommentPhone::TYPE_SCAMMER => 'Мошенники',
        CommentPhone::TYPE_AD => 'Реклама',
        CommentPhone::TYPE_COLLECTOR => 'Коллекторы',
        CommentPhone::TYPE_SURVEY => 'Опросы',
        CommentPhone::TYPE_BULLY => 'Хулиганы',
        CommentPhone::TYPE_CALL_CENTER => 'Колл-центры',
        CommentPhone::TYPE_INADEQUATE => 'Неадекваты'
    ];
    var $isDatetimeAndIp = true;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'phone_number', 'comment'], 'required'],
            [['type', 'phone_number', 'ip', 'datetime'], 'default', 'value' => null],
            [['secret'], 'default', 'value' => ''],
            [['id', 'status', 'type', 'phone_number', 'ip', 'user_id', 'datetime'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['secret'], 'string', 'max' => 32],
            [['global_id'], 'string', 'max' => 20],
            ['phone_number', 'string', 'length' => 10],
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
            'type' => 'Type',
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'status' => 'Status',
            'comment' => 'Comment',
            'ip' => 'Ip',
            'user_id' => 'User ID',
            'datetime' => 'Datetime',
            'secret' => 'Secret',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->ip = ip2long(Yii::$app->getRequest()->getUserIP());
            if (empty($this->datetime)) $this->datetime = new \yii\db\Expression('extract(epoch from now())');
        }
        $this->phone_number = CommentPhone::getPhoneIn($this->phone_number);
        $this->comment = strip_tags($this->comment);
        return true;
    }

    public static function getPhoneIn($str)
    {
        $str = preg_replace('/[^0-9]/', '', $str);
        return mb_substr($str, -10);
    }

    // public function validatePassword($attribute, $params)
    // {
    //     if (preg_match('/(\+7|8)[0-9-\(\)]*/', $this->phone_number)) {
    //         $this->phone_number = preg_replace('/[^0-9]/', '',  $this->phone_number);
    //         if (
    //             mb_strlen($this->phone_number) == 11
    //             && (mb_substr($this->phone_number, 0, 1) == '7' ||
    //                 mb_substr($this->phone_number, 0, 1) == '8')
    //         ) $this->phone_number = mb_substr($this->phone_number, -10);
    //     }
    // }


    public function getPhone()
    {
        $phone = '';
        $sub = substr($this->phone_number, 0, 3);
        if ($sub == 800) $phone .= '8';
        else $phone .= '7';
        $phone .= $this->phone_number;
        $number = (string)$phone;
        $numberFormat =  $number[0] . '(' . $number[1] . $number[2] . $number[3] . ')' . $number[4] . $number[5] . $number[6] . '-' . $number[7] . $number[8] . '-' . $number[9] . $number[10];
        if ($sub != 800) $numberFormat = '+' . $numberFormat;
        return $numberFormat;
    }

    public function getUrl()
    {
        $sub = substr($this->phone_number, 0, 3);
        if ($sub == 800) $number = '8';
        else $number = '7';
        $number .= $this->phone_number;
        return Yii::$app->urlManager->createUrl(['phone/info', 'number' => $number]);
    }


    public function getDate()
    {
        return date('d.m.Y H:i', $this->datetime);
    }

    public function getTypeTitle()
    {
        if (isset(CommentPhone::$typeList[$this->type])) return CommentPhone::$typeList[$this->type];
        return '';
    }
    public function getStatusTitle()
    {
        if (isset(CommentPhone::$statusList[$this->status])) return CommentPhone::$statusList[$this->status];
        return '';
    }
}
