<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class AggregateLogSearch extends AggregateLog
{
    /**
     * @var string
     */
    public $dateFrom;

    /**
     * @var string
     */
    public $dateTo;

    public function rules()
    {
        return [
            [['cnt_id', 'usr_id'], 'integer'],
            [['dateFrom', 'dateTo'], 'required'],
            [['dateFrom', 'dateTo'], 'safe'],
        ];
    }
//
//    public function scenarios()
//    {
//        // bypass scenarios() implementation in the parent class
//        return Model::scenarios();
//    }

    public function search($params)
    {
        $query = AggregateLog::find()
            ->select([
                'agg_date' => 'agg_date',
                'success' => 'SUM(success)',
                'failed' => 'SUM(failed)',
            ]);

        $query->groupBy(['agg_date']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,

            'sort'=> ['defaultOrder' => ['agg_date' => SORT_ASC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            if (!$this->dateFrom || !$this->dateTo) {
                $query->andWhere('0=1');
            }

            return $dataProvider;
        }

        $query->andFilterWhere(['cnt_id' => $this->cnt_id]);
        $query->andFilterWhere(['usr_id' => $this->usr_id]);

        $query->andWhere(['>=', 'agg_date', $this->dateFrom]);
        $query->andWhere(['<=', 'agg_date', $this->dateTo]);

        return $dataProvider;
    }
}