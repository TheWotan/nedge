<?php

use yii\db\Migration;

/**
 * Handles the creation of table `countries`.
 */
class m181011_094132_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('countries', [
            'cnt_id' => $this->primaryKey(),
            'cnt_code' => $this->string(2)->unique()->notNull(),
            'cnt_title' => $this->string(255)->unique()->notNull(),
            'cnt_created' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('countries');
    }
}
