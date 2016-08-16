<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($_GET[mode] == "detail")
	{
		$id = $_GET["id"];
		$select_query = "SELECT * FROM member WHERE memberid = '$id'";
					

		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
		
		$memberid  	= $row["memberid"];
		$fullname  	= $row["fullname"]; 
		$user  		= $row["user"]; 
		$pass  		= $row["pass"]; 
		$phone  	= $row["phone"];
		$workphone  = $row["workphone"];  
		$email  	= $row["email"];
		$address   	= $row["address"];
		$signdate	= gmdate("d/m/Y",$row["signdate"] + 7*3600);
		$sql->close();
	}
	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../style/mstyle.css" rel=stylesheet type=text/css>
<title>-- Admin --</title>
</head>
<body>
<br>
<table width="600" align="center" cellspacing="0">
    <tr>
      <td valign="top" bgcolor="#d4d0c8">
        <table bgcolor="#efefef"  width="634" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="#efefef" class="book_header"> <div align="center">TH&Ocirc;NG TIN CHI TIẾT KHÁCH HÀNG<br>
            </div></td>
          </tr>
          <tr class="book_tr">
            <td width="28%"class="book_tr_left" >Tên khách hàng: </td>
            <td width="72%" colspan="3" class="header_table">
              <?=$fullname?>
          </td>
          </tr>
          <tr class="book_tr">
            <td class="book_tr_left" >Username:</td>
            <td colspan="3" class="header_table">
              <?=$user?>
             </td>
          </tr>
		   <tr class="book_tr">
            <td class="book_tr_left" >Password:</td>
            <td colspan="3" class="header_table">
              <?=$pass?>
              </td>
          </tr>
          <tr class="book_tr">
            <td class="book_text" >Email:</td>
            <td colspan="3" class="header_table"><?=$email?>
             </td>
          </tr>          
		   <tr  class="book_tr">
            <td  valign="top" class="book_text" >Số điện thoại di động:</td>
<td valign="top"  colspan="3" class="header_table">
                <?=$phone?>
             </td>
          </tr>
          <tr  class="book_tr">
            <td  valign="top" class="book_text" >Số điện thoại cố định:</td>
            <td valign="top"  colspan="3" class="header_table">
                <?=$workphone?>
             </td>
          </tr>
		   <tr  class="book_tr">
            <td  valign="top" class="book_text" >Địa chỉ:</td>
<td valign="top" colspan="3" class="header_table">
                <?=$address?>
              </td>
          </tr>
		   <tr  class="book_tr">
            <td  valign="top" class="book_text" >Ngày đăng ký:</td>
<td valign="top"  colspan="3">
             	<?=$signdate?>
			 </td>
          </tr>
          <tr  class="book_tr">
            <td colspan="4"  valign="top" class="book_text" ><div align="center">
              <p><a href="javascript:print()">Print</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:close()">Close</a></p>
            </div></td>
          </tr>
      </table></td>
    </tr>
</table>
</body>
</html>