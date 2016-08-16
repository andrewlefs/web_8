<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	//Hien thi thong tin tinh/thanh
	$select_query = "SELECT currencyid, name, rate FROM currency ORDER BY name";
	$sql->query($select_query);
	$n = $sql->num_rows();	
				
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
<!--
	function delCurr(id) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=curr&mode=del&id=" + id);			
		}
	}
-->
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=curr">Quản lý đơn vị tiền tệ</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Đơn vị tiền tệ (<?=$n?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=curr&mode=add'" class="button">Thêm</a><a onclick="$('#form').submit();" class="button">Delete</a></div>
    </div>

    <div class="content">
        <? if($n>0){?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">Tên đơn vị tiền tệ</td>
              <td class="left">Tỷ giá</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                while ($row = $sql->fetch_array()){
			$from 		= $from + 1;			
			$currencyid     = $row['currencyid'];
			$name 		=$row['name'];
			$rate 		=$row['rate'];
		?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><?= $name ?> </td>
              <td class="left"><?= $rate ?> </td>
              <td class="right">[ <a href="index.php?pages=curr&mode=edit&id=<?= $currencyid ?>">Sửa</a> ]
                                [ <a class="openl" onClick="delCurr(<?=$currencyid ?>)">Xóa</a> ]
                </td>
            </tr>
            <?php 
            } $sql->close();
            ?>

        </tbody>
        </table>
        <? }else echo "<br><div align=center>Chưa có nhà sản xuất nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>