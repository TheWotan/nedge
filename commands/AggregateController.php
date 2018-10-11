<?php

namespace app\commands;

use app\models\AggregateLog;
use app\models\Number;
use app\models\SendLog;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

class AggregateController extends Controller
{
    /**
     * Aggregate Data
     * @throws Exception
     */
    public function actionSendLog()
    {
        /** @var SendLog $lastLog */
        $lastLog = SendLog::find()
            ->orderBy(['log_id' => SORT_DESC])
            ->limit(1)
            ->one();

        if (!$lastLog) {
            $this->stdout("No new logs available to aggregate" . PHP_EOL);
            return;
        }

        $aggregateDataQuery = SendLog::find()
            ->select([
                'usr_id' =>  SendLog::tableName() . '.usr_id',
                'cnt_id' => Number::tableName() . '.cnt_id',
                'aggregate_date' => 'DATE(log_created)',
                'success' => 'COUNT(IF(log_success = 1, log_id, null))',
                'failed' => 'COUNT(IF(log_success = 0, log_id, null))',
            ])
            ->leftJoin(Number::tableName(), Number::tableName() . '.num_id = ' . SendLog::tableName() . '.num_id')
            ->andWhere(['<=', 'log_id', $lastLog->log_id])
            ->groupBy(['usr_id', 'cnt_id', 'DATE(log_created)']);


        $rawSql = $aggregateDataQuery->createCommand()->getRawSql();

        $added = Yii::$app->db->createCommand("INSERT INTO aggregate_log(usr_id, cnt_id, agg_date, success, failed) " . $rawSql)->execute();

        $this->stdout("Successfully add " . $added . " rows of aggregate data" . PHP_EOL);

        $totalDeleted = 0;

        do {
            $deleted = Yii::$app->db->createCommand("DELETE FROM " . SendLog::tableName() . " WHERE log_id <= " . $lastLog->log_id . " LIMIT 10000")->execute();
            $totalDeleted+=$deleted;
        } while ($deleted);

        $this->stdout("Successfully delete " . $totalDeleted . " rows of send data" . PHP_EOL);
    }
}
