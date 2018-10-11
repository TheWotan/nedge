<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "users".
 *
 * @property int $usr_id
 * @property string $usr_name
 * @property int $usr_active
 * @property string $usr_created
 */
class User extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return array_merge(
            [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'usr_created',
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
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usr_name'], 'required'],
            [['usr_active'], 'integer'],
            [['usr_created'], 'safe'],
            [['usr_name'], 'string', 'max' => 255],
            [['usr_name'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usr_id' => 'Usr ID',
            'usr_name' => 'Usr Name',
            'usr_active' => 'Usr Active',
            'usr_created' => 'Usr Created',
        ];
    }


}
