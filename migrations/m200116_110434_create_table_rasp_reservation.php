<?php

use yii\db\Migration;

class m200116_110434_create_table_rasp_reservation extends Migration
{
    public function safeUp()
    {
        $this->createTable('rasp_reservation', [
            'id' => $this->primaryKey(),
            'id_theme' => $this->string()->notNull(),
            'classroom' => $this->string()->notNull(),
            'date_at' => $this->date(),
            'time_start_at' => $this->string(),
            'time_end_at' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('rasp_reservation');
    }
}
