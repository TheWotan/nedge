<?php

use yii\db\Migration;

/**
 * Handles the creation of table `send_log`.
 */
class m181011_094248_create_send_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('send_log', [
            'log_id' => $this->primaryKey(),
            'usr_id' => $this->integer()->notNull(),
            'num_id' => $this->integer()->notNull(),
            'log_message' => $this->text()->null(),
            'log_success' => $this->boolean()->notNull(),
            'log_created' => $this->dateTime(),
        ]);

        $this->addForeignKey('log_user', 'send_log', 'usr_id', 'users', 'usr_id');
        $this->addForeignKey('log_number', 'send_log', 'num_id', 'numbers', 'num_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('send_log');
    }
}
