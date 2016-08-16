<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($admin_paga*$position_page)- $admin_paga);
	$count_rows = $sql->count_rows("linkseo");
	$pages_number = ceil($count_rows/$admin_paga);
	
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	$select_query = "SELECT * FROM linkseo ORDER BY list_order LIMIT $from, $admin_paga";
	$sql->query($select_query);
	$n = $sql->num_rows();					
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delLinkseo(id) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=linkseo&mode=del&id=" + id);			
		}
	}
	function open_window(id){
			window.open("index.php?pages=linkseo&mode=detail&id=" +id ,"","width=550,height=400,left=0,top=0,scrollbars=yes");
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=linkseo">Quản lý từ khóa</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Từ khóa (<?=$count_rows?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=linkseo&mode=add'" class="button">Thêm</a><a onclick="$('#form').submit();" class="button">Delete</a></div>
    </div>

    <div class="content">
       <? if($count_rows>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">Từ khóa</td>
              <td class="left">Link web</td>
              <td class="left">Trạng thái</td>
              <td class="left">Lượt Click</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                    for($i=1; $i<$n+1; $i++)
                        {
			$from 		= $from + 1;		
			$row 		= $sql->fetch_array();
			$id 		= $row['id'];
			$keyword 	=$row['keyword'];
			$publish 	=$row['publish'];
			$views 		=$row['views'];
			$linkweb 	=$row['linkweb'];
		?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><?= $keyword ?></td>
              <td class="left"><?= $linkweb ?></td>
              <td class="left"><?=$publish==1?"Có":"Không"?></td>
              <td class="left"><?= $views ?></td>
              <td class="right">[ <a href="index.php?pages=linkseo&mode=edit&position_page=<?=$position_page?>&id=<?= $id ?>">Sửa</a> ]
                                [ <a class="openl" onClick="delLinkseo(<?=$id?>)">Xóa</a> ]
                </td>
            </tr>
            <?php 
		} $sql->close();
		?>

        </tbody>
        <?php pages_browser_admin("index.php?pages=linkseo&position_page=",$position_page,$pages_number);?>
        </table>
        <? }else echo "<br><div align=center>Chưa có từ khóa nào nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>