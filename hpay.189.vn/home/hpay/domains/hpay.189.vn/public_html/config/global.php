<?php
                                    if (!defined("qaz_wsxedc_qazxc0FD_123K")){
                                                    die("<a href='../index.php'>Login</a> to Web Contents Manager !");
                                    }
                                    $cat 	= array();
                                    $subcat = array();
                                    $faq 	= array();
                                    $intro	= array();
                                    $loaivi	= array();
                                    $pro2 	= array();
                                    $new 	= array();
                                    $logo 	= array();
                                    $slider	= array();
                                    $yahoo	= array();
                                    $keyword	= array();
                                    $technew	= array();
                                    $new_tags	= array();
                                    $new_event	= array();
                                    $new_event1	= array();
                                    $currency 	= array();
                                    $ysupport 	= array();
                                    $khachhang	= array();
                                    $seolink 	= array();
                                    $vote_index	= array();
                                    $newscat 	= array();
                                    $ser_sitemap	= array();
                                    $cuscat_sitemap = array();
                                    $downloadcat = array();
                                    $weblist_tags 	= array();
                                    $configuration 	= array();
                                    $bank = array();
                                    $company =array();        
                                    $comid = array();
                                      $arr_new = array();
                                   
                                    $config_HG      = array ();
                                    $sql = new db_sql();
                                    $sql->db_connect();
                                    $sql->db_select();	
                                    $counter = $sql->get_counter();
                                    
                                        
                                    $select_query = "select com_cat.id_company  as id from ".DB_PREFIX."company_catalog as com_cat where id_catalog  in(select id_catalog from ".DB_PREFIX."catalog where type='mobile' )";
                                    $sql->query($select_query);
                                     $i =0;
                                     while ($r = $sql->fetch_array()){
                                         $i = $i +1;
                                         $comid[$i][id] = $r["id"];                                       
                                     }          
                                     
                                    $select = "SELECT `Title`, `Id`, `url`,`Logo` FROM ".DB_PREFIX."bankinfo  WHERE `Published`= 1";
                                    $sql->query($select);
                                    $i =0;
                                    while ($r = $sql->fetch_array()){
                                        $i = $i +1;
                                        $bank[$i]['id'] = $r["Id"];    
                                        $bank[$i]['title'] = $r["Title"];    
                                        $bank[$i]['url'] = $r["url"]; 
                                        $bank[$i]['logo'] = $r["Logo"]; 
                                    }

                                    $select_query = "SELECT id, keyword, description, intro, siteurl, siteemail, contact, footer, sitename FROM ".DB_PREFIX."settings";
                                    $sql->query($select_query);
                                    while($rows = $sql->fetch_array()){
                                                    $config_HG[1]["keyword"]                   = $rows["keyword"];
                                                    $config_HG[1]["description"]              = $rows["description"];
                                                    $config_HG[1]["siteurl"]                       = $rows["siteurl"];
                                                    $config_HG[1]["siteemail"]                   = $rows["siteemail"];
                                                    $config_HG[1]["contact"]                     = $rows["contact"];
                                                    $config_HG[1]["intro"]                          = $rows["intro"];
                                                    $config_HG[1]["footer"]                        = $rows["footer"];
                                                    $config_HG["sitename"]                   = $rows["sitename"];						
                                    }
                                    
                                    //get info of category
                                    $select_query = "SELECT `id_catalog`, `name`, `catalog_parent` FROM ".DB_PREFIX."catalog order by sort_order";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                    $i = $i + 1;
                                                    $cat[$i]["catid"]                                   = $rows["id_catalog"];
                                                    $cat[$i]["catname"]                             = $rows["name"];	
                                                    $cat[$i]["catalog_parent"] 	 = $rows["catalog_parent"];
                                    }
                                    
                                     //get info of copany
                                    $select_query = "SELECT `id_company`, `name`, `name_eng`, `company_code`, `publish`,`logo` FROM ".DB_PREFIX."company order by name";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                    $i = $i + 1;
                                                    $company[$i]["id_company"]                                   = $rows["id_company"];
                                                    $company[$i]["name"]                             = $rows["name"];	
                                                    $company[$i]["name_eng"] 	 = $rows["name_eng"];
                                                    $company[$i]["company_code"] 	 = $rows["company_code"];
                                                    $company[$i]["publish"] 	 = $rows["publish"];
                                                     $company[$i]["logo"] 	 = $rows["logo"];
                                    }
                                    
                                       //get info of category
                                    $select_query = "SELECT `id`, `name` FROM ".DB_PREFIX."loaivi where publish=1 order by id";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                    $i = $i + 1;
                                                    $loaivi[$i]["id"]                                   = $rows["id"];
                                                    $loaivi[$i]["name"]                             = $rows["name"];	
                                                
                                    }

                                    // get intro servies
                                    $select_query = "SELECT serviceid, servicename FROM ".DB_PREFIX."service ORDER BY thutu, servicename";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                    $i = $i + 1;
                                                    $ser_sitemap[$i]["serviceid"] 		= $rows["serviceid"];
                                                    $ser_sitemap[$i]["servicename"] 	= $rows["servicename"];
                                    }

                                    $select_query = "SELECT id, yahooname, nickname FROM ".DB_PREFIX."yahoo ORDER BY thutu ASC";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                    $i = $i + 1;
                                                    $yahoo[$i]["id"] 		= $rows["id"];
                                                    $yahoo[$i]["yahooname"]                                   = $rows["yahooname"];	
                                                    $yahoo[$i]["nickname"] 		= $rows["nickname"];	
                                    }
                                  
                                    $select = "select id_newscat,name from ".DB_PREFIX."newscat where publish='1' order by list_order ";
                                        $sql->query($select);
                                        $t = 0;
                                        while ($k = $sql->fetch_array()){
                                            $t = $t +1;
                                            $arr_new[$t]["id_newscat"] = $k["id_newscat"];
                                            $arr_new[$t]["name"] = $k["name"];
                                        }

                                    $select_query = "SELECT `id_newscat`, `name`, `newscat_parent` FROM ".DB_PREFIX."newscat  ORDER BY list_order";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                    $i = $i + 1;
                                                    $newscat[$i]["id"]                                              = $rows["id_newscat"];
                                                    $newscat[$i]["title"]                                           = $rows["name"];	
                                                    $newscat[$i]["newscat_parent"]                     = $rows["newscat_parent"];	
                                    }

                                    //get info of download category
                                    $select_query = "SELECT `id_catdown`, `ten` FROM kien_downloadcat WHERE publish=1 ORDER BY `sort_order`";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                            $i = $i + 1;
                                                            $downloadcat[$i]["id"] 		= $rows["id_catdown"];
                                                            $downloadcat[$i]["title"]                             = $rows["ten"];	
                                    }

                                    //get file moi tai len
                                    $select_query = "SELECT `id_download`, `id_catdown`, `title`  FROM ".DB_PREFIX."download ORDER BY title LIMIT 0, $dew_news";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                        $i = $i + 1;
                                                        $dewnew[$i]["id"] 		= $rows["id"];
                                                        $dewnew[$i]["title"] 		= $rows["title"];
                                                        $dewnew[$i]["filename"]		= $rows["filename"];

                                    }

                                    $select_query = "SELECT `id_slider`, `logo`, `link`, `list_order`, `publish`, `content`  FROM ".DB_PREFIX."slider WHERE publish = 1 ORDER BY list_order";
                                    $sql->query($select_query);
                                    $i = 0;
                                    while($rows = $sql->fetch_array()){
                                                        $i = $i + 1;
                                                         $slider[$i]["id"] 		= $rows["id_slider"];
                                                        $slider[$i]["logo"] 		= $rows["logo"];
                                                        $slider[$i]["content"] 		= $rows["content"];	
                                                        $slider[$i]["link"]  		= $rows["link"];
                                    }
                                    $sql->close();

                                    function get_Ncatname($Ncatid){
                                                    global $Ncatname, $newscat;
                                                    for($i=1; $i<=count($newscat); $i++){
                                                                    if($newscat[$i]["id"]==$Ncatid){
                                                                                    $Ncatname = $newscat[$i]["title"];
                                                                                    break;
                                                                    }				
                                                    }
                                                     return $Ncatname;
                                    }
                                    
                                    function get_Dcatname($Dcatid){
                                                    global $Dcatname, $downloadcat;
                                                    for($i=1; $i<=count($downloadcat); $i++){
                                                                        if($downloadcat[$i]["id"]==$Dcatid){
                                                                                            $Dcatname = $downloadcat[$i]["title"];
                                                                                            break;
                                                                        }				
                                                    }
                                            return $Dcatname;
                                    }   
                                    
                                    function get_money($memberid){
                                        $mn_tem = "";
                                        $sql = new db_sql();
                                        $sql->db_connect();
                                        $sql->db_select();
                                        $select = "select Gold from kien_member where memberid=$memberid";
                                        $sql->query($select);
                                        if($r = $sql->fetch_array()){
                                            $mn_tem = $r["Gold"];
                                        }
                                        $sql->close();
                                        return $mn_tem;
                                    }
                                    
                                    function xac_dinh_menu_con__left_123($id_cha)
                                    {
                                            $sql = new db_sql();
                                            $sql->db_connect();
                                            $sql->db_select();
                                           $select = "SELECT count(*) as total  FROM `kien_catalog` WHERE `catalog_parent` = $id_cha";
                                           $sql->query($select);
                                           $total = $sql->fetch_array();
                                            if($total["total"]==0)
                                            {
                                                    return "khong";
                                            }
                                            else 
                                            {
                                                    return "co";
                                            }
                                    }
                                    
                                    function de_quy_menu__left_123($id_cha)
                                    {
                                            $sql = new db_sql();
                                            $sql->db_connect();
                                            $sql->db_select();
                                            $tv="select * from ".DB_PREFIX."catalog where catalog_parent='$id_cha'";
                                           $sql->query($tv);
                                            while($tv_2=$sql->fetch_array())
                                            {     
                                                       $xac_dinh_menu_con__123= xac_dinh_menu_con__left_123($tv_2['id_catalog']);
                                                       if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                echo "<li  style='width: 225px; height: 30px; background-color: rgb(255, 255, 255);'>  
                                                                                        <a href='javascript:;'  style=color: rgb(51, 51, 51); font-size: 12px; line-height: 30px; display: block;'>";
                                                                                                    echo $tv_2['name'];
                                                                                        echo "</a>";
                                                                                        echo "<ul>";
                                                                                                    de_quy_menu__left_123($tv_2['id_catalog']);
                                                                                        echo "</ul>
                                                                 </li>";
                                                        }else if($xac_dinh_menu_con__123=="khong"){
                                                                echo "<li>
                                                                                    <a href='".WEB_DOMAIN."/product-".  huu($tv_2[name])."-".$tv_2[id_catalog]."'   style='color: rgb(51, 51, 51); font-size: 12px; line-height: 30px; display: block;'>";
                                                                                             echo $tv_2['name'];
                                                                                    echo "</a>
                                                                 </li>";
                                                        }
                                            }
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