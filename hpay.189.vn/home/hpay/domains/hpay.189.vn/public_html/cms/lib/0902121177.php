<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$cat123        = array();
                           $company  = array();
                           $com_cat   = array();
	$sql_menu   = new db_sql();
	$sql_menu->db_connect();
	$sql_menu->db_select();
        
	$menu_select_query = "SELECT `id_catalog`, `name`, `catalog_parent` FROM `kien_catalog` order by `sort_order`";
	$sql_menu->query($menu_select_query);
	$i = 0;
	while($rows = $sql_menu->fetch_array()){
		$i = $i + 1;
		$cat123[$i]["catid"] 	= $rows["id_catalog"];		
		$cat123[$i]["catname"] = $rows["name"];
                                                     $cat123[$i]["cat_parent"] = $rows["catalog_parent"];
	}
        
        
                        $menu_select_query = "SELECT `id`, `id_company`, `id_catalog` FROM ".DB_PREFIX."company_catalog ";
	$sql_menu->query($menu_select_query);
	$i = 0;
	while($rows = $sql_menu->fetch_array()){
		$i = $i + 1;
		$com_cat[$i]["id"] 	= $rows["id"];		
		$com_cat[$i]["id_company"] = $rows["id_company"];
                                                     $com_cat[$i]["id_catalog"] = $rows["id_catalog"];
	}
        
	
                            //get info of copany
                                $select_query = "SELECT `id_company`, `name`, `name_eng`, `company_code`, `publish` FROM ".DB_PREFIX."company order by id_company";
                                $sql->query($select_query);
                                $i = 0;
                                while($rows = $sql->fetch_array()){
                                                $i = $i + 1;
                                                $company[$i]["id_company"]                                   = $rows["id_company"];
                                                $company[$i]["name"]                             = $rows["name"];	
                                                $company[$i]["name_eng"] 	 = $rows["name_eng"];
                                                $company[$i]["company_code"] 	 = $rows["company_code"];
                                                $company[$i]["publish"] 	 = $rows["publish"];
                                }
                                    
        
	$newscat = array();
	$menu_select_query = "SELECT `id_newscat`, `name`, `newscat_parent`, `publish` FROM `kien_newscat`  order by `list_order`";
	$sql_menu->query($menu_select_query);
	$i = 0;
	while($rows = $sql_menu->fetch_array()){
		$i = $i + 1;
		$newscat[$i]["id"] 	= $rows["id_newscat"];		
		$newscat[$i]["name"] = $rows["name"];
		$newscat[$i]["publish"] = $rows["publish"];
	}
	// Ket thuc khai bao khach hang
	$downloadcat = array();
	$menu_select_query = "SELECT id_catdown, ten, publish FROM kien_downloadcat ORDER BY sort_order, ten";
	$sql_menu->query($menu_select_query);
	$i = 0;
	while($rows = $sql_menu->fetch_array()){
		$i = $i + 1;
		$downloadcat[$i]["id"]      = $rows["id"];		
		$downloadcat[$i]["title"]   = $rows["title"];
                                                    $downloadcat[$i]["UserId"]  = $rows["UserId"];
		$downloadcat[$i]["publish"] = $rows["publish"];
	}

	$sql_menu->close();	
	
	function get_catname($catid){
		global $catname, $cat;
		for($i=1; $i<=count($cat); $i++){
			if($cat[$i]["catid"]==$catid){
				$catname = $cat[$i]["catname"];
				break;
			}				
		}
	return $catname;
	}
        
                        function get_cat($id){
                                    $sql = new db_sql();
                                    $sql->db_connect();
                                    $sql->db_select();
                                    $select = "select name from ".DB_PREFIX."catalog where id_catalog='".$id."' ";
                                    $sql->query($select);
                                    if($r = $sql->fetch_array()){
                                        $name_catalog = $r["name"];
                                    }
                                    
                                    return $name_catalog;
                            }
                            
                               function get_com($id){
                                    $sql = new db_sql();
                                    $sql->db_connect();
                                    $sql->db_select();
                                    $select = "select name from ".DB_PREFIX."company where id_company='".$id."' ";
                                    $sql->query($select);
                                    if($r = $sql->fetch_array()){
                                        $name_catalog = $r["name"];
                                    }
                                    
                                    return $name_catalog;
                            }                           
                         
?>