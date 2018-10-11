<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "countries".
 *
 * @property int $cnt_id
 * @property string $cnt_code
 * @property string $cnt_title
 * @property string $cnt_created
 */
class Country extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return array_merge(
            [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'cnt_created',
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
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cnt_code', 'cnt_title'], 'required'],
            [['cnt_created'], 'safe'],
            [['cnt_code'], 'string', 'max' => 2],
            [['cnt_title'], 'string', 'max' => 255],
            [['cnt_code'], 'unique'],
            [['cnt_title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cnt_id' => 'Cnt ID',
            'cnt_code' => 'Cnt Code',
            'cnt_title' => 'Cnt Title',
            'cnt_created' => 'Cnt Created',
        ];
    }
}
