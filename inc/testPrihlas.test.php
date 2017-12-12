<?php

    include_once("settings.inc.php");
    include_once("db_pdo.class.php");


    function printr($array) {
        echo "<hr/><pre>";
        print_r($array);
        echo "</pre><hr/>";
    }

class user extends db_pdo
{
    /**
     * Nacte uzivatelske jmeno a heslo z DB
     */
    public function LoadNamePassw($name, $password)
    {
        $table_name = "users";
        $columns = "passwd";
        //$where = array();
        $where[] = array("column" => "name", "value" => "radluk", "symbol" => "=");
        
        echo "              ";
        echo $where;
        echo "              ";
            
        $heslo = $this->DBSelectAll($table_name, $columns, $where);
        return $heslo;
    }
}

    $user = new user();

    $user->Connect();

    $zjisti_heslo = $user->LoadNamePassw("radluk", "jahoda");
    printr($zjisti_heslo);


    


    