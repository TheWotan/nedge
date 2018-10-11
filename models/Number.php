<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "numbers".
 *
 * @property int $num_id
 * @property int $cnt_id
 * @property string $num_number
 * @property string $num_created
 *
 * @property Country $country
 */
class Number extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return array_merge(
            [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'num_created',
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
        return 'numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cnt_id', 'num_number'], 'required'],
            [['cnt_id'], 'integer'],
            [['num_created'], 'safe'],
            [['num_number'], 'string', 'max' => 32],
            [['num_number'], 'unique'],
            [
                ['cnt_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Country::class,
                'targetAttribute' => ['cnt_id' => 'cnt_id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'num_id' => 'Num ID',
            'cnt_id' => 'Cnt ID',
            'num_number' => 'Num Number',
            'num_created' => 'Num Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['cnt_id' => 'cnt_id']);
    }
}
