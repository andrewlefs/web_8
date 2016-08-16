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
	
	if($_GET["Webdesign"]=="search" || $_POST["Webdesign"]=="search"){
                                                     if(!isset($_GET["text"])){		
			$text_search 	= convert_font($_POST["text_search"],2);			
		}
		else{
			$text_search	= isset($_GET["text"]) ? stripslashes($_GET["text"]) : "";
		}		
		if($text_search != ""){
			//search on product
                                                                                 $w .= "  tieude like '%".$text_search."%' OR noidung like '%".$text_search."%'  OR trichdan like '%".$text_search."%' ";			
			
		}
                
		if($w!=""){			
			$select_query = "SELECT *  FROM ".DB_PREFIX."tintuc 
				WHERE ".$w." ORDER BY ngaydang";

			$sql->query($select_query);
			$n = $sql->num_rows();
			$rows_of_home_search = is_numeric($rows_of_home_search) && $rows_of_home_search>0 ? $rows_of_home_search : 1;
                        //$rows_of_home_search=5;
			$position_page = isset($HTTP_GET_VARS["position_page"]) && is_numeric($HTTP_GET_VARS["position_page"])  ? $HTTP_GET_VARS["position_page"]:1; 
			$from = $position_page ==1 ? 0 : (($rows_of_home_search*$position_page)- $rows_of_home_search);
			$count_rows = $n;	
			$pages_number = ceil($count_rows/$rows_of_home_search);
	
			$search_query = "SELECT *  FROM ".DB_PREFIX."tintuc 
				WHERE ".$w." ORDER BY ngaydang  LIMIT $from, $rows_of_home_search";

			$sql->query($search_query);
			$i=0;
			while($row = $sql->fetch_array()){
				 $ngaydang = $row["ngaydang"];
                                                                                                            $i = $i + 1;
                                                                                                            $res[$i]["tinid"]                      = $row["tinid"];
                                                                                                            $res[$i]["newscat_id"]          = $row["newscat_id"];
                                                                                                            $res[$i]["tieude"]                   = $row["tieude"];
                                                                                                            $res[$i]["anhtin"]                     = $row["anhtin"];
                                                                                                            $res[$i]["trichdan"]               = $row["trichdan"];
                                                                                                            $res[$i]["noidung"]                = strip_tags(strimString($row["noidung"],60));
                                                                                                            $res[$i]["ngaydang"]               = change_date123($row["ngaydang"]);
                                                                                                            
			}
			if($count_rows==0)
					$message = $message."<li>Không tìm thấy kết quả nào. Mời bạn tìm kiếm lại";
		}	
		else{
			if($w=="")			
				$message = $message."<li>Hãy nhập điều kiện tìm kiếm.";						
			
		}
		
	}
        
         $sql->close();
//        if($HTTP_GET_VARS["Webdesign"]=="search" || $HTTP_GET_VARS["mode"]=="sear"){
//                if(!isset($_GET["text"])){		
//			$nsx_search 	= $_POST["nsx"];
//			$price_search 	= $_POST["price"];
//		}
//		else{
//			$nsx_search 	= $_POST["nsx"];
//			$price_search 	= $_POST["price"];
//		}		
//		if($nsx_search != "" && $price_search!= ""){
//			//search on product
//			$w.=" nsxid = ".$nsx_search." AND kgid=".$price_search."";
//		}
//		else
//			if($nsx_search != "" && $price_search == ""){
//				$w.=" nsxid = ".$nsx_search."";	
//			}
//		
//                else{
//                    if($nsx_search == "" && $price_search != ""){
//				$w.=" kgid=".$price_search."";	
//			}
//                }
//					
//		//			
//		if($w!=""){			
//			$select_query = "SELECT s.SanphamID as sanphamid, s.ten as ten, s.anh as anh,s.km as km, s.gia_km as gia_km,s.mota as mota,s.xuatxu as xuatxu,
//				s.gia as gia  FROM sanpham as s 
//				WHERE ".$w." ORDER BY s.ten";
//
//			$sql->query($select_query);
//			$n = $sql->num_rows();
//			$rows_of_home_search = is_numeric($rows_of_home_search) && $rows_of_home_search>0 ? $rows_of_home_search : 1;
//                        //$rows_of_home_search=5;
//			$position_page = isset($HTTP_GET_VARS["position_page"]) && is_numeric($HTTP_GET_VARS["position_page"])  ? $HTTP_GET_VARS["position_page"]:1; 
//			$from = $position_page ==1 ? 0 : (($rows_of_home_search*$position_page)- $rows_of_home_search);
//			$count_rows = $n;	
//			$pages_number = ceil($count_rows/$rows_of_home_search);
//	
//			$search_query = "SELECT s.SanphamID as sanphamid, s.ten as ten, s.anh as anh,s.km as km, s.gia_km as gia_km,s.mota as mota,s.xuatxu as xuatxu,s.tinhtrang as tinhtrang,
//				s.gia as gia  FROM sanpham as s 
//				WHERE ".$w." ORDER BY s.ten LIMIT $from, $rows_of_home_search";
//
//			$sql->query($search_query);
//			$i=0;
//			while($row = $sql->fetch_array()){
//				$i=$i+1;			
//				$res[$i]["sanphamid"] 	= $row["sanphamid"];
//				$res[$i]["ten"] 		= $row["ten"];
//				$res[$i]["anh"] 		= $row["anh"];
//				$res[$i]["gia"] 		= $row["gia"];
//				$res[$i]["km"] 	= $row["km"];
//                                                                                                           $res[$i]["gia_km"] 	= $row["gia_km"]; 
//                                                                                                           $res[$i]["mota"] 	= $row["mota"];
//                                                                                                           $res[$i]["xuatxu"] 	= $row["xuatxu"];
//                                                                                                           $res[$i]["tinhtrang"] 	= $row["tinhtrang"];                                                                                                            
//			}
//			
//		}			
//		
//	}
        
       
			

function search_result(){
         global $res, $position_page, $pages_number, $text_search,$dir_imgnews1;        
           echo '<div class="title"><h1>Kết quả tìm kiếm</h1></div>
                    <div class="content">';
                           if(count($res)>0){
                                echo '<ul class="list_tin">';
                                                    for($i=1;$i<=count($res);$i++){
                                                                if($i%2!=0){                                                    
                                                                echo '<li>
                                                                                <div class="img_tin"><a href="'.WEB_DOMAIN.'/'.  huu($res[$i]["tieude"]).'-'.$res[$i]["tinid"].'.html"><img src="'.WEB_DOMAIN.$dir_imgnews1.$res[$i]["anhtin"].'" alt="ảnh tin" /></a></div>
                                                                                <div class="content">
                                                                                    <h2><a href="'.WEB_DOMAIN.'/'.  huu($res[$i]["tieude"]).'-'.$res[$i]["tinid"].'.html">'.$res[$i]["tieude"].'</a></h2>
                                                                                    <p>'.  strip_tags(strimString($res[$i]["trichdan"], 150)).'</p>
                                                                                    <a href="'.WEB_DOMAIN.'/'.  huu($res[$i]["tieude"]).'-'.$res[$i]["tinid"].'.html" class="chitiet">Xem chi tiết</a>
                                                                                </div>
                                                                        </li>';
                                                                }else{
                                                                        echo '<li class="fright">
                                                                            <div class="img_tin"><a href="'.WEB_DOMAIN.'/'.  huu($res[$i]["tieude"]).'-'.$res[$i]["tinid"].'.html"><img src="'.WEB_DOMAIN.$dir_imgnews1.$res[$i]["anhtin"].'" alt="ảnh tin" /></a></div>
                                                                                <div class="content">
                                                                                    <h2><a href="'.WEB_DOMAIN.'/'.  huu($res[$i]["tieude"]).'-'.$res[$i]["tinid"].'.html">'.$res[$i]["tieude"].'</a></h2>
                                                                                    <p>'.  strip_tags(strimString($res[$i]["trichdan"], 150)).'</p>
                                                                                    <a href="'.WEB_DOMAIN.'/'.  huu($res[$i]["tieude"]).'-'.$res[$i]["tinid"].'.html" class="chitiet">Xem chi tiết</a>
                                                                                </div>
                                                                        </li>';
                                                                        }
                                                          }
                                            echo '</ul>
                                          <div class="clear"></div> 
                                            <div class="control">
                                            <ul class="pagination">';
                                                             pages_browser_admin(WEB_DOMAIN."/ket-qua-tim-kiem-".$text_search."/trang-",$position_page,$pages_number);
                                             echo '</ul></div>';
                                            }  else {
                                                        echo "Đang cập nhật dữ liệu";
                                            }
       
        } 
?>