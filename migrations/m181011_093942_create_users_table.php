<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m181011_093942_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'usr_id' => $this->primaryKey(),
            'usr_name' => $this->string(255)->unique()->notNull(),
            'usr_active' => $this->boolean()->notNull()->defaultValue(1),
            'usr_created' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
