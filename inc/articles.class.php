<?php

class articles extends db_pdo
{
    /**
     * Nacte vsechny clanky
     */
    public function LoadAllArticles()
    {
        $table_name = "articles";
        $columns = "*";
        $where = array();
        //$where[] = array("column" => "zkratka", "value" => "KIV/DB1", "symbol" => "=");

        $clanky = $this->DBSelectAll($table_name, $columns, $where);
        return $clanky;
    }
    
        public function LoadMyArticles()
    {
        $table_name = "articles";
        $columns = "*";
        $value = $_SESSION["id"];
            printr($value);
        //$where = array();
        $where[] = array("column" => "id_user", "value" => $value, "symbol" => "=");

        $articlesinfo = $this->DBSelectAll($table_name, $columns, $where);
        return $articlesinfo;
    }
}
