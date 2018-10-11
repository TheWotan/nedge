<?php

namespace app\controllers;

use app\models\AggregateLogSearch;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Display data.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AggregateLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
