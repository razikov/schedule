<?php

use yii\db\Migration;

class m200204_082315_update_tbl_rasp_reservation extends Migration
{
    public function up()
    {
        $this->truncateTable('rasp_reservation');
        $this->dropColumn('rasp_reservation', 'id_theme');
        $this->addColumn('rasp_reservation', 'id_order', $this->integer()->notNull()->after('id'));
        $this->addColumn('rasp_reservation', 'id_course', $this->integer()->notNull()->after('id'));
    }

    public function down()
    {
        $this->truncateTable('rasp_reservation');
        $this->dropColumn('rasp_reservation', 'id_order');
        $this->dropColumn('rasp_reservation', 'id_course');
        $this->addColumn('rasp_reservation', 'id_theme', $this->string()->notNull()->after('id'));
    }
}
