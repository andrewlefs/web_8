<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($HTTP_GET_VARS[mode] == "detail")
	{
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT tieude, anhtin, nguontin, trichdan, noidung FROM tintuc WHERE tinid = '$id'";
					

		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
		
		$tieude 	= $row["tieude"]; $nguontin 	= $row["nguontin"]; 
		$trichdan 	= $row["trichdan"]; $noidung 	= nl2br($row["noidung"]); 
		$anhtin		= $row["anhtin"] <> "" ? "<img src='".$dir_imgnews.$row["anhtin"]."'  style='border: 1px solid #000000; padding-left: 0; padding-right: 0; padding-top: 0px; padding-bottom: 0px'>" : 'Tin này chưa có ảnh'; 	
		$imgtemp 	= $row["anhtin"];
		$sql->close();
	}
	
?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../style/mstyle.css" rel=stylesheet type=text/css>
<title>-- Detail Information of New --</title>
</head>
<body><div align="center">
<br>
<table width="800" align="center" cellspacing="0">
  <tr>
      <td valign="top" bgcolor="#d4d0c8">
        <table bgcolor="whitesmoke"  width="800" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> <div align="center">TH&Ocirc;NG TIN CHI TIẾT CỦA MỘT BẢN TIN <br>
            </div></td>
          </tr>
          <tr class="book_tr">
            <td width="28%"   class="book_tr_left" >Ti&ecirc;u &#273;&#7873; bản tin: </td>
            <td width="72%"   colspan="3">
              <span class="header_table">
              <?=$tieude?>
            </span></td>
          </tr>
          <tr class="book_tr">
            <td   class="book_tr_left" >Nguồn tin:</td>
            <td  colspan="3">
              <span class="header_table">
              <?=$nguontin?>
            </span>            </td>
          </tr>
          <tr class="book_tr">
            <td  class="book_text" >Ảnh tin:</td>
            <td  colspan="3"><?=$anhtin?>
              <div align="justify"></div></td>
          </tr>          
          <tr  class="book_tr">
            <td  valign="top" class="book_text" >Nội dung chi tiết tin:</td>
            <td valign="top"  colspan="3">
              <p align="justify">
                <?=$trichdan?>
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
</table>
<br>
	<br>
</div></body>
</html>