<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
        $module_name = 'Thư viện download';
	if(session_is_registered('countadd')){
		$HTTP_SESSION_VARS['countadd']=0;
	}
	$select_query = "SELECT id, title, UserId FROM downloadcat ORDER BY list_order, title";
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	$sql->query($select_query);
	$n = $sql->num_rows();	
	$sql->close();					
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delCate(id) {
		if (confirm("Bạn có muốn xóa thật không ? Nếu bạn xóa danh mục này thì tất cả tin tức thuộc danh mục cũng bị xóa theo." )) {
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
       <? if($n>0){?>
        <table class="list">
          <thead>
            <tr>
              <td class="tt">TT</td>
              <td class="left">Tên danh mục nhóm Download</td>
              <td class="left">Cập nhật</td>
              <td class="left">Publish</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
             <?php
                for($i=1; $i<=count($downloadcat); $i++){
			$tt 	= $tt + 1;
			$id 	= $downloadcat[$i]['id'];
			$title 	= $downloadcat[$i]['title'];
                        $User 	= $downloadcat[$i]['UserId'];
			$publish = $downloadcat[$i]["publish"];
		?>
            <tr>
              <td class="tt"><?= $tt ?></td>
              <td class="left"><?=$title ?></td>
              <td class="left"><?=$User ?></td>
              <td class="left"><?=$publish==1?"Có":"Không"?></td>
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