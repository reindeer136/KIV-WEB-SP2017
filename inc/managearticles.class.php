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
     * Nacte vsechny clanky k recenzi
     */
    public function LoadReviewableArticles()
    {
        $table_name = "evaluation";
        $columns = "*";
        $value = $_SESSION["id"];
        //$where = array();

        $where[] = array("column" => "id_user", "value" => $value, "symbol" => "=");

        $clanky = $this->DBSelectAll($table_name, $columns, $where);
        //printr($clanky);
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
    
    /**
     * Nacte vsechny clanky podle podminky ID
     */
    public function LoadSpecificArticles($condition)
    {
        $table_name = "articles";
        $columns = "*";
        //$where = array();
        
        $where[] = array("column" => "id_article", "value" => $condition, "symbol" => "=");

        $clanky = $this->DBSelectAll($table_name, $columns, $where);
        return $clanky;
    }
    
    
    /**
     * Vypíše články jejich autorovi
     */
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
    
    /**
     * Vloží článek do DB
     */
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
        
        //printr($set);

        //$where = array();
        $where[] = array("column" => "id_article", "value" => $id, "symbol" => "=");
        
        $articledelete = $this->DBUpdate($table_name, $set, $where);
        return $articledelete;
    }
    
    /**
     * Nastaví aktuální stav článku
     */
    public function UpdateArticleState($id, $state)

    {
        printr($state);

        $table_name = "articles";
        $set[] = array("column" => "a_state", "value" => $state, "symbol" => "=");
        
        //printr($set);

        //$where = array();
        $where[] = array("column" => "id_article", "value" => $id, "symbol" => "=");
        
        $articleupdate = $this->DBUpdate($table_name, $set, $where);
        return $articleupdate;
    }
    
    
    /**
     * Přiřadí článek k recenzi
     */
    public function EvaluateArticle($id_user, $id_article)

    {
        $table_name = "evaluation";
        $item = array();       
    
        $item['id_user']    = $id_user;
        $item['id_article'] = $id_article;
        
        //printr($item);
        
        $priradkrecenzi = $this->DBInsert($table_name, $item);
        return $priradkrecenzi;
        
    }
    
    /**
     * Přiřadí článku hodnocení
     */
    public function RateArticle($id_eval, $a_expertise, $a_length, $a_quality)

    {
        $table_name = "evaluation";
        $set[] = array("column" => "a_expertise", "value" => $a_expertise, "symbol" => "=");
        $set[1] = array("column" => "a_length", "value" => $a_length, "symbol" => "=");  
        $set[2] = array("column" => "a_quality", "value" => $a_quality, "symbol" => "=");
        
        printr($set);
        
        $where[] = array("column" => "id_eval", "value" => $id_eval, "symbol" => "=");
    
        $articleupdate = $this->DBUpdate($table_name, $set, $where);
        return $articleupdate;
        
    }
    
    
}