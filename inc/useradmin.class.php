<?php

class userinfo extends db_pdo
{
    /**
     * Nacte udaje o uzivatelich
     */
    public function LoadAllUserinfos()
    {
        $table_name = "users";
        $columns = "*";
        $where = array();
        //$where[] = array("column" => "zkratka", "value" => "KIV/DB1", "symbol" => "=");

        $userinfo = $this->DBSelectAll($table_name, $columns, $where);
        return $userinfo;
    }
}