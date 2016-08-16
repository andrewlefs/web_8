<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
                           $intro = array();
	$module_name = 'Trang ngoài';
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($download_per_pagead*$position_page)- $download_per_pagead);
	$count_rows = $sql->count_rows(DB_PREFIX."intro");
	$pages_number = ceil($count_rows/$download_per_pagead);
	
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	//Hien thi thong tin tinh/thanh
	$select_query = "SELECT * FROM ".DB_PREFIX."intro ORDER BY list_order LIMIT $from, $download_per_pagead ";
	$sql->query($select_query);
	$n = $sql->num_rows();	
                           $i =  0;
                           while ($r = $sql->fetch_array()){
                               $i = $i+1;
                               $intro[$i]["id_intro"] = $r["id_intro"];
                               $intro[$i]["title_menu"] = $r["title_menu"];
                               $intro[$i]["title"] = $r["title"];
                               $intro[$i]["publish"] = $r["publish"];
                           }
                    
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delCate(id) {
		if (confirm("Bạn chắc chắn xoá" )) {
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
              <td class="tt">#</td>
              <td class="left">Tiêu đề trên Menu</td>
              <td class="left">Tiêu đề</td>                        
              <td class="left">Publish</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
             <?php
                 
                for($i=1; $i<=count($intro); $i++)
                                {
                                        $from   = $from + 1;		                                       
                                        $Id     = $intro[$i]['id_intro'];
                                        $menu_1 =$intro[$i]['title_menu'];                                                                               
                                        $tieude =$intro[$i]['title'];                                                                                
                                        $frontpage = $intro[$i]['publish'];
                                ?>
            <tr>
              <td class="tt"><?= $Id ?></td>
              <td class="left"><?=$menu_1 ?></td>
              <td class="left"><?=$tieude ?></td>            
           
              <td class="left"><?=$frontpage==1?"Có":"Không"?></td>
              <td class="right">[ <a style="CURSOR: hand" href="index.php?pages=<?= $pages ?>&mode=edit&id=<?=$Id ?>">Sửa</a> ]
                            <!--    [ <a style="CURSOR: hand" onClick="delCate(<?=$Id ?>)">Xóa</a> ]-->
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