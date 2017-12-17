<?php

class userinfo extends db_pdo
{
    /**
     * Nacte udaje o uzivateli podle uyivatelskeho jmena
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
    public function LoadAllUserinfoAccToID($id)
    {
        $table_name = "users";
        $columns = "*";
        //$where = array();
        $where[] = array("column" => "id_user", "value" => $id, "symbol" => "=");

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
    
    /**
     * Vypíše veškeré uživatele
     */
    public function LoadAllUsers()
    {
        $table_name = "users";
        $columns = "*";
        $where = array();
        
        $userinfo = $this->DBSelectAll($table_name, $columns, $where);
        return $userinfo;
    }
    
    /**
     * Zmení roli uživatele (Autor/Recenzent)
     */
    public function UpdateUserInfo($id,$state)

    {

        $table_name = "users";
        $set[] = array("column" => "id_right", "value" => $state, "symbol" => "=");
        
        //printr($set);
        
        //$where = array();
        $where[] = array("column" => "id_user", "value" => $id, "symbol" => "=");
        
        //printr($where);
        
        $userupdateID = $this->DBUpdate($table_name, $set, $where);
        return $userupdateID;
    }
    
    /**
     * Smaže/obnoví uživatele
     */
    public function DeleteUser($id,$state)

    {
        printr($state);

        $table_name = "users";
        $set[] = array("column" => "exist", "value" => $state, "symbol" => "=");
        
        printr($set);

        //$where = array();
        $where[] = array("column" => "id_user", "value" => $id, "symbol" => "=");
        
        $userdelete = $this->DBUpdate($table_name, $set, $where);
        return $userdelete;
    }
    
    /**
     * Nacte udaje o uzivateli podle role uzivatele
     */
    public function LoadAllUserinfoAccToRole($id_right)
    {
        $table_name = "users";
        $columns = "*";
        //$where = array();
        $where[] = array("column" => "id_right", "value" => $id_right, "symbol" => "=");

        $userinfo = $this->DBSelectAll($table_name, $columns, $where);
        
        //printr($userinfo);
        return $userinfo;
    }
    
}