<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($HTTP_GET_VARS["mode"] == "detail" && $HTTP_GET_VARS["pages"]=="contact")
	{
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT name,office, address, title, email, tel, content, senddate FROM ".DB_PREFIX."contact WHERE contactid = $id";
					

		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
		
		$name	 	= $row["name"];
		$office	 	= $row["office"];
		$address	= $row["address"];		
		$title	 	= $row["titlec"]; 
		$tel	 	= $row["tel"]; 
		$email	 	= $row["email"]; 
		$content 	= $row["content"]; 
		$senddate = gmdate("d/m/Y, h:i, a",$row["senddate"] + 7*3600);
		$sql->close();
	}
	
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styledetai.css" />

<title>-- Detail Information of Contact --</title>
</head>
<body><div align="center">
<br>
<table width="600" align="center" cellspacing="0">
  <form action="index.php?pages=book&mode=add" method="post" enctype="multipart/form-data" name="addbook" id="addbook">
    <tr>
      <td valign="top" bgcolor="#d4d0c8">
        <table bgcolor="whitesmoke"  width="100%" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> <div align="center">TH&Ocirc;NG TIN CHI TIẾT V&#7872; TH&#431; LI&Ecirc;N H&#7878; HOẶC GÓP &Yacute; CỦA KHÁCH HÀNG<br>
            </div></td>
          </tr>
          <tr class="book_tr">
            <td width="20%"   class="book_tr_left" >T&ecirc;n khách hàng:</td>
            <td width="80%"   colspan="3">
              <span class="header_table">
              <?=$name?>
            </span></td>
          </tr>
          <tr class="book_tr">
            <td   class="book_tr_left" >Cơ quan: </td>
            <td  colspan="3"><span class="header_table">
              <?=$office?>
            </span></td>
          </tr>
          <tr class="book_tr">
            <td   class="book_tr_left" >Địa chỉ liên hệ:</td>
            <td  colspan="3"><span class="header_table">
              <?=$address?>
            </span></td>
          </tr>
          <tr class="book_tr">
            <td   class="book_tr_left" >&#272;iện thoại:</td>
            <td  colspan="3">
              <span class="header_table">
              <?=$tel?>
</span>            </td>
          </tr>
          <tr class="book_tr">
            <td  class="book_text" >Email:</td>
            <td  colspan="3"><a href='mailto:<?=$email?>'><?=$email?></a>
              <div align="justify"></div></td>
          </tr>
          <tr  class="book_tr">
            <td  valign="top" class="book_text" >Ti&ecirc;u &#273;&#7873; th&#432; :</td>
            <td valign="top"  colspan="3">
              <p align="justify">
                <?=$title?>
                <span class="header_table">(ngày gửi:
                <?=$senddate?>
)</span> </p></td>
          </tr>
          <tr  class="book_tr">
            <td  valign="top" class="book_text" >Nội dung :</td>
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
</table><br>
	<br>
</div></body>
</html>