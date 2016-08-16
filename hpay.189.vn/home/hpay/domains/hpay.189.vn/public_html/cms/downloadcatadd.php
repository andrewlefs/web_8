<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($HTTP_POST_VARS["mode"] == "add" && isset($HTTP_POST_VARS["mode"]))
	{
		if(!session_register('countadd'))
		{
			session_register('countadd');
			$HTTP_SESSION_VARS['countadd']=0;
		}
		
		$title = convert_font($HTTP_POST_VARS["title"]);
		$publish = $HTTP_POST_VARS["publish"]==1?$HTTP_POST_VARS["publish"]:0;
		$list_order = $HTTP_POST_VARS["list_order"];
		$message1 = $title == "" ? "<li>Hãy nhập tên danh mục nhóm Download" : "";
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();		
		$n = $sql->count_rows("downloadcat");
		if($message1 =="")		
		{
			$title = convert_font($HTTP_POST_VARS["title"],2);
			$insert_query = "INSERT INTO downloadcat(title, publish, list_order) VALUES('$title', $publish, $list_order)";			
			if($sql->query($insert_query))
			{			
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message = "<li>Th&ocirc;ng tin v&#7873; danh mục nhóm Download th&#7913; ".$HTTP_SESSION_VARS['countadd']." &#273;&atilde; &#273;&#432;&#7907;c th&ecirc;m v&agrave;o CSDL";			
			}		
			$n = $sql->count_rows("downloadcat");										
			$sql->close();	
		}
	}	
	else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows("downloadcat");
			$sql->close();
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
<title>-- Add Product Categories --</title>
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
          <td width="147" bgcolor='whitesmoke' height="100%" valign="top"><?php include("menu.php"); ?></td>
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
	  <FORM action="" method=post enctype="multipart/form-data" name="cateadd" id="cateadd">
        <TABLE borderColor=whitesmoke cellSpacing=0 cellPadding=2 
            width=550 align=center border=1>
          <TBODY>
            <TR bgColor=whitesmoke>
              <TD class="header_table" 
                >Th&ecirc;m m&#7897;t danh mục nhóm Download mới</TD>
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
                      <TD align=left colSpan=4><INPUT name=title class="input_f4" id="title" size=55 maxLength=85></TD>
                    </TR>
                    <TR>
                      <TD 
                       
                      width=37>&nbsp;</TD>
                      <TD 
                       
                      align=right width=46>
                        <P align=left class="header_table">Show:</P></TD>
                      <TD 
                       
                      align=right width=26>
                        <P align=center>
                          <INPUT name=publish type=checkbox id="publish" style="FLOAT: left" 
                        value=1 checked>
                      </P></TD>
                      <TD 
                       
                      align=right width=36>
                        <P align="left" class="header_table">Order:</P></TD>
                      <TD align="left" width="163">
                         <SELECT name=list_order size=1 id="list_order">
						 <?php  
						 for($i=1; $i<=$n; $i++){
						 ?>
						 	<OPTION value="<?=$i?>"><?=$i?></OPTION>
						 <?php }
						 ?>
                             <OPTION value="<?=$n+1?>" selected><?=$n+1?></OPTION>
                          </SELECT>
                      </TD>
                    </TR>
                    <TR>
                      <TD 
                       
                      width=37>&nbsp;</TD>
                      <TD width=46 
                       
                      align=right class="manager_link"><input style="BORDER-RIGHT: #4565b4 1px solid; BORDER-TOP: #4565b4 1px solid; FLOAT: left; BORDER-LEFT: #4565b4 1px solid; BORDER-BOTTOM: #4565b4 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #ffffff" type=submit value=Add name=submit></TD>
                      <TD 
                       
                      align=right width=26>
                        <P align=center>&nbsp;</P></TD>
                      <TD 
                       
                      align=right width=36>&nbsp;</TD>
                      <TD                        
                      align=right width=163>
                        <P 
                align=center>&nbsp;</P></TD>
                    </TR>
                  </TBODY>
                </TABLE>
                <BR>
      <?php if($message!="") echo "<br>".$message; if($message1!="") echo "<br>".$message1; ?></TD>
            </TR>
          </TBODY>
        </TABLE>
        <br>
        <input name="pages" type="hidden" id="pages" value="cate">
        <input name="mode" type="hidden" id="mode" value="add">
	  </FORM>
	  <p align="center">&nbsp;</p>
	  </div></td>
        </tr>
</table> 
</div></body>
</html>