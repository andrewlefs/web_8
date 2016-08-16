<?php
define("qaz_wsxedc_qazxc0FD_123K",true);
$web_domain1 = 'http://localhost/bom';
define('WEB_DOMAIN1',$web_domain1);

include('../config/define.php');
$phpbb_root_path = '../config/';

include($phpbb_root_path."mysql.php");
include($phpbb_root_path."config.php");
include($phpbb_root_path."session.php");
include($phpbb_root_path."global.php");
include($phpbb_root_path."function.php");
include("fs_output.php");

if($_POST['page'])
{
                        $page = $_POST['page'];
                        $cur_page = $page;
                        $page -= 1;
                        $per_page = 9;
                        $previous_btn = true;
                        $next_btn = true;
                        $first_btn = true;
                        $last_btn = true;
                        $start = $page * $per_page;


                         global $dir_imgproducts1;
	$proindex = array();
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();			
		
		$select_query = "SELECT  sanphamid, ten, km, mota, anh, gia, baohanh  FROM sanpham  WHERE noibat = 1  ORDER BY gia DESC LIMIT $start, $per_page";
		$sql->query($select_query);
		$k = 0;
		while($rows = $sql->fetch_array()){
			$k = $k + 1;
			$proindex[$k]["id"]             = $rows["sanphamid"];
			$proindex[$k]["ten"] 		= $rows["ten"];
                                                                                $proindex[$k]["km"] 		= $rows["km"]==1 ? '' : '<li class="hethang">KM: '.$rows["km"].'</li>';
                                                                                $proindex[$k]["anh"] 		= $rows["anh"];	
			$proindex[$k]["gia"] 		= $rows["gia"];
			$proindex[$k]["catid"] 		= $rows["catid"];
                                                                                $proindex[$k]["baohanh"]        = $rows["baohanh"];	
			$proindex[$k]["mota"]           = $rows["mota"];
                                                                                $proindex[$k]["url"]            = WEB_DOMAIN1.'/istore/'.$rows["sanphamid"].'-'.huu($rows["ten"]).'.html';
                     
		}	
    
                                                    $msg .=  '<ul>';
                                                                 for($j=1; $j<=count($proindex); $j++){
                                                                    if($j%3!==0){ $classr =  ""; } else {$classr =  "rr";  }
                                                                     $msg .='
                                                                           <li class="'.$classr.'">
                                                                               <div class="img_sp"><a href="'.$proindex[$j]["url"].'"><img src="'.WEB_DOMAIN1.$dir_imgproducts1.$proindex[$j]["anh"].'" alt="'.$proindex[$j]["ten"].'" /></a></div>
                                                                               <a href="'.$proindex[$j]["url"].'" class="title">'.$proindex[$j]["ten"].'</a>
                                                                               <p class="tinhtrang">Còn hàng</p>
                                                                               <p class="gia">'.gia($proindex[$j]["gia"]).'</p>
                                                                               <p><a href="'.$proindex[$j]["url"].'" class="ct" >Chi tiết</a></p>
                                                                           </li>';
                                                                        }                   
                                                                   $msg .= '</ul><div class="clear"></div>';


/* --------------------------------------------- */
             
$query_pag_num = "SELECT count(*) as count FROM sanpham WHERE  noibat = 1 ";

$result_pag_num = mysql_query($query_pag_num);


$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];


 mysql_close();

if($count > 0){
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='pagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}

//$total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
$msg = $msg . "</ul></div>";
echo $msg;
}  else {
    echo "Đang cập nhật dữ liệu";
}
}

?>
