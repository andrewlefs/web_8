<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($HTTP_GET_VARS[mode] == "detail")
	{
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT d.title,intro,content,filename,dc.title downloadcat_title ".
		"FROM download d INNER JOIN downloadcat dc ON d.downloadcat_id = dc.id ".
		"WHERE d.id = '$id'";

		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
		
		$title 	= $row["title"]; 
		$intro 	= nl2br($row["intro"]);
		$downloadcat_title 	= nl2br($row["downloadcat_title"]);
		$content 	= nl2br($row["content"]); 
		$filename		= $row["filename"]; 	
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
<title>-- Detail Information of Download --</title>
</head>
<body><div align="center">
<br>
<table width="600" align="center" cellspacing="0">
  <form action="index.php?pages=book&mode=add" method="post" enctype="multipart/form-data" name="addbook" id="addbook">
    <tr>
      <td valign="top" bgcolor="#d4d0c8">
        <table bgcolor="whitesmoke"  width="634" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> <div align="center">TH&Ocirc;NG TIN CHI TIẾT<br>
            </div></td>
          </tr>
          <tr class="book_tr">
            <td width="28%"   class="book_tr_left" >Ti&ecirc;u &#273;&#7873; Download: </td>
            <td width="72%"   colspan="3">
              <span class="header_table">
              <?=$title?>
            </span></td>
          </tr>
          <tr class="book_tr">
            <td  class="book_text" >Category</td>
            <td  colspan="3"><?=$downloadcat_title?>
              <div align="justify"></div></td>
          </tr>
          <tr class="book_tr">
            <td  class="book_text" >File</td>
            <td  colspan="3"><?=$filename?>
              <div align="justify"></div></td>
          </tr>          
          <tr  class="book_tr">
            <td  valign="top" class="book_text" >Nội dung chi tiết:</td>
            <td valign="top"  colspan="3">
              <p align="justify">
                <?=$content?>
              </p></td>
          </tr>
          <tr  class="book_tr">
            <td colspan="4"  valign="top" class="book_text" ><div align="center">
              <p>&nbsp;</p>
              <p><a href="javascript:print()">Print</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:close()">Close</a></p>
            </div></td>
          </tr>
      </table></td>
    </tr>
  </form>
</table>
<br>
	<br>
</div></body>
</html>