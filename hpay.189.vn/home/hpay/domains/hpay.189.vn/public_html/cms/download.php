<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	$select_query = "SELECT id, title FROM downloadcat WHERE publish=1 ORDER BY list_order, title";
	$sql->query($select_query);
	$i = 0;
	while($rows = $sql->fetch_array()){
		$i = $i + 1;
		$downloadcat[$i]["id"] 		= $rows["id"];
		$downloadcat[$i]["title"] 	= $rows["title"];	
	}
	$downloadcat_id	= isset($_GET["downloadcat_id"])   ? $_GET["downloadcat_id"]   : (isset($_POST["downloadcat_id"])  ? $_POST["downloadcat_id"]  : "");	
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($download_per_pagead*$position_page)- $download_per_pagead);
	$count_rows = $sql->count_rows("download");
	$pages_number = ceil($count_rows/$download_per_pagead);
	
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	//Hien thi thong tin
	$select_query = "SELECT id, title, list_order, publish FROM download ".($downloadcat_id>0?"WHERE downloadcat_id = $downloadcat_id":"")." ORDER BY list_order LIMIT $from, $download_per_pagead";
	$sql->query($select_query);
	$n = $sql->num_rows();					
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../style/mstyle.css" rel=stylesheet type=text/css>
<script language='Javascript' src='viettyping.js'></script>
<title>-- Download --</title>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/javascript">
<!--
	function delNew(id) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=download&mode=del&id=" + id);			
		}
	}
	function open_window(id){
			window.open("index.php?pages=download&mode=detail&id=" +id ,"","width=700,height=400,left=0,top=0,scrollbars=yes");
	}
-->
</script>
</head>
<body><div align="center">
	<table width="100%" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td width="143" align="center" bgcolor='#1d4b8c' class="logout"><img src=logo_corprations_CMS.png border="0"></td>
	<td align="center" valign="bottom" bgcolor='#1d4b8c' class="menu_bar_manager">[ <a href="index.php?pages=download&mode=add">Th&ecirc;m Download </a>] [<a href="index.php?pages=download">Danh sách Download </a>]</td>
    <td width="143" align="right" valign="top" bgcolor='#1d4b8c' class="logout"><img src=close.gif border="0">&nbsp;&nbsp;<a href="index.php?pages=logout">Logout</a></td>
    </tr>
</table> 
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor='whitesmoke' width="200" height="100%" valign="top"></td>
     <td width="98%" bgcolor='#FFFFFF'  valign="top">
	 <? if($count_rows>0){ ?>
  </form>
	<center>	<div align="center">
	  <?php if(!message=="") echo "<span class='error'>".$message."</span>"; ?>
	 <br>	  
<table width="98%">
 <tr>
<td class="header_table" bgColor="whitesmoke"><?php pages_browser_admin("index.php?pages=download&position_page=",$position_page,$pages_number);?></td>
        </tr>
      </table>
	<table width="550">
        <tr>
          <td class="header_table">C&oacute; <span class="style1"><?=$count_rows?></span> Download </td>
        </tr>
        <tr>
          <td class="header_table"><div align="right">Lọc theo nhóm&nbsp;
		  <select size="1" name="downloadcat_id" id="downloadcat_id"
			  onchange="document.location='index.php?pages=download&downloadcat_id=' + document.getElementById('downloadcat_id').value ">
				  <option value="0">All</option>
				  <?php
				  for($i=1;$i<=count($downloadcat);$i++)
				  	if($downloadcat[$i]["id"] == $downloadcat_id)
						echo "<option value='".$downloadcat[$i]["id"]."' selected>".$downloadcat[$i]["title"]."</option>";
					else
						echo "<option value='".$downloadcat[$i]["id"]."'>".$downloadcat[$i]["title"]."</option>";
				  ?>
			  </select></div>
		  </td>
        </tr>
      </table>
	  <table borderColor="whitesmoke" cellSpacing="0" cellPadding="2" width="98%" align="center" border="1">
        <tr bgColor="whitesmoke">
          <td width="33" align="middle" class="colum_order" > TT </td>
          <td width="265" class="header_table" > T&ecirc;n Download </td>
          <td width="137" class="header_table" >Hiển thị </td>
          <td >&nbsp; </td>
        </tr>
		<?php
        for($i=1; $i<$n+1; $i++)
		{
			$from = $from + 1;		
			$row = $sql->fetch_array();
			$id = $row['id'];
			$title = $row['title'];
			$publish = $row['publish'];
		?>
		<tr>
          <td align="middle" class="colum_order" > <?= $from ?></td>
          <td class="header_table" ><span class="manager_link"><a title="Information detail" style="CURSOR: hand" onClick="open_window(<?=$id ?>)">
            <?= $title ?>
          </a></span></td>
          <td class="header_table" ><?=$publish==1?"Có":"Không"?></td>
          <td width="89" >
            <table cellSpacing="0" cellPadding="2" width="72" border="0">
              <tr>
                <td > <a style="CURSOR: hand" href="index.php?pages=download&mode=edit&position_page=<?=$position_page?>&id=<?= $id ?>"> <img border="0" alt="Edit" src="../images/edit_button.gif" width="36" height="13"></a></td>
                <td > <a style="CURSOR: hand" onClick="delNew(<?=$id ?>)"> <img height="13" alt="Delete" src="../images/del_button.gif" width="36" border="0"></a></td>
              </tr>
          </table></td>
        </tr>
		<?php 
		} $sql->close();
		?>
      </table>
	  <br>	  
<table width="98%">
 <tr>
<td class="header_table" bgColor="whitesmoke"><?php pages_browser_admin("index.php?pages=download&position_page=",$position_page,$pages_number);?></td>
        </tr>
      </table>	  
	</div>
	<?
	}else echo"<br><div align=center>&nbsp;&nbsp;Chưa có Download nào trong CSDL !</div>";
	?></td>
        </tr>
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