<?php

use yii\db\Migration;

class m200121_190109_create_tbl_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'status' => $this->integer(3),
            'role' => $this->string(),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'middle_name' => $this->string(255),
            'last_activity_at' => $this->dateTime(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
