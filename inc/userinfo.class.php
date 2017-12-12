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
    
    
    public function SaveAllUserinfos($name, $username, $password, $email)
    {
        
        $table_name = "users";
        //$columns = "*";
        $item = array();
        
        $item['name']   = $name;
        $item['nick']   = $username;
        $item['passwd'] = $password;
        $item['email']  = $email;
        
        //$item[] = array("name" => "$name");
        
//        $item[] = array("name" => "$name", "nick" => "$username", "passwd" => "$password", "email" => "$email");

        $registruj = $this->DBInsert($table_name, $item);
        return $registruj;
    }
}