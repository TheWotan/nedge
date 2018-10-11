<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "aggregate_log".
 *
 * @property int $agg_id
 * @property string $agg_date
 * @property int $cnt_id
 * @property int $usr_id
 * @property int $success
 * @property int $failed
 * @property string $agg_created
 *
 * @property Country $country
 * @property User $user
 */
class AggregateLog extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return array_merge(
            [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'agg_created',
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
        return 'aggregate_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agg_date', 'agg_created'], 'safe'],
            [['cnt_id', 'usr_id'], 'required'],
            [['cnt_id', 'usr_id', 'success', 'failed'], 'integer'],
            [
                ['cnt_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Country::class,
                'targetAttribute' => ['cnt_id' => 'cnt_id']
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
            'agg_id' => 'Agg ID',
            'agg_date' => 'Agg Date',
            'cnt_id' => 'Cnt ID',
            'usr_id' => 'Usr ID',
            'success' => 'Success',
            'failed' => 'Failed',
            'agg_created' => 'Agg Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCnt()
    {
        return $this->hasOne(Country::class, ['cnt_id' => 'cnt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsr()
    {
        return $this->hasOne(User::class, ['usr_id' => 'usr_id']);
    }

    /**
     * @param $dateFrom
     * @param $dateTo
     * @param null $usr_id
     * @param null $cnt_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAggregatedData($dateFrom, $dateTo, $usr_id = null, $cnt_id = null)
    {

        $dataQuery = AggregateLog::find()
            ->select(['agg_date', 'success', 'failed'])
            ->andWhere(['>=', 'agg_date', $dateFrom])
            ->andWhere(['<=', 'agg_date', $dateTo])
            ->groupBy(['agg_date'])
            ->orderBy(['agg_date' => SORT_ASC]);

        if ($usr_id) {
            $dataQuery->andWhere(['usr_id' => $usr_id]);
        }

        if ($cnt_id) {
            $dataQuery->andWhere(['cnt_id' => $cnt_id]);
        }

        return $dataQuery->asArray()->all();
    }
}
