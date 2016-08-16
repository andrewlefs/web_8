<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Trang ch&#7911;</a>");
}
//Tim kiem trong muc: blockinfo, sanpham, tintuc 
	$res = array();	
	$message = '';
	$w = '';
	
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	$i=0;	
	
	if($HTTP_GET_VARS["Webdesign"]=="searchpagin" && isset($HTTP_GET_VARS["position_page"]) && isset($HTTP_GET_VARS["text"])){
                                                if(!isset($_GET["text"])){		
			$text_search 	= convert_font($_POST["text_search"],2);
			$cat_search 	= $_POST["cat_search"];
		}
		else{
			$text_search	= isset($_GET["text"]) ? stripslashes($_GET["text"]) : "";
			$cat_search		= isset($_GET["cats"]) ? $_GET["cats"] : 0 ;
		}		
		if($text_search != "" && $cat_search!= ""){
			//search on product
			$w.=" catid = ".$cat_search." AND (ten like '%".$text_search."%' OR mota like '%".$text_search."%'";
			$w.=" OR thongso like '%".$text_search."%')";
			if(is_numeric($text_search))
				$w.=" OR gia like '%".$text_search."%'";
		}
		else{
			if($text_search != "" && $cat_search == ""){
				$w.=" 1 AND (ten like '%".$text_search."%' OR mota like '%".$text_search."%'";
				$w.=" OR thongso like '%".$text_search."%')";
				if(is_numeric($text_search))
				$w.=" OR gia like '%".$text_search."%'";		
			}
		}
					
		//			
		if($w!=""){			
			$select_query = "SELECT s.SanphamID as sanphamid, s.ten as ten, s.anh as anh,s.km as km, s.gia_km as gia_km,s.mota as mota,s.xuatxu as xuatxu,
				s.gia as gia  FROM sanpham as s 
				WHERE ".$w." ORDER BY s.ten";

			$sql->query($select_query);
			$n = $sql->num_rows();
			$rows_of_home_search = is_numeric($rows_of_home_search) && $rows_of_home_search>0 ? $rows_of_home_search : 1;
                        //$rows_of_home_search = 5;
			$position_page = isset($HTTP_GET_VARS["position_page"]) && is_numeric($HTTP_GET_VARS["position_page"])  ? $HTTP_GET_VARS["position_page"]:1; 
			$from = $position_page ==1 ? 0 : (($rows_of_home_search*$position_page)- $rows_of_home_search);
			$count_rows = $n;	
			$pages_number = ceil($count_rows/$rows_of_home_search);
	
			$search_query = "SELECT s.SanphamID as sanphamid, s.ten as ten, s.anh as anh,s.km as km, s.gia_km as gia_km,s.mota as mota,s.xuatxu as xuatxu,
				s.gia as gia  FROM sanpham as s 
				WHERE ".$w." ORDER BY s.ten LIMIT $from, $rows_of_home_search";

			$sql->query($search_query);
			$i=0;
			while($row = $sql->fetch_array()){
				$i=$i+1;			
				$res[$i]["sanphamid"] 	= $row["sanphamid"];
				$res[$i]["ten"] 		= $row["ten"];
				$res[$i]["anh"] 		= $row["anh"];
				$res[$i]["gia"] 		= $row["gia"];
				$res[$i]["km"] 	= $row["km"];
                                                                                                            $res[$i]["gia_km"] 	= $row["gia_km"]; 
                                                                                                            $res[$i]["mota"] 	= $row["mota"];
                                                                                                           $res[$i]["xuatxu"] 	= $row["xuatxu"];
                                                                                                            
			}
			if($count_rows==0)
					$message = $message."<li>Không tìm thấy kết quả nào. Mời bạn tìm kiếm lại";
		}	
		else{
			if($w=="")			
				$message = $message."<li>Hãy nhập điều kiện tìm kiếm.";						
			
		}
		
	}		
			

function search_result(){
	global $res, $dir_imgproducts1, $position_page, $pages_number, $text_search, $message, $n , $cat_search;    
       
     echo" <div class=\"tittle\">";
             echo"<ul>";
             echo"<li><a rel=\"nofollow\" href=\"".WEB_DOMAIN."\">Trang chủ</a></li>";
              echo"<li><a rel=\"nofollow\">Kết quả tìm kiếm</a></li>";            
               echo"</ul>";
               echo"<div class=\"clear\"></div>";
           echo"</div>";
            echo '<div class="cols_right news">
                        <div class="content">                            
                            <div class="list_news">
                            	<ul>';
                                    for($i=1;$i<=count($res);$i++){
                                	echo '<li>
                                    	<img class="img_tin" src="'.WEB_DOMAIN.$dir_imgproducts1.$res[$i]["anh"].'" alt="" />
                                        <p class="title"><a href="'.WEB_DOMAIN.'/product/detail/'.  cut_space(name_ascii($res[$i]["ten"])).'-'.$res[$i]["sanphamid"].'">'.$res[$i]["ten"].' ('.$res[$i]["xuatxu"].') - <span>'.  number_format($res[$i]["gia"]).' VNĐ</span></a></p>
                                        <p class="noidung">'.$res[$i]["mota"].'</p>
                                        <p class="xemchitiet"><a href="'.WEB_DOMAIN.'/product/detail/'.  cut_space(name_ascii($res[$i]["ten"])).'-'.$res[$i]["sanphamid"].'">Xem chi tiết</a></p>
                                    </li>';
                                    }
                                echo '</ul>';
                                  if($pages_number> 1){
                                       echo "<div class='paging' style='clear:both;'>";
                                        if($pages_number >1 ){
                                                echo "<div class='paging01'>";
                                                pages_browser_admin("".WEB_DOMAIN."/ket-qua-tim-kiem-".$text_search."/trang-",$position_page,$pages_number);
                                                        echo "</div>";
                                        }	
                                        echo "</div>";
                                        }
                            echo '</div><!--list_news-->
                        </div>
                    </div>';
                                }
	

?>