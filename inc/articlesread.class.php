<?php

class articlesread extends db_pdo
{
    
    
    /**
     * Nacte vsechny schvalene a nesmazane clanky
     */
    public function LoadVisibleArticles()
    {
        $table_name = "articles";
        $columns = "*";
        //$where = array();
        $where[0] = array("column" => "a_state", "value" => "1", "symbol" => "=");
        $where[1] = array("column" => "a_exist", "value" => "1", "symbol" => "=");
        
        //printr($where);

        $clanky = $this->DBSelectAll($table_name, $columns, $where);
        return $clanky;
    }
    
    
    /**
     * Nacte vsechny clanky
     */
    public function LoadAllArticles()
    {
        $table_name = "articles";
        $columns = "*";
        $where = array();

        $clanky = $this->DBSelectAll($table_name, $columns, $where);
        return $clanky;
    }
    
    public function LoadMyArticles()
    {
        $table_name = "articles";
        $columns = "*";
        $value = $_SESSION["id"];
        //printr($value);
        //$where = array();
        $where[] = array("column" => "id_user", "value" => $value, "symbol" => "=");

        $articlesinfo = $this->DBSelectAll($table_name, $columns, $where);
        return $articlesinfo;
    }
    
    
}