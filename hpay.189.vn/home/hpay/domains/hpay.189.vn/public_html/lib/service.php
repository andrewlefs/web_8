<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Trang ch&#7911;</a>");
}
$servi_detail 	= array();
$servi			= array();
$sql = new db_sql();
$sql->db_connect();
$sql->db_select();

if(isset($_GET["id"]) && $HTTP_GET_VARS["Webdesign"] == "service"){
	$id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 0;

	$select_query = "SELECT servicename, serviceimg, servicein, content FROM service WHERE serviceid = $id";
	$sql->query($select_query);							
	if($row = $sql->fetch_array()){
		$title 	= $row["servicename"];
		$servi_detail["servicename"] 	= $row["servicename"];
		$servi_detail["serviceimg"] 	= $row["serviceimg"];
		$servi_detail["servicein"] 	= $row["servicein"];
		$servi_detail["content"] 	= $row["content"];
	}
	$title = array(
	"service" => "$title",
 	);
	$select_query = "SELECT serviceid, servicename FROM service WHERE serviceid<>$id";		
	$sql->query($select_query);							
	$i=0;
	while($row = $sql->fetch_array()){
		$i = $i+1;
		$servi[$i]["serviceid"] = $row["serviceid"];
		$servi[$i]["servicename"] = $row["servicename"];
	}
	$sql->close();		
}

function detail_service(){
	global $servi_detail, $dir_imgservice1, $ser, $servi;	
	if(count($servi_detail)>0){
	    echo "<h1><a href='".$_SERVER['REQUEST_URI']."' title='".$servi_detail["servicename"]."'>".$servi_detail["servicename"]."</a></h1>";
		echo "".$servi_detail["content"]."<br/>";
		
				echo "<div class='social_div'>";
			echo "<div class='social_div_150'>";		
				echo "<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-count=\"horizontal\" data-via=\"hoanggiwebsite\">Tweet</a>";
					echo "<script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>";
		echo "</div>";
			echo "<div class='social_div_150'>";
				echo "<g:plusone size=\"medium\"></g:plusone>";	
					echo "</div>";
		echo "</div>";
		
		echo "<div class='tags'>";
		echo "&nbsp;&nbsp; &nbsp; Tags:";
		for($i=1; $i<=count($ser); $i++){
		echo "<a href='".WEB_DOMAIN."/3-".$ser[$i]["serviceid"]."-".cut_space(name_ascii($ser[$i]["servicename"])).".htm' title='".$ser[$i]["servicename"]."'>".strip_tags(strimStringA($ser[$i]["servicename"],3))."</a>";
		}		
		echo "</div>";
		
		echo "<div class='trangin'>";
		echo "<a class='quaylai fl kc_c' href='javascript:history.back(-1)'>Trang tr&#432;ớc</a>";
			echo "<a href='mailto:".$dmail."' class='mail fl kc_c' title='Gửi e-Mail'>Gửi e-Mail</a>";
			echo "<a href='javascript:print()' class='fl print kc_c' title='In trang này'>In trang</a>";
			echo "<a href='#' class='fl ontop kc_c' title='In trang này'>Trang đầu</a>";
		echo "</div>";	
	}else echo "<br><font face='Arial, Tahoma' size='2'>Không có dữ liệu bạn yêu cầu !</font>";		
}
?>