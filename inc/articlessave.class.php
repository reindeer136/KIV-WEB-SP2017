<?php

class articlessave extends db_pdo
{
    public function AddArticle($id_user, $a_name, $a_abstract, $a_filename)

    {
        $table_name = "evaluation";
        $item = array();
 /*       
        $item['id_user']    = $id_user;
        $item['a_name']     = $a_name;
        $item['a_abstract'] = $a_abstract;
        $item['a_filename'] = $a_filename;
        
        printr($item);
*/       
        $item['id_user']    = $id_user;
        $item['id_']     = $a_name;
        $item['a_abstract'] = $a_abstract;
        $item['a_filename'] = $a_filename;
        
        $nahrajclanek = $this->DBInsert($table_name, $item);
        return $nahrajclanek;
        
    }
}    