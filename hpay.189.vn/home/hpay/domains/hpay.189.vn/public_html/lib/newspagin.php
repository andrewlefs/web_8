<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home</a>");
}
$news = array();
$view = array();
$check = 0;
global $new_per_page, $newscat;

if($Webdesign == "newspagin"){
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
            //$new_per_page = is_numeric($new_per_page) && $new_per_page>0 ? $new_per_page : 1;         
        $new_per_page = 2;
            
                            $select_query = "SELECT tinid FROM tintuc ";
                            $sql->query($select_query);
                            $count_rows = $sql->num_rows();
                            
                        $position_page = isset($HTTP_GET_VARS["position_page"]) && is_numeric($HTTP_GET_VARS["position_page"])  ? $HTTP_GET_VARS["position_page"]:1; 
        $position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;
        //xac so trang
        $pages_number = ceil($count_rows/$new_per_page);
      
        $from = $position_page ==1 ? 0 : (($new_per_page*$position_page)- $new_per_page);
        
	$select_query = "SELECT tinid, tieude, trichdan, ngaydang, anhtin FROM tintuc ORDER BY ngaydang DESC LIMIT $from, $new_per_page";
	
	
	$sql->query($select_query);
	$i = 0;
	while($rows = $sql->fetch_array()){
		$ngaydang = $rows["ngaydang"];
		$i = $i + 1;
                $title = $rows["tieude"];
		$view[$i]["tinid"] 	= $rows["tinid"];
		$view[$i]["tieude"] 	= $rows["tieude"];
		$view[$i]["anhtin"] 	= $rows["anhtin"];
		$view[$i]["trichdan"] 	= $rows["trichdan"];
		$view[$i]["ngaydang"] 	= "(".gmdate("d/m/Y, h:i, a",$rows["ngaydang"] + 7*3600).")";	
	}	
	if($ngaydang>0){
		// Đếm số trang
		$select_query = "SELECT tinid FROM tintuc";
		$sql->query($select_query);
		$count_rows = $sql->num_rows();
		$pages_number = ceil($count_rows/$new_per_page);
		$position_page = isset($_GET["position_page"]) ? $HTTP_GET_VARS["position_page"] : 1;	
		$from = $position_page ==1 ? 0 : (($new_per_page*$position_page)- $new_per_page);
		// Kết thúc đếm số trang
	$select_query = "SELECT tinid, tieude, trichdan, ngaydang, anhtin FROM tintuc".
                        " WHERE ngaydang<$ngaydang  ORDER BY ngaydang DESC LIMIT $from, $new_per_page";

	$sql->query($select_query);	
	$i = 0;
		while($rows = $sql->fetch_array()){
			$i = $i + 1;
                        $title = $rows["tieude"];
			$news[$i]["tinid"] 	= $rows["tinid"];
			$news[$i]["tieude"] 	= $rows["tieude"];
			$news[$i]["anhtin"] 	= $rows["anhtin"];
			$news[$i]["trichdan"] 	= $rows["trichdan"];
			$news[$i]["ngaydang"] 	= "(".gmdate("d/m/Y, h:i, a",$rows["ngaydang"] + 7*3600).")";	
		}
	}
	else{
		$message = "Không có thông tin bạn yêu cầu !";
	}
        
	$sql->close();	
}

            $title = array(	"newspagin" => " $title",   );

                
function publish(){
	global $news, $view, $newscat, $pages_number, $position_page, $check, $dir_imgnews1;
	$newscat_id     = isset($_GET["cat"])   ? $_GET["cat"]   : (isset($_POST["cat"])  ? $_POST["cat"]  : "0");
		for($i=1; $i<=count($newscat); $i++)
		if($newscat[$i]["id"]==$newscat_id)
			$catname = $newscat[$i]["title"];
			$message = "".$catname."";
	
                        echo '<div class="cols_right news">
                        <div class="content">
                            <div class="title_sp"><span><a href="'.WEB_DOMAIN.'/index.html">Trang chủ</a>&gt;&gt;<a>Tin tức</a></span></div>
                            <div class="list_news">
                            	<ul>';
                                 if(count($view)>0){	
		for($i=1; $i<=count($view); $i++){
			$anhtin = $view[$i]["anhtin"] <> "" ? "<a href='".WEB_DOMAIN."/news-detail-".$view[$i]["tinid"].".html'><img class='img_tin' src='".WEB_DOMAIN.$dir_imgnews1.$view[$i]["anhtin"]."' width=\"140\" height=\"80\" alt='".$view[$i]["tieude"]."' title='".$view[$i]["tieude"]."'></a>" : '';
		echo '<li>';
                echo $anhtin;
                echo '  <p class="ten_tin"><a href="'.WEB_DOMAIN.'/news-detail-'.$view[$i]["tinid"].'.html">'.$view[$i]["tieude"].'</a></p>
                        <p>'.strip_tags(strimString($view[$i]["trichdan"],60)).'</p>
                        <p class="ct_tin"><a href="'.WEB_DOMAIN.'/news-detail-'.$view[$i]["tinid"].'.html">Chi tiết</a></p>
                        </li>';
		}               
            }
            else{
                    echo "".$message." đang cập nhật dữ liệu </br> </br> </br> </br>";
            }
            
       
                                echo '</ul>';
                                    if($pages_number > 1) { //neu can hien thi so trang                                
                echo '<div class="control">';
                    if($position_page!=1){
                    echo '<a href="'.WEB_DOMAIN.'/news/pages-'.($position_page-1).'">&lt;&lt;</a>';
                    }
                    if($pages_number > 3){
                    echo '<a href="'.WEB_DOMAIN.'/news/pages-1">1</a>
                    <a href="'.WEB_DOMAIN.'/news/pages-2">2</a>
                    <a href="'.WEB_DOMAIN.'/news/pages-3">3</a>......
                    <a href="'.WEB_DOMAIN.'/news/pages-'.$pages_number.'">End</a>';
                    }else if($pages_number==3){
                        echo '<a href="'.WEB_DOMAIN.'/news/pages-1">1</a>
                            <a href="'.WEB_DOMAIN.'/news/pages-2">2</a>
                            <a href="'.WEB_DOMAIN.'/news/pages-'.$pages_number.'">End</a>';
                    }  else {
                         echo '<a href="'.WEB_DOMAIN.'/news/pages-1">1</a>
                            <a href="'.WEB_DOMAIN.'/news/pages-2">2</a>';
                    }
                    if($position_page!=$pages_number){
                    echo '<a href="'.WEB_DOMAIN.'/news/pages-'.($position_page+1).'">&gt;&gt;</a>';
                        }
                    echo '</div>';
          
  }                              	
                            echo '</div>
                        </div>
                    </div>';
                            
                            
                            
                                             
           
}

?>