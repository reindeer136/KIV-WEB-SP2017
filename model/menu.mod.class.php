<?php

    function menu($page){
        $menu = "";

        if ($this->pages != null)
            foreach ($this->pages as $key => $title)
    			{
    				if ($page == $key) $active_pom = "class='active'";
    				
    				else $active_pom = "";
    				
    				$menu .= " <li ".$active_pom." ><a href='index.php?page=$key'>$title</a></li>";   				
    			}
    		
    		return $menu;