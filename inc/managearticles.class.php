<?php

class managearticles extends db_pdo
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
    
    public function AddArticle($id_user, $a_name, $a_abstract, $a_filename)

    {
        $table_name = "articles";
        $item = array();
    
        $item['id_user']    = $id_user;
        $item['a_name']     = $a_name;
        $item['a_abstract'] = $a_abstract;
        $item['a_filename'] = $a_filename;
        
        $nahrajclanek = $this->DBInsert($table_name, $item);
        return $nahrajclanek;
        
    }
    /**
     * Smaže/obnoví článek
     */
    public function DeleteArticle($id,$state)

    {
        printr($state);

        $table_name = "articles";
        $set[] = array("column" => "a_exist", "value" => $state, "symbol" => "=");
        
        printr($set);

        //$where = array();
        $where[] = array("column" => "id_article", "value" => $id, "symbol" => "=");
        
        $articledelete = $this->DBUpdate($table_name, $set, $where);
        return $articledelete;
    }
    
    
}