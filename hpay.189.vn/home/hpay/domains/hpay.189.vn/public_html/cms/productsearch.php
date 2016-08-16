<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$cat = array();
	$nsx = array();
	$cur = array();
	
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	
	//lay  mang danh muc sp
	$select_query = "SELECT catid, catname FROM cat ORDER BY thutu, catname";
	$sql->query($select_query);
	$i = 0;
	while($row = $sql->fetch_array()){
		$i = $i + 1;
		$cat[$i]["catid"] 	= $row["catid"];		
		$cat[$i]["catname"] = $row["catname"];
	}
	//lay mang hang sx
	$select_query = "SELECT nsxid, tennsx FROM nsx ORDER BY tennsx";
	$sql->query($select_query);
	$i = 0;
	while($row = $sql->fetch_array()){
		$i = $i + 1;
		$nsx[$i]["nsxid"] 	= $row["nsxid"];
		$nsx[$i]["tennsx"] 	= $row["tennsx"];	
	}
	//lay mang don vi tien te
	$select_query = "SELECT currencyid, name FROM currency ";
	$sql->query($select_query);
	$i = 0;
	while($row = $sql->fetch_array()){
		$cur[$row["currencyid"]] 	= $row["name"];	
	}
		
	$w	= isset($_GET["w"]) ? stripslashes($_GET["w"]) : "";	
	if($_POST["mode"]=="search" || $_GET["mode"]="search")
	{
		$ten 		= convert_font($_POST["ten"],2);
		$catid 		= trim($_POST["catid"]);
		$gia 		= trim($_POST["gia"]);
		$nsxid 		= is_numeric($_POST["nsxid"]) ? $_POST["nsxid"] : 0 ;
		$namsx 		= is_numeric($_POST["namsx"]) ? $_POST["namsx"] : 0 ;			
		if(!isset($_GET["w"]))
		{
			if($ten != "")
				$w.=" AND ten like '%".$ten."%' ";
			if($catid != "")
				$w.=" AND catid like '%".$catid."%' ";
			if($gia != "")
				$w.=" AND gia like '%".$gia."%' ";
			if($nsxid != "")
				$w.=" AND nsxid like '%".$nsxid."%' ";
			if($namsx != "")
				$w.=" AND namsx like '%".$namsx."%'";
		}
		
		if($w!="")	
		{			
			$select_query = "SELECT sanphamid, ten, gia FROM sanpham WHERE 1 ".$w."  ORDER BY ten";			

			$sql->query($select_query);
			$n = $sql->num_rows();
			$rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
			$position_page = isset($HTTP_GET_VARS["position_page"]) && is_numeric($HTTP_GET_VARS["position_page"])  ? $HTTP_GET_VARS["position_page"]:1; 
			$from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
			$count_rows = $n;	
			$pages_number = ceil($count_rows/$rows_per_page_of_product);
	
			$search_query = "SELECT sanphamid, catid, ten, gia, currencyid  FROM sanpham WHERE 1 ".$w."  ORDER BY ten LIMIT $from, $rows_per_page_of_product";		
			$sql->query($search_query);
			$n = $sql->num_rows();
			if($count_rows==0)
					$message = $message."<li>Không tìm thấy kết quả nào. Mời bạn tìm kiếm lại";
		}	
		else{
			if($w=="")			
				$message = $message."<li>Hãy nhập điều kiện tìm kiếm.";						
			
		}
		
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
<title>-- Product Search --</title>
<script language="JavaScript" type="text/javascript">
<!--
	function delProduct(id,cat) {
		if (confirm("Are you sure ?" )) {
			window.location.replace("index.php?pages=product&mode=del$cat"+cat+"&id=" + id);			
		}
	}
	function open_window(id){
			window.open("index.php?pages=product&mode=detail&id=" +id ,"","width=700,height=500,left=0,top=0,scrollbars=yes");
	}
-->
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body><div align="center">
	<table width="780" border="0" align="center" cellpadding="2" cellspacing="0">
	<tbody>
	  <tr>
	    <td width="143" align="center" bgcolor='whitesmoke' class="logout">[ <a href="index.php?pages=logout">Logout</a> ]</td>
	    <td align="center" bgcolor='whitesmoke' class="menu_bar_manager">&nbsp;  </td>
      </tr>
	  </tbody>
</table> 
      <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor='whitesmoke' width="147" height="100%" valign="top"><?php include("menu.php"); ?><br></td>
     <td width="633" valign="top">
  </form>
	<center>
	<div align="center"><strong><br>
	  TÌM KIẾM  SẢN PHẨM CẦN XEM SỬA</strong><br>
	  <table width="600">
        <tr>
          <td class="header_table"><?=$message?> </td>
        </tr>
      </table>
	  <table width="600" cellspacing="0">
        <form action="index.php?pages=product&mode=search" method="post" enctype="multipart/form-data" name="search" id="search">
          <tr>
            <td valign="top" bgcolor="#d4d0c8">
              <table bgcolor="whitesmoke"  width="600" cellpadding="0" cellspacing="1" >
                <tr class="header_table">
                  <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> C&aacute;c ti&ecirc;u ch&iacute; th&ocirc;ng tin tìm kiếm<br></td>
                </tr>                
                <tr class="book_tr">
                  <td   class="book_tr_left" >Tên sản phẩm: * </td>
                  <td  colspan="3">
                    <input name="ten" class="input_b3" id="ten" size="18">
                  </td>
                </tr>
                <tr class="book_tr">
                  <td  class="book_tr_left"  >Thuộc danh mục SP:* </td>
                  <td  colspan="3">
                    <select name="catid" class="input_b1" id="select7">
                      <?
					echo "<option value=''>Chọn danh mục SP ...</option>";					 
					for($i=1; $i<=count($cat); $i++)						
							echo "<option value=".$cat[$i]["catid"].">".$cat[$i]["catname"]."</option>";						
					
				 	?>
                      </select></td>
                </tr>
                <tr class="book_tr">
                  <td   class="book_tr_left" >Gi&aacute; sản phẩm: * </td>
                  <td    colspan="3">
                    <input name="gia" class="input_b1" id="gia" size="18">
                  </td>
                </tr>
                <tr class="book_tr">
                  <td class="book_tr_left" >Nhà sản xuất:*</td>
                  <td colspan="3"><select name="nsxid" class="input_b1" id="select8">
                    <?
					echo "<option value=''>Chọn NSX ...</option>";					 
					for($i=1; $i<=count($nsx); $i++)						
							echo "<option value=".$nsx[$i]["nsxid"].">".$nsx[$i]["tennsx"]."</option>";											
				 	?>
                                    </select>
				  </td>
                </tr>
                <tr class="book_tr">
                  <td    class="book_tr_left" >Năm sản xuất:*</td>
                  <td    colspan="3">
                    <input name="namsx" class="input_b4" id="namsx" size="18">
              (d&#7919; liệu nhập kiểu s&#7889;) </td>
                </tr>                
                <tr class="book_tr" >
                  <td valign="top" ></td>
                  <td valign="top"  colspan="3"><input type="submit" name="Submit" value="Search">
                      <input type="reset" name="Submit2" value="Reset">
                      <input name="pages" type="hidden" id="pages" value="product">
                      <input name="mode" type="hidden" id="mode" value="search">
                  </td>
                </tr>
            </table></td>
          </tr>
        </form>
	    </table>	
	      
	      <? 
	  if($message==""){
	  echo "<hr width='95%' size='1'>";
	  echo "<table width='600'><tr><td align='left'>";
	  echo "Tìm được <span class='style1'>".$count_rows."</span> sản phẩm";
	  echo "</td></tr></table>";
	  ?>	
		<table borderColor="whitesmoke" cellSpacing="0" cellPadding="2" width="602" align="center" border="1">
        <tr bgColor="whitesmoke">
          <td width="39" align="middle" class="header_table" ><div align="center">Order </div></td>
          <td width="306" align="middle" class="header_table" >Product  Name </td>
          <td width="143" class="header_table" > Price </td>
          <td >&nbsp; </td>
        </tr>
        <?php
        for($i=1; $i<$n+1; $i++)
		{
			$from 		= $from + 1;
			$rows 		= $sql->fetch_array();
			$sanphamid 	= $rows['sanphamid'];
			$currencyid = $rows['currencyid'];
			$catid 		= $rows['catid'];
			$ten 		= $rows['ten'];
			$gia 		= $rows['gia'];
		?>
        <tr>
          <td class="header_table" ><div align="center">
              <?= $from ?>
          </div></td>
          <td class="manager_link"> <a title="Information detail" style="CURSOR: hand" onClick="open_window('<?=$sanphamid ?>')">
            <?= $ten ?>
          </a></td>
          <td class="header_table" ><font color="#FF0000"><?=number_format($gia,0)."&nbsp;".$cur[$currencyid]?></font></td>
          <td width="88" >
            <table cellSpacing="0" cellPadding="2" width="72" border="0">
              <tr>
                <td > <a style="CURSOR: hand" href="index.php?pages=product&mode=edit&cat=<?=$catid?>&position_page=<?=$position_page?>&id=<?= $sanphamid?>"> <img border="0" alt="Edit" src="../images/edit_button.gif" width="36" height="13"></a></td>
                <td > <a style="CURSOR: hand" onClick="delProduct('<?=$sanphamid ?>','<?=$catid?>')"> <img height="13" alt="Delete" src="../images/del_button.gif" width="36" border="0"></a></td>
              </tr>
          </table></td>
        </tr>
        <?php 
		} $sql->close();
		?>
      </table><br>  
	  <table width="608">
        <tr>
          <td width="600" bgColor="whitesmoke" class="header_table"><?php pages_browser("index.php?pages=product&mode=search&w=".htmlentities(urlencode($w))."&position_page=",$position_page,$pages_number);?></td>
        </tr>
      </table>
	  <? } ?>
	  <p><br>
        </p>
	</div></td>
        </tr>
</table> 
</div></body>
</html>