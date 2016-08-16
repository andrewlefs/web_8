<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();

	if($HTTP_GET_VARS[mode] == "edit")
	{
		$id = $_GET["id"];
		$select_query = "SELECT title, publish, list_order FROM downloadcat WHERE id = $id";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$title = $row["title"];
		$publish = $row["publish"];
		$list_order = $row["list_order"];
		$n = $sql->count_rows("downloadcat");	
	}
	
	if($HTTP_POST_VARS[mode] == "edit")
	{
		$id = $_POST["id"];
		$title = convert_font($_POST["title"],2);
		$publish = $_POST["publish"]==1?$_POST["publish"]:0;
		$list_order = $_POST["list_order"];
		$update_query = "UPDATE downloadcat SET title='$title', publish=$publish, list_order=$list_order  WHERE id = $id";

		$sql->query($update_query);
		$sql->close();
		$message = "<li>Cập nhật thành công !";
		require_once("downloadcat.php");
		exit();
	}	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META content="DEMO - Thuong mai dien tu - Kinh doanh tren Internet - Quang ba san pham..." name=keywords>
<META content="DEMO" name=description>
<LINK href="../style/mstyle.css" rel=stylesheet type=text/css>
<script language='Javascript' src='viettyping.js'></script>
<title>-- Edit Product Categories --</title>
</head>
<body><div align="center">
	<table width="780" border="0" align="center" cellpadding="2" cellspacing="0">
	<tbody>
	  <tr>
	    <td width="143" align="center" bgcolor='whitesmoke' class="logout">[ <a href="index.php?pages=logout">Logout</a> ]</td>
	    <td align="center" bgcolor='whitesmoke' class="menu_bar_manager">[ <a href="index.php?pages=downloadcat&mode=add">Th&ecirc;m nhóm Download </a>] [ <a href="index.php?pages=downloadcat">Danh sách nhóm Download</a> ]</td>
      </tr>
	  </tbody>
</table> 
	
	
      <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor='whitesmoke' width="147" height="100%" valign="top"><?php include("menu.php"); ?></td>
     <td width="633" valign="top">
  </form>
	<center>
	<div align="center">
	  <br>
	  <TABLE id=table21 cellSpacing=0 cellPadding=2 width=550 align=center 
            border=0>
        <TBODY>
          <TR>
            <TD width="50" 
                ><A 
                  style="COLOR: navy; TEXT-DECORATION: none" 
                  href="index.php?pages=downloadcat"><IMG 
                  height=15 alt="Danh sách danh mục nhóm Download" src="../images/back.gif" 
                  width=15 border=0></A></TD>
            <TD width="492" 
                >&nbsp;</TD>
          </TR>
        </TBODY>
	    </TABLE>
	  <FORM action="" method=post enctype="multipart/form-data" name="cateedit" id="cateedit">
        <TABLE borderColor=whitesmoke cellSpacing=0 cellPadding=2 
            width=550 align=center border=1>
          <TBODY>
            <TR bgColor=whitesmoke>
              <TD class="header_table" 
                >Sửa th&ocirc;ng tin cho m&#7897;t Danh mục nhóm Download</TD>
            </TR>
            <TR>
              <TD class="header_table" 
                ><BR>
      &nbsp;
                <TABLE cellSpacing=0 cellPadding=2 width=328 
                  align=center border=0>
                  <TBODY>
                    <TR>
                      <TD 
                      width=37 class="header_table" 
                      >Name:</TD>
                      <TD align=left colSpan=4><INPUT name=title class="input_f4" id="title" value="<?=$title?>" size=55 maxLength=85></TD>
                    </TR>
                    <TR>
                      <TD 
                       
                      width=37>&nbsp;</TD>
                      <TD class="header_table" width=59>
                        Show:</TD>
                      <TD 
                       
                      align=right width=35>
                        <P align=center>
                          <INPUT name=publish type=checkbox id="publish" style="FLOAT: left" 
                        value=1 <?=$publish==1?"checked":""?>>
                      </P></TD>
                      <TD 
                       
                      align=right width=37>
                        <P align=left class="header_table">Order:</P></TD>
                      <TD align=left width=186>
                         <SELECT name=list_order size=1 id="list_order">
						 <?php  
						 for($i=1; $i<$n+1; $i++) 
						 {
						 	if ($i == $list_order){
						 ?>
                            <OPTION value="<?=$i?>" selected><?=$i?></OPTION>                            
						 <?php }else { ?>
						 	<OPTION value="<?=$i?>"><?=$i?></OPTION>
						 <?php }}?>
                          </SELECT>
                      </TD>
                    </TR>
                    <TR>
                      <TD 
                       
                      width=37>&nbsp;</TD>
                      <TD width=59 
                       
                      align=right class="manager_link"><input style="BORDER-RIGHT: #4565b4 1px solid; BORDER-TOP: #4565b4 1px solid; FLOAT: left; BORDER-LEFT: #4565b4 1px solid; BORDER-BOTTOM: #4565b4 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #ffffff" type=submit value=Update name=submit></TD>
                      <TD 
                       
                      align=right width=35>
                        <P align=center>&nbsp;</P></TD>
                      <TD 
                       
                      align=right width=37>&nbsp;</TD>
                      <TD                        
                      align=right width=186>
                        <P 
                align=center>&nbsp;</P></TD>
                    </TR>
                  </TBODY>
                </TABLE>
                <BR>
      <?php if($message!="") echo "<br>".$message; ?></TD>
            </TR>
          </TBODY>
        </TABLE>
        <br>
        <input name="pages" type="hidden" id="pages" value="cate">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </FORM>
	  <p align="center">&nbsp;</p>
	  </div></td>
        </tr>
</table> 
</div></body>
</html>