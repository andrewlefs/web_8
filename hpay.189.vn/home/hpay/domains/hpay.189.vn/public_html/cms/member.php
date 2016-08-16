<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($admin_page*$position_page)- $admin_page);
	$count_rows = $sql->count_rows("member");
	$pages_number = ceil($count_rows/$admin_page);
	
	if(session_is_registered('countadd')){
		$_SESSION['countadd']=0;
	}
	$select_query = "SELECT memberid, fullname, signdate FROM member ORDER BY signdate DESC LIMIT $from, $admin_page";
	$sql->query($select_query);
	$n = $sql->num_rows();					
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delmember(id) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=member&mode=del&id=" + id);			
		}
	}
		function open_window(id){
			window.open("index.php?pages=member&mode=detail&id=" +id ,"","width=700,height=400,left=0,top=0,scrollbars=yes");
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=member">Quản lý thành viên</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Thành viên có (<?=$n?>) </h1>
      <div class="buttons"></div>
    </div>

    <div class="content">
         <? if($count_rows>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">T&ecirc;n Thành viên</td>
              <td class="left">Ngày đăng ký</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                for($i=1; $i<$n+1; $i++){
			$from = $from + 1;		
			$row = $sql->fetch_array();
			$memberid = $row['memberid'];
			$fullname =$row['fullname'];
			$signdate = gmdate("d/m/Y",$row["signdate"] + 7*3600);			
		?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><a title="Information detail" onClick="open_window(<?=$memberid ?>)"><strong><?= $fullname ?></strong></a></td>
              <td class="left"><?= $signdate ?></td>
              <td class="right">[ <a href="index.php?pages=member&amp;mode=edit&position_page=<?=$position_page?>&amp;id=<?= $memberid ?>">Sửa</a> ]
                                [ <a class="openl" style="CURSOR: hand" onClick="delmember(<?=$memberid ?>)">Xóa</a> ]
                </td>
            </tr>
            <?php 
            } $sql->close();
            ?>

        </tbody>
        
        </table>
        <?php pages_browser_admin("index.php?pages=member&amp;position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có nhà sản xuất nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>