<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>Home</a>");
                }
                global $config_HG,$arr_new;
                $box1 =array();
                $box2 =array();
                $box3 =array();
                $title = array(	"index" => $config_HG["sitename"],);
                if($Webdesign=="index"){       
                                        $sql = new db_sql();
                                        $sql->db_connect();
                                        $sql->db_select();
                                        // get bai viet box1
                                         $id_new4 = $arr_new[4]["id_newscat"];
                                         $id_new5 = $arr_new[5]["id_newscat"];
                                         $id_new6 = $arr_new[6]["id_newscat"];
                                         if($id_new4!=""){
                                                            $select_query = "SELECT `tinid`, `tieude` FROM ".DB_PREFIX."tintuc WHERE `newscat_id` = '".$id_new4."'";
                                                            $sql->query($select_query);	
                                                            $i = 0;
                                                           while ($row = $sql->fetch_array()){		
                                                                                      $i = $i + 1;
                                                                                    $box1[$i]["tinid"] 	= $row["tinid"];
                                                                                    $box1[$i]["tieude"] 	= $row["tieude"];
                                                           }
                                     }   
                                      if($id_new5!=""){
                                                            $select_query = "SELECT `tinid`, `tieude` FROM ".DB_PREFIX."tintuc WHERE `newscat_id` = '".$id_new5."' ";
                                                            $sql->query($select_query);	
                                                            $i = 0;
                                                           while ($row = $sql->fetch_array()){		
                                                                                      $i = $i + 1;
                                                                                    $box2[$i]["tinid"] 	= $row["tinid"];
                                                                                    $box2[$i]["tieude"] 	= $row["tieude"];
                                                           }
                                     }               
                                      if($id_new6!=""){
                                                            $select_query = "SELECT `tinid`, `tieude` FROM ".DB_PREFIX."tintuc WHERE `newscat_id` = '".$id_new6."'";
                                                            $sql->query($select_query);	
                                                            $i = 0;
                                                           while ($row = $sql->fetch_array()){		
                                                                                      $i = $i + 1;
                                                                                    $box3[$i]["tinid"] 	= $row["tinid"];
                                                                                    $box3[$i]["tieude"] 	= $row["tieude"];
                                                           }
                                     }               
                }

            function provider(){
            global $company,$dir_imglogos1;
            echo '<ul  id="carouse2">';
                for($i=1;$i<=count($company);$i++){
                    $url    = WEB_DOMAIN.'/buy-card/'.  huu($company[$i]["name"]).'-'.$company[$i]["id_company"];
                    $img    = WEB_DOMAIN.$dir_imglogos1.$company[$i]["logo"];

                    echo '<li><a href="'.$url.'" title="'.$company[$i]["name"].'">
                        <div class="img_thecao"><img src="'.$img.'" alt="'.$company[$i]["name"].'" />
                     </div></a>
                </li>';
                 }
            echo '</ul>
            <a href="#" id="prev"></a>
            <a href="#" id="next"></a>';
            }

function box_goi(){
    global $box1,$box2,$box3,$arr_new;
    echo '<div class="box_goi">';
        if(!empty($arr_new[4]) ){
            echo '<div class="cols_goi cols_goi1">
                                <div class="title"><a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[4]["name"]).'-'.$arr_new[4]["id_newscat"].'">'.$arr_new[4]["name"].'</a></div>
                                <div class="content">
                                        <a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[4]["name"]).'-'.$arr_new[4]["id_newscat"].'"><img class="img" src="'.TPL_LINK.'/images/banner2.png" alt="" /></a>
                                                    <ul class="list">';
                                                        for($k=1;$k<=count($box1);$k++){
                                                                    echo '<li><a href="'.WEB_DOMAIN.'/'. huu($box1[$k]["tieude"]).'-'.$box1[$k]["tinid"].'.html">'.$box1[$k]["tieude"].'</a></li>';
                                                                }
                                                    echo '</ul>
                                    <p class="all"><a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[4]["name"]).'-'.$arr_new[4]["id_newscat"].'">Xem tất cả</a></p>
                                </div>
                    </div>';
                     if(!empty($arr_new[5])){
                    echo '<div class="cols_goi">
                                        <div class="title"><a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[5]["name"]).'-'.$arr_new[5]["id_newscat"].'">'.$arr_new[5]["name"].'</a></div>
                                <div class="content">
                                        <a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[5]["name"]).'-'.$arr_new[5]["id_newscat"].'"><img class="img" src="'.TPL_LINK.'/images/banner1.png" alt="" /></a>
                                                    <ul class="list">';
                                                        for($l=1;$l<=count($box2);$l++){
                                                                    echo '<li><a href="'.WEB_DOMAIN.'/'.  huu($box2[$l]["tieude"]).'-'.$box2[$l]["tinid"].'.html">'.$box2[$l]["tieude"].'</a></li>';
                                                                }
                                                    echo '</ul>
                                    <p class="all"><a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[5]["name"]).'-'.$arr_new[5]["id_newscat"].'">Xem tất cả</a></p>
                                </div>
                    </div>';
                    }
                    if(!empty($arr_new[6])){
                    echo '<div class="cols_goi cols_end fright">
                       <div class="title"><a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[6]["name"]).'-'.$arr_new[6]["id_newscat"].'">'.$arr_new[6]["name"].'</a></div>
                                <div class="content">
                                        <a href=""><img class="img" src="'.TPL_LINK.'/images/banner3.png" alt="" /></a>
                                                    <ul class="list">';
                                                        for($p=1;$p<=count($box3);$p++){
                                                                    echo '<li><a href="'.WEB_DOMAIN.'/'.  huu($box3[$p]["tieude"]).'-'.$box3[$p]["tinid"].'.html">'.$box3[$p]["tieude"].'</a></li>';
                                                                }
                                                    echo '</ul>
                                    <p class="all"><a href="'.WEB_DOMAIN.'/san-pham-dich-vu-'.  huu($arr_new[6]["name"]).'-'.$arr_new[6]["id_newscat"].'">Xem tất cả</a></p>
                                </div>
    </div>';
            }
            }else{}
    echo '</div><!--box_goi-->';
}
?>