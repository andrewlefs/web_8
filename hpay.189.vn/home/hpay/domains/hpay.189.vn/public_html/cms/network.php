<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	$bank = array();
	
                            $select_query = "SELECT * FROM ".DB_PREFIX."bankinfo ORDER BY Id";
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	$sql->query($select_query);
                           $k =0;
                           while ($r = $sql->fetch_array()){
                               $k = $k + 1;
                               $bank[$k]["id"] = $r["Id"];
                               $bank[$k]["logo"] = $r["Logo"];
                               $bank[$k]["publish"] = $r["Published"];
                               $bank[$k]["url"] = $r["url"];
                           }
	$n = $sql->num_rows();
        $sql->close();
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delLogo(id) {
		if (confirm("Bạn có muốn xóa thật không ? Nếu bạn xóa danh mục này thì tất cả sản phẩm thuộc danh mục cũng bị xóa theo." )){
			window.location.replace("index.php?pages=network&mode=del&id=" + id);			
		}
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=network">Quản lý danh mục ngân hàng</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Danh mục ngân hàng (<?=$n?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=network&mode=add'" class="button">Thêm</a><a class="button">Delete</a></div>
    </div>

    <div class="content">
        <? if($n>0){?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">Logo</td>
              <td class="left">Links</td>             
              <td class="left">Publish</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                for($i=1; $i<=  count($bank); $i++){
			$tt = $tt + 1;			
			$id         = $bank[$i]['id'];
			$logo       = $bank[$i]["logo"] <> "" ? "<img src='".$dir_imglogos.$bank[$i]["logo"]."'  style='border: 1px solid #000000; padding: 0px; width:90px; '>" : 'Ngân hàng  này chưa có ảnh';
			$publish    = $bank[$i]['publish'];
			$link       =$bank[$i]['url'];
		?>
            <tr>
              <td class="left"><?= $tt ?></td>
              <td class="left"><?= $logo ?> </td>
              <td class="left"><?= $link ?></td>             
              <td class="left"><?= ($publish == "1" ? "Yes":"No") ?></td>
              <td class="right"> <a href="index.php?pages=network&mode=edit&id=<?= $id ?>"> <img border="0" alt="Edit" src="images/edit_button.gif" width="36" height="13"></a>
                                 <a class="openl" onClick="delLogo(<?=$id ?>)"> <img height="13" alt="Delete" src="images/del_button.gif" width="36" border="0"></a>
                </td>
            </tr>
            	<?php 
		} 
		?>

        </tbody>
        </table>
        <? }else echo "<br><div align=center>Chưa có ngân hàng  nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
