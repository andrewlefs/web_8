<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	
	if($_GET[mode] == "detail")
	{
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT `ten`, `gia`, `anh`, `id_com_cat`, `publish`, `create_date`, `code_pro` FROM ".DB_PREFIX."product WHERE `id_product` = '$id'";
						
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$ten 	= $row["ten"]; 	
		$gia	= $row["gia"];	
                                                     $catid = $row["id_com_cat"];			
		$code_pro = $row["code_pro"];
                                                     $publish = $row["publish"];
                                                     $create_date = $row["create_date"];		
		$anh 	= $row["anh"] <> "" ? "<img src='".$dir_imgproducts.$row["anh"]."' style='border: 0px solid #000000; padding-left: 0; padding-right: 0; padding-top: 0px; padding-bottom: 0px' onClick=OpenNewWindow('../comm/imagesviewer.php?img=".$dir_imgproducts."origin/".$row["anh"]."&mode=back',500,500)>" : "Chưa có ảnh SP"; 	

		$select_query = "SELECT name FROM ".DB_PREFIX."catalog  WHERE id_catalog = $catid";
		$sql->query($select_query);
		$row = $sql->fetch_array();
		$catname = $row["name"];
                
                
                                                    
                                                    $select = "select  id_company, id_catalog FROM ".DB_PREFIX."company_catalog where id= $catid " ;
                                                    $sql->query($select);
                                                    if($r = $sql->fetch_array()){
                                                        $id_company123 = $r[id_company];
                                                        $id_catalog123 = $r[id_catalog];
                                                    }
		$sql->close();
	}
	
?>
<?php include("lib/header.php")?>
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
  <form action="index.php?pages=book&mode=add" method="post" enctype="multipart/form-data" name="addbook" id="addbook">
    <tr>
      <td valign="top" bgcolor="#d4d0c8">
        <table bgcolor="whitesmoke"  width="634" cellpadding="2" cellspacing="1" >
          <tr class="header_table">
            <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> <div align="center">TH&Ocirc;NG TIN CHI TIẾT V&#7872; SẢN PHẨM</div></td>
          </tr>
            <tr class="book_tr">
            <td    class="book_tr_left" >Mã sản phẩm</td>
            <td    colspan="3">
              <span class="header_table">
              <?=$code_pro?>
            </span>            </td>
          </tr>
          
          <tr class="book_tr">
            <td width="28%"   class="book_tr_left" >Tên sản phẩm:</td>
            <td width="72%"  colspan="3">
              <span class="header_table">
              <?=$ten?>
            </span>            </td>
          </tr>
            <tr class="book_tr">
            <td    class="book_tr_left" >Thuộc nhà cung cấp - dịch vụ</td>
            <td    colspan="3">
              <span class="header_table">
              <?= get_com($id_company123) ?> - <?= get_cat($id_catalog123) ?>
            </span>            </td>
          </tr>
          
          <tr class="book_tr">
            <td   class="book_tr_left" >Giá sản phẩm</td>
            <td    colspan="3">
              <span class="header_table">
              <?=  number_format($gia)?>
            </span>            </td>
          </tr>        
        
            <tr class="book_tr">
            <td    class="book_tr_left" >Trạng thái</td>
            <td    colspan="3">
              <span class="header_table">
              <?=$publish==1?"Đã kích hoạt":"Chưa kích hoạt"?>
            </span>            </td>
          </tr>
          
      
        
          <tr class="book_tr">
            <td  class="book_text" >Ảnh sản phẩm:</td>
            <td  colspan="3"><?=$anh?></td>
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