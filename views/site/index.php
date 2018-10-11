<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\AggregateLogSearch */

use yii\grid\GridView;

$this->title = 'Aggregate Data';
?>
<div class="site-index">

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'agg_date',
                'format' => ['date', 'php:Y-m-d'],
                'label' => 'Date'
            ],
            [
                'attribute' => 'success',
                'format' => 'integer',
                'label' => 'Successfully Sent',
            ],
            [
                'attribute' => 'failed',
                'format' => 'integer',
                'label' => 'Failed'
            ],
        ],
    ]);
    ?>
</div>
