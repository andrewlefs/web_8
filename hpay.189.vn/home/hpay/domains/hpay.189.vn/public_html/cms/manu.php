<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
                           $com = array();
	if(session_is_registered('countadd'))
            {
		$HTTP_SESSION_VARS['countadd']=0;
            }
	$select_query = "SELECT `id_company`, `name`, `name_eng`,`publish`,`company_code`,`logo`  FROM ".DB_PREFIX."company  ORDER BY id_company";
	$sql->query($select_query);
	$n = $sql->num_rows();
                           $i = 0;
                           while($row = $sql->fetch_array()){
                               $i = $i+1;
                               $com[$i]["id_company"] = $row["id_company"];
                               $com[$i]["name"] = $row["name"];
                               $com[$i]["name_eng"] = $row["name_eng"];
                               $com[$i]["publish"] = $row["publish"];
                               $com[$i]["company_code"] = $row["company_code"];
                               $com[$i]["logo"] = $row["logo"];
                           }
                           
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delManu(id) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=manu&mode=del&act=del&id=" + id);			
		}
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=manu">Thông tin nhà mạng</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Nhà mạng (<?=$n?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=manu&mode=add'" class="button">Thêm</a><a onclick="$('#form').submit();" class="button">Delete</a></div>
    </div>

    <div class="content">
        <? if($n>0){?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">Tên nhà mạng</td>
              <td class="left">Tên quốc tế</td>
              <td class="left">Mã nhà mạng</td>
              <td class="left">Logo</td>
              <td class="left">Trạng thái</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                for($j=1;$j<=count($com);$j++){
                    $from 	= $from + 1;			
                    $nsxid 	= $com[$j]['id_company'];
                    $tennsx                    =$com[$j]['name'];
                    $teneng                   =$com[$j]['name_eng'];
                    $change                  = $com[$j]['publish']==0?1:0;
                    $publish                  =$com[$j]['publish'];
                    $company_code    =$com[$j]['company_code'];
                    $logo                       = $com[$j]["logo"] <> "" ? "<img src='".$dir_imglogos.$com[$j]["logo"]."'  style='border: 1px solid #000000; padding: 0px; width:80px; '>" : 'Nhà mạng  này chưa có ảnh';
             ?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><?= $tennsx ?> </td>
              <td class="left"><?= $teneng?> </td>
              <td class="left"><?= $company_code?> </td>
              <td class="left"><?= $logo?> </td>
              <td class="left"><?= ($publish == 1 ? 'C&#243;' : 'Kh&#244;ng') ?> <a style="CURSOR: hand" href="index.php?pages=manu&mode=del&amp;act=upd&s=<?=$change?>&id=<?=$nsxid?>">Change</a></td>
              <td class="right">[ <a href="index.php?pages=manu&mode=edit&id=<?= $nsxid ?>">Sửa</a> ]
                                [ <a class="openl" onClick="delManu(<?=$nsxid ?>)">Xóa</a> ]
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