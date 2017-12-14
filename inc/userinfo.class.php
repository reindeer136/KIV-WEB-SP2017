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
    
    /**
     * Nacte udaje o uzivateli podle ID uzivatele
     */
    public function LoadAllUserinfoAccToID($ID)
    {
        $table_name = "users";
        $columns = "*";
        //$where = array();
        $where[] = array("column" => "id_user", "value" => $ID, "symbol" => "=");

        $userinfo = $this->DBSelectAll($table_name, $columns, $where);
        return $userinfo;
    }
    
    /**
     * Zaregistruje uzivatele (ulozi data do databaze)
     */
    public function SaveAllUserinfos($name, $username, $password, $email)
    {
        
        $table_name = "users";
        $item = array();
        
        $item['name']   = $name;
        $item['nick']   = $username;
        $item['passwd'] = $password;
        $item['email']  = $email;
        
        $registruj = $this->DBInsert($table_name, $item);
        return $registruj;
    }
}