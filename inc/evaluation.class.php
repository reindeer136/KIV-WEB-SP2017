<?php

class manageevaluations extends db_pdo
{
    /**
     * Nacte vsechno hodnoceni clanku dle jeho ID
     */
    public function LoadEvalAcctoIdArticle($id_article)
    {
        $table_name = "evaluation";
        $columns = "*";
        //$where[] = array("column" => "id_article", "value" => $id_article, "symbol" => "=");
        $where = array();
        
        
        //printr($where);

        $h_info = $this->DBSelectAll($table_name, $columns, $where);
        
        //printr($h_info);
        
        return $h_info;
    }
    
    
    /**
     * Nacte vsechno hodnoceni clanku dle jeho uzivateleID
     */
    public function LoadEvalAcctoIdUser($id_user)
    {
        $table_name = "evaluation";
        $columns = "*";
        $where[] = array("column" => "id_user", "value" => $id_user, "symbol" => "=");

        $h_info = $this->DBSelectAll($table_name, $columns, $where);
        
        return $h_info;
        
        
    }
    
        public function LoadEvalSpecificData($id_article)
    {
        $table_name = "evaluation";
        $columns = "*";
        //$where[] = array("column" => "id_article", "value" => $id_article, "symbol" => "=");
        $where = array();
        
        
        //printr($where);

        $h_info = $this->DBSelectAll($table_name, $columns, $where);
        
        //printr($h_info);
        
        return $h_info;
    }
}