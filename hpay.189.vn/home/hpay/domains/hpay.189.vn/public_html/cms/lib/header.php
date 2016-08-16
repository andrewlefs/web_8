<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title>Administrator | <?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-us" />
<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="js/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>
<script language='Javascript' src='js/functions.js'></script>
<!-- TinyMCE -->
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce_menu.js"></script>
<script type="text/javascript" src="jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<!-- /TinyMCE -->
</head>
<body>
<?php include("lib/0902121177.php")?>
<div id="container">
<div id="header">
  <div class="div1">
    <div class="div2">HỆ THỐNG QUẢN TRỊ WEBSITE WWW.HOANGGIA.NET.VN</div>
        <div class="div3"><img src="images/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;Xin chào: <span><?php echo "".$HTTP_SESSION_VARS['FullName'].""; ?></span></div>
      </div>
    <div id="menu">
    <ul class="left" style="display: none;">
      <li id="dashboard"><a href="index.php?pages=welcome" class="top">Bảng điều khiển</a></li>
      <li id="extension"><a class="top">Danh mục</a>
        <ul>
          <li><a href="index.php?pages=manu">Danh mục nhà cung cấp</a></li>
          <li><a href="index.php?pages=company_catalog">Nhà cung cấp - dịch vụ</a></li>
          <li><a href="index.php?pages=network">Danh mục ngân hàng</a></li>
          <li><a href="index.php?pages=slider">Quản lý Slider</a></li>
          <li><a href="index.php?pages=yahoo">Quản lý Yahoo</a></li>
        </ul>
      </li>
      
      
      <li id="catalog"><a class="top">Sản phẩm</a>
        <ul>
          <li><a href="index.php?pages=cate">Danh mục sản phẩm</a></li>     
         <li><a href="index.php?pages=product">Chi tiết sản phẩm</a></li>    
        </ul>
      </li>
    <!--    <li id="extension"><a class="top">Nhập xuất</a>
        <ul>
          <li><a href="index.php?pages=newscat">Nhập hàng</a></li>
          <li><a href="index.php?pages=new">Xuất hàng</a></li>        
        </ul>
      </li>
       <li id="extension"><a class="top">Báo cáo</a>
        <ul>
          <li><a href="index.php?pages=newscat">Hàng nhập</a></li>
          <li><a href="index.php?pages=new">Hàng xuất</a></li>
          <li><a href="index.php?pages=new">Hàng tồn</a></li>
        </ul>
      </li> -->
       <li id="extension"><a class="top">Xử lý yêu cầu</a>
        <ul>
          <li><a href="index.php?pages=yeucau">Danh sách yêu cầu</a></li>          
        </ul>
      </li>
      <li id="extension"><a class="top">Tin tức</a>
        <ul>
          <li><a href="index.php?pages=newscat">Danh mục tin tức</a></li>
          <li><a href="index.php?pages=new">Bài viết</a></li>
        </ul>
      </li>
     <!--<li id="extension"><a class="top">Download</a>
        <ul>
          <li><a href="index.php?pages=downloadcat">Danh mục Download</a></li>
          <li><a href="index.php?pages=download">Download</a></li>
        </ul>
      </li>-->
      <li id="system"><a class="top">Hệ thống</a>
        <ul>
          <li><a class="parent">Quản thành viên</a>
           <ul>
              <li><a href="index.php?pages=user">Quản trị</a></li>
              <li><a href="index.php?pages=member">Thành viên</a></li>
            </ul>
          </li>
          <li><a href="index.php?pages=settings&amp;mode=edit&amp;id=1">Cài đặt hệ thống</a></li>
          <li><a href="index.php?pages=intro">Thông tin</a></li>
          <li><a href="index.php?pages=contact">Quản lý liên hệ</a></li> 
        </ul>
      </li>
      <li id="help"><a class="top">Help</a>
        <ul>
          <li><a onClick="window.open('http://www.hoanggia.net');">Homepage</a></li>
          <li><a onClick="window.open('http://www.hoanggia.net/gioi-thieu.htm');">Giới thiệu</a></li>
          <li><a onClick="window.open('http://diendan.hoanggia.net/forum.php');">Support Forum</a></li>
        </ul>
      </li>
    </ul>
    <ul class="right">
      <li id="store"><a onClick="window.open('/');" class="top">Trang chủ</a>
        <ul>
      </ul>
      </li>
      <li id="store"><a class="top" href="index.php?pages=logout">Thoát</a></li>
    </ul>
    <script type="text/javascript">
        
   function test() {
       
       var ajax = new XMLHttpRequest;
        var cboxes = document.getElementsByName('selected123[]');
                          var tem = [];
                           var len = cboxes.length;
                           var j = 0;
                           for (var i=0; i<len; i++) {        
                               if(cboxes[i].checked){    
                                        j = j + 1; 
                                       tem[j] = cboxes[i].value;     
                                }
                           }
		
	ajax.open("GET","del_img.php?id="+tem,true);
	ajax.send(null);
	
	ajax.onreadystatechange = function()
	{
		if(ajax.readyState==4)
		{
			alert(ajax.responseText);
                                                                                $("#duockhong").load(location.href + " #duockhong");
                                                                           
		}
	}
  
    
}
    $(document).ready(function() {
	$('#menu > ul').superfish({
		hoverClass	 : 'sfHover',
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false, 
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});
	
	$('#menu > ul').css('display', 'block');
});

</script> 
  </div>
</div>