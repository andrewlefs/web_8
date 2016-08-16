<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
        $module_name = 'Video Clip';
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($admin_page*$position_page)- $admin_page);
	$count_rows = $sql->count_rows("videos");
	$pages_number = ceil($count_rows/$admin_page);
	if(session_is_registered('countadd')){
		$HTTP_SESSION_VARS['countadd']=0;
	}
	$select_query = "SELECT vdid, author, vdname, Correlate, sort FROM videos ORDER BY sort, vdname DESC LIMIT $from, $admin_page";
	$sql->query($select_query);
	$n = $sql->num_rows();					
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delCate(id) {
		if (confirm("Bạn có muốn xóa thật không." )) {
			window.location.replace("index.php?pages=<?= $pages ?>&mode=del&id=" + id);			
		}
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /><?= $module_name ?> (<?=$n?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=<?= $pages ?>&mode=add'" class="button">Thêm</a></div>
    </div>

    <div class="content">
      <? if($count_rows>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="tt">TT</td>
              <td class="left">Tên Video</td>
              <td class="left">Cập nhật</td>
              <td class="left">Publish</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
             <?php
                for($i=1; $i<$n+1; $i++){
			$from = $from + 1;		
			$row = $sql->fetch_array();
			$Id = $row['vdid'];
			$User =$row['author'];
                        $Correlate =$row['Correlate'];
                        
			$vdname =$row['vdname']; 
		?>
            <tr>
              <td class="tt"><?= $from ?></td>
              <td class="left"><?=$vdname ?></td>
              <td class="left"><?=$User ?></td>
              <td class="left"><?=$Correlate ?></td>
              <td class="right">[ <a style="CURSOR: hand" href="index.php?pages=<?= $pages ?>&mode=edit&id=<?=$Id ?>">Sửa</a> ]
                                [ <a style="CURSOR: hand" onClick="delCate(<?=$Id ?>)">Xóa</a> ]
                </td>
            </tr>
            <?php 
            } 
            ?>

        </tbody>
        </table>
        <? }else echo "<br><div align=center>Chưa có '.$module_name.' nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>