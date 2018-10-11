<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "send_log".
 *
 * @property int $log_id
 * @property int $usr_id
 * @property int $num_id
 * @property string $log_message
 * @property int $log_success
 * @property string $log_created
 *
 * @property Number $number
 * @property User $user
 */
class SendLog extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return array_merge(
            [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'log_created',
                    'updatedAtAttribute' => null,
                    'value' => new Expression('NOW()'),
                ]
            ],
            parent::behaviors()
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'send_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usr_id', 'num_id', 'log_success'], 'required'],
            [['usr_id', 'num_id', 'log_success'], 'integer'],
            [['log_message'], 'string'],
            [['log_created'], 'safe'],
            [
                ['num_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Number::class,
                'targetAttribute' => ['num_id' => 'num_id']
            ],
            [
                ['usr_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['usr_id' => 'usr_id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'usr_id' => 'Usr ID',
            'num_id' => 'Num ID',
            'log_message' => 'Log Message',
            'log_success' => 'Log Success',
            'log_created' => 'Log Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumber()
    {
        return $this->hasOne(Number::class, ['num_id' => 'num_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['usr_id' => 'usr_id']);
    }
}
