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
if( $HTTP_GET_VARS["Webdesign"] == "intro"){ 
                           if($arr_new != null){
                                        $id_new = $arr_new[1]["id_newscat"];
                                        $select_query = "SELECT `tinid`, `tieude` FROM ".DB_PREFIX."tintuc WHERE `newscat_id` = '".$id_new."'";
                                        $sql->query($select_query);	
                                                           $i = 0;
                                                           while ($row = $sql->fetch_array()){		
                                                                                      $i = $i + 1;
                                                                                    $intro_detail[$i]["tinid"] 		= $row["tinid"];
                                                                                    $intro_detail[$i]["tieude"] 	= $row["tieude"];
                                        }


                                                          if(count($intro_detail) > 0){
                                                                        $id  = $intro_detail[1]["tinid"];
                                                                        $select_detail = "select tieude,trichdan from ".DB_PREFIX."tintuc WHERE tinid='".$id."' limit 1";
                                                                        $sql->query($select_detail);
                                                                        if($r = $sql->fetch_array()){
                                                                                        $tieude = $r["tieude"];
                                                                                        $trichdan = $r["trichdan"];
                                                                        }
                                                          }
                          }
	$title = array(	"intro" => "Giới thiệu về chúng tôi",
 	);
	$sql->close();
}

function publish(){
	global $intro_detail,$tieude,$trichdan;        
                            if(count($intro_detail) > 0){
                               echo '
                                           <div class="left_box_slide">
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
                                        <div class="title"><h3>Giới thiệu</h3></div>
                                            <div class="content">
                                                <ul>                                                   
                                                    <li class="active"><a href="'.WEB_DOMAIN.'/bai-viet/'.huu($intro_detail[1]['tieude']).'-'.$intro_detail[1]["tinid"].'">'.$intro_detail[1]["tieude"].'</a></li>';
                                                    for($j=2;$j<=count($intro_detail);$j++){
                                                           echo '<li><a href="'.WEB_DOMAIN.'/bai-viet/'.huu($intro_detail[$j]['tieude']).'-'.$intro_detail[$j]["tinid"].'">'.$intro_detail[$j]["tieude"].'</a></li>';
                                                    }
                                                echo '</ul>
                                            </div>
                                        </div><!--cols-->
                                </div>';

                         }else{
                                echo '<div class="content">
                                           Đang cập nhật dữ liệu
                                   </div>';
                           }   
        }
        
        

?>