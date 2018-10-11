<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aggregate_log`.
 */
class m181011_105641_create_aggregate_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('aggregate_log', [
            'agg_id' => $this->primaryKey(),
            'agg_date' => $this->date(),
            'cnt_id' => $this->integer()->notNull(),
            'usr_id' => $this->integer()->notNull(),
            'success' => $this->integer()->notNull()->defaultValue(0),
            'failed' => $this->integer()->notNull()->defaultValue(0),
            'agg_created' => $this->dateTime(),
        ]);

        $this->addForeignKey('agg_log_user', 'aggregate_log', 'usr_id', 'users', 'usr_id');
        $this->addForeignKey('agg_log_country', 'aggregate_log', 'cnt_id', 'countries', 'cnt_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('aggregate_log');
    }
}
