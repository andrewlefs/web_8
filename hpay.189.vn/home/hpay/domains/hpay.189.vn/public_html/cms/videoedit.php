<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();	
	$sql->db_select();	
	
	if($HTTP_GET_VARS["mode"] == "edit" && $HTTP_GET_VARS["pages"] == "video"){
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT vdname, creator, videos, author FROM videos WHERE vdid = '$id'";

		$sql->query($select_query);
		$row = $sql->fetch_array();
		$vdname 	= $row["vdname"];
		$creator 	= $row["creator"]; 		
		$videos		= $row["videos"]; 	
		$author		= $row["author"]; 	
		$position_page = $_GET["position_page"];
		$n = $sql->count_rows("videos");
	}	
		

	if($HTTP_POST_VARS["mode"] == "edit" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["pages"] == "video"){
		$id = $_POST["id"];			
		$n = $sql->count_rows("videos");
		$vdname 	= isset($_POST["vdname"])			? convert_font($_POST["vdname"])		: '';
		$creator 	= isset($_POST["creator"])			? convert_font($_POST["creator"])		: '';		
		$videos 	= isset($_POST["videos"])			? convert_font($_POST["videos"])		: '';		
		$author 	= isset($_POST["author"])			? convert_font($_POST["author"])		: '';		
		$position_page = $_POST["position_page"];		
		if($vdname 		== "") $message1 = $message1."<li/>Hãy nhập tên dịch vụ";
		$n = $sql->count_rows("videos") + 1;
		
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$vdname 	= isset($_POST["vdname"])		? convert_font($_POST["vdname"],2)		: '';
			$videos 	= isset($_POST["videos"])		? convert_font($_POST["videos"],2)		: '';
			
			$update_query = "UPDATE videos SET vdname = '$vdname', creator = '$creator', 
							 videos = '$videos', author = '$author' WHERE vdid = $id ";
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."<li>Cập nhật thành công !";
				include_once("video.php");
				exit();
			}
		}
	}	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../style/mstyle.css" rel=stylesheet type=text/css>
<script language='Javascript' src='viettyping.js'></script>
<title>-- Edit Services --</title>
</head>
<body><div align="center">
	<table width="100%" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td width="143" align="center" bgcolor='#1d4b8c' class="logout"><img src=logo_corprations_CMS.png border="0"></td>
	<td align="center" valign="bottom" bgcolor='#1d4b8c' class="menu_bar_manager">[<a href="index.php?pages=video&mode=add">Thêm mới</a>] [ <a href="index.php?pages=video">Danh Sách</a> ]</td>
    <td width="143" align="right" valign="top" bgcolor='#1d4b8c' class="logout"><img src=close.gif border="0">&nbsp;&nbsp;<a href="index.php?pages=logout">Logout</a></td>
    </tr>
</table> 
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

        <tr>
          <td bgcolor='whitesmoke' width="200" height="100%" valign="top"><?php include("menu.php"); ?></td>
	<td width="99%" bgcolor='#ffffff' valign="top">
  	<center>	<div align="center"><br>
	  <table width="99%" valign="top">
        <tr>
          <td class="header_table"><a href="index.php?pages=video"><img height=15 alt="Danh sách dịch vụ" src="../images/back.gif" width=15 border=0></a></td>
        </tr>
        <tr>
          <td class="header_table"><?php if($message!="") echo $message; if($message1!="") echo $message1; ?></td>
        </tr>
      </table>
	  
	    <table width="100%" cellspacing="0">
		<form action="index.php" method="post" enctype="multipart/form-data" name="updatevideo" id="updatevideo">
        <tr>
          <td valign="top" bgcolor="#d4d0c8">		  		  
		  <table bgcolor="whitesmoke"  width="100%" cellpadding="0" cellspacing="1" >
              <tr class="header_table">
                <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> Sửa thông tin dịch vụ<br></td>
              </tr>
              <tr class="book_tr">
                <td width="28%"   class="book_tr_left" >Tên video:</td>
                <td width="72%"  colspan="3">
                  <input name="vdname" class="input_b3" id="vdname" value="<?=$vdname?>" size="18"></td>
              </tr>
			<tr class="book_tr">
                <td width="28%"   class="book_tr_left" >Tác giả:</td>
                <td width="72%"  colspan="3">
                  <input name="author" class="input_b3" id="author" value="<?=$author?>" size="18"></td>
              </tr>
            <tr class="book_tr">
                <td width="28%"   class="book_tr_left" >Ca sỹ:</td>
                <td width="72%"  colspan="3">
                  <input name="creator" class="input_b3" id="creator" value="<?=$creator?>" size="18"></td>
              </tr>
			<tr class="book_tr">
                <td width="28%"   class="book_tr_left" >Link Video:</td>
                <td width="72%"  colspan="3">
                  <input name="videos" class="input_b3" id="videos" value="<?=$videos?>" size="18"></td>
              </tr>
		      <tr class="book_tr" >
                <td valign="top" ></td>
                <td valign="top"  colspan="3"><input type="submit" name="Submit" value="Update"> 
				  <input name="pages" type="hidden" id="pages" value="video">        
				  <input name="mode" type="hidden" id="mode" value="edit">
                  <input name="position_page" type="hidden" id="vdid_old" value="<?=$position_page?>">
                  <input name="id" type="hidden" id="id" value="<?=$id?>"></td>
              </tr>			  
          </table>		  
	  	  </td></tr>
		  </form>
      </table>	    
	</div></td>
        </tr>
</table> 
	<table width="100%" height="90" border="0" align="center" cellpadding="2" cellspacing="0">
	<tbody>
	<tr>
	<td width="143" align="center" bgcolor='#1d4b8c' class="logout"><img src=logo_corprations_CMS.png border="0"></td>
	<td align="center" bgcolor='#1d4b8c' class="menu_bar_manager">Bản quyền thuộc về Công ty công nghệ truyền thông Hoàng Gia</td>
    </tr>
	</tbody>
</table>
</table> 
</div></body>
</html>