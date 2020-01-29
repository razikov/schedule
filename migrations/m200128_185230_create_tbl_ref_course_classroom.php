<?php

use yii\db\Migration;

class m200128_185230_create_tbl_ref_course_classroom extends Migration
{
    public function safeUp()
    {
        $this->createTable('ref_course_classroom', [
            'id' => $this->primaryKey(),
            'id_course' => $this->integer()->notNull(),
            'classroom' => $this->string(255)->notNull(),
            'date' => $this->date()->notNull(),
            'start_time' => $this->time(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('ref_course_classroom');
    }
}
