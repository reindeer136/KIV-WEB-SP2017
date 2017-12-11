<?php

class userinfo extends db_pdo
{
    /**
     * Nacte udaje o uzivatelich
     */
    public function LoadAllUserinfos($username)
    {
        $table_name = "users";
        $columns = "*";
        //$where = array();
        $where[] = array("column" => "nick", "value" => $username, "symbol" => "=");

        $userinfo = $this->DBSelectAll($table_name, $columns, $where);
        return $userinfo;
    }
}