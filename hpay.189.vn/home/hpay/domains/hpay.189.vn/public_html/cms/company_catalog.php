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
        
                       
        
                           $select_query = "SELECT id, id_company, id_catalog FROM ".DB_PREFIX."company_catalog order by id ";		
	$sql->query($select_query);
	$n = $sql->num_rows();	
                          $i = 0;
                          while($r = $sql->fetch_array()){
                              $i = $i+1;
                              $arr_cat[$i]["id"] = $r["id"];
                              $arr_cat[$i]["id_company"] = $r["id_company"];
                              $arr_cat[$i]["id_catalog"] = $r["id_catalog"];
                          }	
                       
                          
?>

<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
    function delCate(id) {
            if (confirm("Bạn có muốn xóa thật không ? Nếu bạn xóa danh mục này thì tất cả sản phẩm thuộc danh mục cũng bị xóa theo." )) {
                    window.location.replace("index.php?pages=company_catalog&mode=del&act=del&id=" + id);			
            }
    }
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=company_catalog">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Danh mục nhà mạng cung cấp dịch vụ có  </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=company_catalog&mode=add'" class="button">Thêm</a><a class="button">Delete</a></div>
    </div>

    <div class="content">             
      <? if(!empty($arr_cat)){?>
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">Thứ tự</td>
              <td class="left">Tên nhà cung cấp</td>
              <td class="left">Tên dịch vụ</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php 
                for($i=1;$i<=count($arr_cat);$i++){                
                            $from                           = $from + 1;
                            $id                               =        $arr_cat[$i]["id"];
                            $id_company                           =    $arr_cat[$i]["id_company"] ;
                            $id_catalog                    =    $arr_cat[$i]["id_catalog"];          
                         
               ?>
                    <tr>
                              <td style="text-align: center;"><input type="checkbox" name="selected[]" value="20" />
                                </td>
                              <td class="left"><?= $from ?></td>
                                  <td class="left">
                                  <?=  get_com($id_company)?>
                              </td>
                              
                              <td class="left"><?=  get_cat($id_catalog)?></td>
                            
                              <td class="right">[ <a href="index.php?pages=company_catalog&mode=edit&id=<?=$id ?>">Sửa</a> ]
                                                [ <a class="openl" onClick="delCate(<?=$id ?>)">Xóa</a> ]
                                </td>
                </tr>                           
          <?php
                }$sql->close();	
              ?>
        </tbody>
        </table>
        <?php pages_browser_admin("index.php?pages=company_catalog&position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có danh mục sản phẩm  trong CSDL !</div>";?>
    
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>
