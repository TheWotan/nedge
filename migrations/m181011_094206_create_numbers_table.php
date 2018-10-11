<?php

use yii\db\Migration;

/**
 * Handles the creation of table `numbers`.
 */
class m181011_094206_create_numbers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('numbers', [
            'num_id' => $this->primaryKey(),
            'cnt_id' => $this->integer()->notNull(),
            'num_number' => $this->string(32)->unique()->notNull(),
            'num_created' => $this->dateTime(),
        ]);

        $this->addForeignKey('cnt_number', 'numbers', 'cnt_id', 'countries', 'cnt_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('numbers');
    }
}
