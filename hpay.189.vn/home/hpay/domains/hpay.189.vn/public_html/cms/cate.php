<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                            $sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
                           $arr_cat = array();  
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
        
                          $position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($admin_page*$position_page)- $admin_page);
	$count_rows = $sql->count_rows(DB_PREFIX."catalog");
	$pages_number = ceil($count_rows/$admin_page);
        
   
   
                           $m_abc = lay_mang_menu_con__ppp(0);
                          
                                 $c="";
                                  if(!empty($m_abc)){
                                                for($z=1;$z<count($m_abc);$z++)
                                                {
                                                        $id_z = $m_abc[$z];
                                                        $c=$c." ( select  *  from ".DB_PREFIX."catalog  where id_catalog='$id_z' ) union ";
                                                }
                                 }
                                                       
                                 if($c!=""){
                                      $c  = substr($c,0,-6);   
                                     $tv=$c." limit  $from,  $admin_page ";
                                     $sql->query($tv);	
                                                    $i = 0;
                                                    while($tv_2 = $sql->fetch_array()){
                                                                        $i = $i+1;
                                                                        $arr_cat[$i]["id_catalog"] = $tv_2["id_catalog"];
                                                                        $arr_cat[$i]["name"] = $tv_2["name"];
                                                                        $arr_cat[$i]["catalog_parent"] = $tv_2["catalog_parent"];
                                                                        $arr_cat[$i]["publish"] = $tv_2["publish"];
                                                    }
                                }
                          
?>

<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
    function delCate(id) {
            if (confirm("Bạn có muốn xóa thật không ? Nếu bạn xóa danh mục này thì tất cả sản phẩm thuộc danh mục cũng bị xóa theo." )) {
                    window.location.replace("index.php?pages=cate&mode=del&act=del&id=" + id);			
            }
    }
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=cate">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Danh mục sản phẩm  </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=cate&mode=add'" class="button">Thêm</a><a class="button">Delete</a></div>
    </div>

    <div class="content">             
      <? if(!empty($arr_cat)){?>
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">Thứ tự</td>
              <td class="left">T&ecirc;n danh mục sản phẩm</td>
              <td class="left">Publish</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php 
                for($i=1;$i<=count($arr_cat);$i++){                
                            $from                           = $from + 1;
                            $id                               =        $arr_cat[$i]["id_catalog"];
                            $name                           =    $arr_cat[$i]["name"] ;
                            $id_cha                     =    $arr_cat[$i]["catalog_parent"];
                            $change                  =    $arr_cat[$i]["publish"]==0?1:0 ;                            
                            $publish              =    $arr_cat[$i]["publish"] ;
               ?>
                    <tr>
                              <td style="text-align: center;"><input type="checkbox" name="selected[]" value="20" />
                                </td>
                              <td class="left"><?= $from ?></td>
                              <td class="left">
                                       <?php 
                                                      if($id_cha!=0)
                                                      {
                                                              echo_khoang_trang($id_cha);
                                                      }
                                        ?>
                                  <?php echo $name; ?>
                              </td>
                              <td class="left"><?= ($publish == 1 ? 'C&#243;' : 'Kh&#244;ng') ?> <a style="CURSOR: hand" href="index.php?pages=cate&id=<?=$id?>&mode=del&amp;act=upd&s=<?=$change?>">Change</a></td>
                              <td class="right">[ <a href="index.php?pages=cate&mode=edit&id=<?=$id ?>">Sửa</a> ]
                                                [ <a class="openl" onClick="delCate(<?=$id ?>)">Xóa</a> ]
                                </td>
                </tr>                           
          <?php
                }$sql->close();	
              ?>
        </tbody>
        </table>
        <?php pages_browser_admin("index.php?pages=cate&position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có danh mục sản phẩm  trong CSDL !</div>";?>
    
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
