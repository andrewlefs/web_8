<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home pages</a>");
}
$intro_detail 	= array();

$sql = new db_sql();
$sql->db_connect();
$sql->db_select();
$tieude = "";
$trichdan = "";
global $arr_new;
if( $HTTP_GET_VARS["Webdesign"] == "introdetail"){ 
                            $id = $_GET["id"];
                            $select_detail = "select tieude,trichdan,newscat_id from ".DB_PREFIX."tintuc WHERE tinid='".$id."' limit 1";
                            $sql->query($select_detail);
                            if($r = $sql->fetch_array()){
                                            $tieude = $r["tieude"];
                                            $trichdan = $r["trichdan"];
                                            $newscat_id = $r["newscat_id"];
                            }
                            
                            for($i=1;$i<=count($arr_new);$i++){
                                if($arr_new[$i]["id_newscat"]==$newscat_id){
                                                $name = $arr_new[$i]["name"];
                                }
                            }
                            
                            $id_new = $newscat_id;
                            $select_query = "SELECT `tinid`, `tieude` FROM ".DB_PREFIX."tintuc WHERE `newscat_id` = '".$id_new."'";
                            $sql->query($select_query);	
                                               $i = 0;
                                               while ($row = $sql->fetch_array()){		
                                                                          $i = $i + 1;
                                                                        $intro_detail[$i]["tinid"] 		= $row["tinid"];
                                                                        $intro_detail[$i]["tieude"] 	= $row["tieude"];
                            }
	$title = array(	"introdetail" =>$tieude,
 	);
	$sql->close();
}

function publish(){
	global $intro_detail,$tieude,$trichdan,$name,$id;     
                            echo ' <div class="left_box_slide">
                                                         <div class="title"><h1>'.$tieude .'</h1></div>
                                                         <div class="content">
                                                             <div class="tin_view">
                                                                             '. $trichdan .'
                                                               </div>
                                                             <div class="clear"></div>';
                                                              echo '
                                                        </div>
                                      </div><!--left_box-->
                                       <div class="right_box_slide">
                                     <div class="cols_right gioithieu">
                                     <div class="title"><h3>'.$name.'</h3></div>
                                         <div class="content">
                                             <ul>';
                                                 for($j=1;$j<=count($intro_detail);$j++){
                                                        if($intro_detail[$j]["tinid"]==$id){
                                                                echo '<li class="active"><a href="'.WEB_DOMAIN.'/bai-viet/'.huu($intro_detail[$j]['tieude']).'-'.$intro_detail[$j]["tinid"].'">'.$intro_detail[$j]["tieude"].'</a></li>';
                                                        }else{
                                                            echo '<li><a href="'.WEB_DOMAIN.'/bai-viet/'.huu($intro_detail[$j]['tieude']).'-'.$intro_detail[$j]["tinid"].'">'.$intro_detail[$j]["tieude"].'</a></li>';
                                                        }
                                                 }
                                             echo '</ul>
                                         </div>
                                     </div><!--cols-->
                             </div>';                      
        }
        
        

?>