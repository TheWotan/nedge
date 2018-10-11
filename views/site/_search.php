<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Country;

use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model app\models\AggregateLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">
    <?php $form = ActiveForm::begin([
        'action' => ['site/index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'dateFrom')->label('Date')->widget(DateRangePicker::class, [
        'attributeTo' => 'dateTo',
        'form' => $form, // best for correct client validation
        'size' => 'md',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);?>

    <?= $form->field($model, 'usr_id')->label('User')->dropDownList(
            ['' => 'All'] + ArrayHelper::map(User::find()->all(), 'usr_id', 'usr_name')
    ) ?>

    <?= $form->field($model, 'cnt_id')->label('Country')->dropDownList(
        ['' => 'All'] + ArrayHelper::map(Country::find()->all(), 'cnt_id', 'cnt_title')
    )  ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>