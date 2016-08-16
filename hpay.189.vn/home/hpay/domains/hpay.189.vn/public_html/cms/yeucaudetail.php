<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($_GET[mode] == "detail")
	{
		$id = $_GET["id"];
                                                   //  $ip = getIp();
		$select_query = "SELECT mb.`memberid` as memberid, mb.`user` as user, mb.`fullname` as fullname, mb.`email` as email,mb.`Gold` as gold,
                                                        lrq.`method` as request_method, lrq.`createdate` as request_createdate,  lrq.`publish` as request_publish
                                                        FROM ".DB_PREFIX."member as mb 
                                                        INNER JOIN ".DB_PREFIX."list_request lrq ON lrq.user_id = mb.memberid
                                                        where mb.Published = 1 and lrq.id=$id  limit 1";
						
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
                                                     $member_id 	= $row["memberid"];
		$ten 	= $row["fullname"]; 	
		$user 	= $row["user"];	
		$email		= $row["email"];	
                                                     $gold 	= $row["gold"]; 		
		$request_method 		= $row["request_method"]; 
                                                     $request_createdate 		= $row["request_createdate"]; 
                                                     $request_publish 		= $row["request_publish"];
		$sql->close();
                                                     if($request_method=="addbank")
                                                                $name_pt = "Nạp tiền qua internet banking";
                                                    else if($request_method=="addcard")
                                                                $name_pt = "Nạp tiền qua thẻ cào";
                                                    else if($request_method=="sendmoney")
                                                                $name_pt = "Chuyển khoản";
                                                    else if($request_method=="ruttien")
                                                                $name_pt = "Rút tiền tại đại lý";
                                                    else if($request_method=="naptien")
                                                                $name_pt = "Nạp tiền tại đại lý";
                                                    else if($request_method=="buycard")
                                                                $name_pt = "Mua thẻ trên hệ thống";
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
<script language="javascript">
	function OpenNewWindow(url,w,h) {
		window.open(url,'new_page','toolbar=no,location=no,menubar=no,scrollbars=yes,width=' + w + ',height=' + h + ',top=60,left=100,resizeable=no,status=no');
	}
</script>
<title>-- Detail Information of Product --</title>
</head>
<body><div align="center">
<br>
<table width="600" align="center" cellspacing="0">
  <form action="index.php?pages=yeucau&mode=del&act=upd&id=<?=$id?>&method=<?=$request_method?>&memberid=<?=$member_id?>" method="post" enctype="multipart/form-data" name="addbook" id="addbook">
    <tr>
      <td valign="top" bgcolor="#d4d0c8">
        <table bgcolor="whitesmoke"  width="634" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> <div align="center">TH&Ocirc;NG TIN CHI TIẾT YÊU CẦU CỦA KHÁCH HÀNG</div></td>
          </tr>
          <tr class="book_tr">
            <td width="28%"   class="book_tr_left" >Tên khách hàng:</td>
            <td width="72%"  colspan="3">
              <span class="header_table">
              <?=$ten?>
            </span>            </td>
          </tr>
          <tr class="book_tr">
            <td  class="book_tr_left"  >Số điện thoại đăng nhập</td>
            <td  colspan="3">
              <span class="header_table">
              <?=$user?>
              </span></td>
          </tr>
          <tr class="book_tr">
            <td   class="book_tr_left" >Email</td>
            <td    colspan="3">
              <span class="header_table">
              <?=$email?>
            </span>            </td>
          </tr>
          <tr class="book_tr">
            <td    class="book_tr_left" >Số tiền hiện tại trong ví:</td>
            <td    colspan="3">
              <span class="header_table">
              <?=  number_format($gold,2)?> VNĐ
            </span>            </td>
          </tr>
          <tr  class="book_tr">
            <td     class="book_tr_left" >Phương thức lựa chọn:</td>
            <td    colspan="3">
              <span class="header_table">
              <?=$name_pt?>
              </span></td>
          </tr>
          <tr class="book_tr">
            <td     class="book_tr_left" >Ngày yêu cầu:</td>
            <td     colspan="3">
              <span class="header_table">
              <?=  change_date123($request_createdate)?>
            </span>            </td>
          </tr>
          <tr class="book_tr">
            <td  class="book_text" >Tình trạng:</td>
            <td  colspan="3"><span class="header_table">
              <?=$request_publish==1?"Đã xử lý": "Chưa xử lý"?>
            </span></td>
          </tr>
       
          <tr  class="book_tr">
             
            <td colspan="4"  valign="top" class="book_text" ><div align="center">
                     <?php if($request_publish==0){?>
              <p>Nếu bạn muốn xử lý yêu cầu của thành viên này , xin vui lòng nhấn nút xử lý bên dưới</p>
              <p>
                            
                            <input type="submit" value="Xử lý">
                   
              </p>
                    <?} else {?>
                            <p>Yêu cầu này đã được xử lý</p>
                    <?}?>
            </td>
          </tr>
      </table></td>
    </tr>
  </form>
</table>
<br>
	<br>
</div></body>
</html>