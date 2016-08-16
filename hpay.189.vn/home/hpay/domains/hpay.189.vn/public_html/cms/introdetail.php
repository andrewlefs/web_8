<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($HTTP_GET_VARS[mode] == "detail" && $HTTP_GET_VARS["pages"]=="intro")
	{
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT title, content FROM intro WHERE id = '$id'";
					

		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
		
		$title 		= $row["title"]; 
		$content 	= nl2br($row["content"]); 
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
<title>-- Detail Information of Introduction --</title>
</head>
<body><div align="center">
<br>
<table width="500" align="center" cellspacing="0">
  <form action="index.php?pages=book&mode=add" method="post" enctype="multipart/form-data" name="addbook" id="addbook">
    <tr>
      <td width="634" valign="top" bgcolor="#d4d0c8">
        <table bgcolor="whitesmoke"  width="500" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> <div align="center">NỘI DUNG CHI TIẾT<br>
            </div></td>
          </tr>
          <tr class="book_tr">
            <td width="19%"   class="book_tr_left" >Tiêu đề:</td>
            <td width="81%"   colspan="3">
              <span class="header_table">
              <?=$title?>
            </span></td>
          </tr>
          <tr class="book_tr">            
          </tr>          
          <tr  class="book_tr">
            <td  valign="top" class="book_text" >Nội dung:</td>
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