<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\Expression;

class UserQuery extends ActiveQuery
{

    /**
     * @return $this
     */
    public function status($status)
    {
        return $this->andWhere([User::tableName().'.status' => $status]);
    }

    /**
     * @return $this
     */
    public function orderByFullName()
    {
        return $this->orderBy(new Expression('CONCAT_WS(" ", last_name, first_name, middle_name)'));
    }
    
}
