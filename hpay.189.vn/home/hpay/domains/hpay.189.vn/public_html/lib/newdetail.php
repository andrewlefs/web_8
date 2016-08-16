<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home</a>");
}
$news = array();
$view = array();
$id_new = "";
if($Webdesign == "newdetail"){
                                                //    $id_new = $arr_new[3]["id_newscat"];
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();
		$id = $_GET["id"];
                                                     $select = "select distinct newscat_id from ".DB_PREFIX."tintuc where tinid='".$id."' limit 1";
                                                     $sql->query($select);
                                                     if($n = $sql->fetch_array()){
                                                                $id_new = $n["newscat_id"];
                                                     }
		$select_query = "SELECT views FROM ".DB_PREFIX."tintuc WHERE tinid='".$id."' and newscat_id='".$id_new."' ";
		$sql->query($select_query);
		$rows = $sql->fetch_array();
		$views = intval($rows["views"]);
		$views++; 
		$update_query = "UPDATE ".DB_PREFIX."tintuc SET views=$views WHERE tinid='".$id."' and newscat_id='".$id_new."' ";
			if(!$sql->query($update_query))
			echo 'Loi Update!';
                        
                        
		$select_query = "SELECT tinid, tieude, trichdan, views, ngaydang, anhtin, nguontin FROM ".DB_PREFIX."tintuc WHERE tinid = '".$id."' and newscat_id='".$id_new."' limit 1 ";
                                                      
		$sql->query($select_query);
		$row = $sql->fetch_array();		
		$title                  = $row["tieude"];
                                                     $ngaydang = change_date123($row["ngaydang"]);
		$view["tinid"] 	= $row["tinid"];
		$view["tieude"] 	= $row["tieude"];
		$view["anhtin"] 	= $row["anhtin"];
		$view["views"] 	= $row["views"];		
		$view["trichdan"] 	= $row["trichdan"];		
		$view["nguontin"] 	= $row["nguontin"];
		$view["ngaydang"] 	= change_date123($row["ngaydang"]);	
	

	if($ngaydang >  0){
                                                $select_query = "SELECT tinid, tieude, trichdan, ngaydang, anhtin FROM ".DB_PREFIX."tintuc WHERE tinid not in($id) and newscat_id='".$id_new."'  ORDER BY ngaydang DESC LIMIT 6";
                                                $sql->query($select_query);	
                                                $i = 0;
                                                        while($rows = $sql->fetch_array()){

                                                                $i = $i + 1;
                                                                $news[$i]["tinid"] 	= $rows["tinid"];
                                                                $news[$i]["tieude"] 	= $rows["tieude"];
                                                                $news[$i]["anhtin"] 	= $rows["anhtin"];			
                                                                $news[$i]["trichdan"] 	= $rows["trichdan"];			
                                                                $news[$i]["ngaydang"] 	= change_date123($rows["ngaydang"]);
                                                        }
	}
	else{
		$message = "Không có thông tin bạn yêu cầu !";
	}
	$sql->close();	
}
		
$title = array("newdetail" => "$title",);

function publish(){  
    global $news, $view, $dir_imgnews1;       
        if(count($view) > 0){
            echo '<div class="title"><h1>'.$view["tieude"].'</h1></div>
                    <div class="content">
                    	<div class="tin_view">';
                        /*    if(!empty($view["anhtin"])){
                                        echo '<div class="img_tin"><img src="'.WEB_DOMAIN.$dir_imgnews1.$view["anhtin"] .'" alt="Ảnh tin" /></div>';
                             }*/
                               echo $view["trichdan"].'
                          </div>
                        <div class="clear"></div>';
                       
                        echo '<div class="lienquan">';
                         if(count($news) > 0){
                        	echo '<p class="title">Tin liên quan</p>
                        	<ul>';
                                        for($j=1;$j<=count($news);$j++){
                                                     echo ' <li><a href="'.WEB_DOMAIN.'/'.  huu($news[$j]["tieude"]).'-'.$news[$j]["tinid"].'.html">'.$news[$j]["tieude"].'</a></li>';
                                       }
                            echo '</ul>';
                                }
                         echo '</div>
                   </div>';
                                            
      }else{
             echo '<div class="content">
                        Đang cập nhật dữ liệu
                </div>';
        }   
}
?>