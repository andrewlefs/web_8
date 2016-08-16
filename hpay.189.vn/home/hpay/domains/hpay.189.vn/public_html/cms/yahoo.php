<?php

	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
        
        
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
        
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($new_per_page*$position_page)- $new_per_page);
        
	$count_rows = $sql->count_rows(DB_PREFIX."yahoo");
	$pages_number = ceil($count_rows/$new_per_page);
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	$select_query = "SELECT id, yahooname, nickname FROM ".DB_PREFIX."yahoo ORDER BY thutu, yahooname DESC LIMIT $from, $new_per_page";
	$sql->query($select_query);
	$n = $sql->num_rows();					
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delYahoo(id) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=yahoo&mode=del&id=" + id);			
		}
	}
	function open_window(id){
			window.open("index.php?pages=yahoo&mode=detail&id=" +id ,"","width=700,height=400,left=0,top=0,scrollbars=yes");
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=yahoo">Quản lý yahoo</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Thành viên hỗ trợ (<?=$n?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=yahoo&mode=add'" class="button">Thêm</a><a onclick="$('#form').submit();" class="button">Delete</a></div>
    </div>

    <div class="content">
        <? if($count_rows>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">T&ecirc;n Yahoo</td>
              <td class="left">Nick Name</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                for($i=1; $i<$n+1; $i++){
			$from   = $from + 1;		
			$row    = $sql->fetch_array();
			$id     = $row['id'];
			$yahooname  =$row['yahooname'];
			$nickname   =$row['nickname'];
		?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><?=$yahooname?> </td>
              <td class="left"><?=$nickname?> </td>
              <td class="right">[ <a href="index.php?pages=yahoo&mode=edit&id=<?= $id ?>">Sửa</a> ]
                                [ <a class="openl" style="CURSOR: hand" onClick="delYahoo(<?=$id?>)">Xóa</a> ]
                </td>
            </tr>
            <?php 
            } $sql->close();
            ?>

        </tbody>
        </table>
        <?php pages_browser_admin("index.php?pages=yahoo&position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có nhà sản xuất nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>