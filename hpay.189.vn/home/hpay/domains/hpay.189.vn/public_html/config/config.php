<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){
	die("<a href='../index.php'>Login</a> to Web Contents Manager !");
	}
$server 		= "localhost";
$database 		= "hpay_db";
$username 		= "hpay_db";
$password 		= "yzxo5pPl";
define('DB_PREFIX', 'kien_');
ini_set("register_globals","Off");
$dmail			= "contact@hoanggia.biz";
$dir_download 		= "../uploads/download/";
$dir_imgproducts 	= "../uploads/imgproducts/";
$dir_imgnews 		= "../uploads/imgnews/";
$dir_imgcustomer	= "../uploads/imgcustomer/";
$dir_imgservice 	= "../uploads/imgservice/";
$dir_imgdomain 		= "../uploads/imgdomain/";
$dir_imgblocks 		= "../uploads/imgblocks/";
$dir_imglogos 		= "../uploads/imglogos/";
$dir_imgslider		= "../uploads/imgslider/";
$dir_imgvideos 		= "../uploads/imgblocks/";
$dir_img	 	= "../uploads/";
$dir_imgmedias		= "../uploads/";
$dir_imgmdata		= "../uploads/imgdata/";
$dir_imgmother                            =   "../uploads/imgother/";

$dir_imgproducts1 	= "/uploads/imgproducts/";
$dir_imgnews1 		= "/uploads/imgnews/";
$dir_imgslider1		= "/uploads/imgslider/";
$dir_imgcustomer1 	= "/uploads/imgcustomer/";
$dir_imgservice1 	= "/uploads/imgservice/";
$dir_imgdomain1 	= "/uploads/imgdomain/";
$dir_imgblocks1 	= "/uploads/imgblocks/";
$dir_imglogos1 		= "/uploads/imglogos/";
$dir_imglogos2 		= "uploads/imglogos/";
$dir_img1	 	= "/uploads/";
$dir_imgmedias1	 	= "/uploads/";
$dir_imgmdata1		= "/uploads/imgdata/";
$dir_imgmother1                            =   "/uploads/imgother/";

$sql = new db_sql();
$sql->db_connect();
$sql->db_select();	
$counter = $sql->get_counter();
//get configuration
$select_query = "SELECT * FROM kien_configuration";
$sql->query($select_query);
if($rows = $sql->fetch_array()){
		$ratio_image_width 		= $rows["ratio_image_width"];
		$max_logo 			= $rows["max_logo"];
		$logo_position 			= $rows["logo_position"];
		$rows_per_page_of_product 	= $rows["rows_per_page_of_product"];
		$rows_per_page_of_search 	= $rows["rows_per_page_of_search"];
		$rows_of_home_search 		= $rows["rows_of_home_search"];
		$rows_per_page_customer 	= $rows["rows_per_page_customer"];
		$new_per_page		 	= $rows["new_per_page"]; 
		$faq_per_page 			= $rows["faq_per_page"];
		$story_per_page 		= $rows["story_per_page"];
		$intro_per_page 		= $rows["intro_per_page"];
		$latest_news 			= $rows["latest_news"];
		$new_per_page 			= $rows["new_per_page"];
		$new_per_pagead 		= $rows["new_per_pagead"];
		$cut_per_page 			= $rows["cut_per_page"];
		$download_per_page		= $rows["download_per_page"];
		$download_per_pagead		= $rows["download_per_pagead"];
		$download_basepath		= $rows["download_basepath"];
}
else	//Get DEFAULT SETTING
{
		$ratio_image_width 		= 234;
		$max_logo 			= 10;
		$logo_position 			= "right";
		$admin_paga 			= 28; 
		$rows_per_page_customer 	= 12; 
		$rows_per_page_of_search  	= 15;
		$rows_of_home_search  		= 18;
		$rows_per_page_of_product 	= 20;
		$new_per_pagead 		= 50;
		$cut_per_page 			= 8;
		$faq_per_page 			= 10;
		$story_per_page 		= 8;
		$download_per_page		= 10;
		$download_per_pagead		= 30;
		$admin_page			= 50;
		$intro_per_page 		= 8;
		$latest_news 			= 5;
		$ctm_news 			= 10;
		$dew_news 			= 10;
		$new_per_page 			= 9;
		$list_web_st			= 10;
		$video_page			= 3;
		$mauweb_page			= 24;
		$download_basepath		= "/uploads/download/";
}
$sql->close();
?>