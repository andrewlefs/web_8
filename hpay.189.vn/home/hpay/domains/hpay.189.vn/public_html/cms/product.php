<?php

	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                             session_start();
                            
                            function tinh_chuoi_or()
                            {
                                    $chuoi_or="";
                                    if($_GET['tu_khoa']=="Từ khóa tìm kiếm")
                                    {
                                            $tu_khoa_ccc="";
                                    }
                                    else 
                                    {
                                            $tu_khoa_ccc=$_GET['tu_khoa'];
                                    }
                                    $mang_tk__abc=explode(" ",$tu_khoa_ccc);
                                    for($f=0;$f<count($mang_tk__abc);$f++)
                                    {
                                            $q=$mang_tk__abc[$f];
                                            if($q!="")
                                            {
                                                    $chuoi_or=$chuoi_or."ten like '%$q%' or ";
                                            }
                                    }
                                    if($chuoi_or!="")
                                    {
                                            $chuoi_or=substr($chuoi_or,0,-3);
                                            $chuoi_or=" and ( ".$chuoi_or." ) ";
                                    }
                                    return $chuoi_or;
                            }
                            
//                            function  xac_dinh_menu_con__product($id_cha)
//	{
//                                                    $sql = new db_sql();
//                                                    $sql->db_connect();
//                                                    $sql->db_select();		
//		$tv_2       =  $sql->fetch_rows(DB_PREFIX."catalog", "catalog_parent", $id_cha);                                                 
//		if($tv_2[0]==0)
//		{
//			return "khong";
//		}
//		else 
//		{
//			return "co";
//		}
//	}
//        
//                           function de_quy_menu($id_cha,$kt="")
//                            {
//                                    $sql = new db_sql();
//                                    $sql->db_connect();
//                                    $sql->db_select();
//                                    $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//                                    $tv="select * from ".DB_PREFIX."catalog  where  catalog_parent='$id_cha'";                                                        
//                                    $sql->query($tv);
//
//                                    while($tv_2=$sql->fetch_array())
//                                    {
//                                            if($_GET["cat_id"]==$tv_2['id_catalog'])
//                                            {
//                                                    $select="selected";
//                                            }
//                                            else 
//                                            {
//                                                    $select="";
//                                            }
//                                            echo "<option value='$tv_2[id_catalog]' $select >";
//                                                    echo $kt;	
//                                                    echo $tv_2['name'];												
//                                            echo "</option>";
//                                            $xac_dinh_menu_con__123=  xac_dinh_menu_con__product($tv_2['id_catalog']);
//                                            if($xac_dinh_menu_con__123=="co")
//                                            {
//                                                    de_quy_menu($tv_2['id_catalog'],$kt);
//                                            }
//                                    }
//                            }
//        
//                            function lay_chuoi_menu_con__product($id_cha,$c="")
//	{
//                                                        $sql = new db_sql();
//                                                        $sql->db_connect();
//                                                        $sql->db_select();
//                                                        $tv="select id_catalog from ".DB_PREFIX."catalog  where catalog_parent='$id_cha'";
//                                                        $sql->query($tv);         
//                                                        $tem = array();
//                                                        $i = 0;
//                                                        while($tv_2=$sql->fetch_array())
//                                                        {         
//                                                                        $i = $i + 1;
//                                                                        $tem[$i]["id_catalog"] = $tv_2['id_catalog'];
//                                                         }
//
//                                                         for($i=1;$i<=count($tem);$i++){   
//                                                                        $c= $c."_".$tem[$i]['id_catalog']; 
//                                                                        $a_tv_2 = $sql->fetch_rows(DB_PREFIX."catalog","catalog_parent", $tem[$i][id_catalog]);                        
//                                                                        if($a_tv_2[0]!=0)
//                                                                        {
//                                                                                $c=  lay_chuoi_menu_con__product($tem[$i]['id_catalog'],$c);
//                                                                        }                      
//                                                        }
//                                                        return $c;
//	}
//	function lay_chuoi_menu_con__ppp_123($id_cha)
//	{
//		$c=  lay_chuoi_menu_con__product($id_cha);
//		if($c=="")
//		{
//			return $id_cha;
//		}
//		else 
//		{
//			return $id_cha.$c;
//		}
//	}
//	
//	function lay_mang_menu_con__ppp_123($id_cha)
//	{
//		$c=lay_chuoi_menu_con__ppp_123($id_cha);
//		$m=explode("_",$c);
//		return $m;
//	}
//	function tinh_chuoi_union__ppp_123($catid)
//	{
//                                                     $sql = new db_sql();
//                                                     $sql->db_connect();
//                                                     $sql->db_select();
//                                                     $chuoi_or           =        tinh_chuoi_or();
//		$m                        =       lay_mang_menu_con__ppp_123($catid);
//		$tv="";
//		for($i=0;$i<count($m);$i++)
//		{
//			$id=$m[$i];
//                                                                                $select = "select count(*) from ".DB_PREFIX."product where id_catalog='$id' $chuoi_or"; 
//                                                                                $sql->query($select);
//                                                                                $r = $sql->num_rows();						
//			if($id!="")
//			{
//				$tv=$tv." ( select * from ".DB_PREFIX."product where id_catalog='$id' $chuoi_or order by create_date desc ) union";
//			}
//		}
//		$tv=substr($tv,0,-6);
//		return $tv;
//	}   
//        
//                          function tinh_st___rrr($so_gioi_han)
//	{
//                                                     $sql = new db_sql();
//                                                     $sql->db_connect();
//                                                     $sql->db_select();
//                                                     
//		$chuoi_or       =   tinh_chuoi_or();
//		$m=  lay_mang_menu_con__ppp_123($_GET['cat_id']);
//		$tv="";
//		$so=0;
//		for($i=0;$i<count($m);$i++)
//		{
//			$id=$m[$i];
//                                                                                $select = "select count(*) from ".DB_PREFIX."product where id_catalog='$id' $chuoi_or"; 
//                                                                                $sql->query($select);
//                                                                                $r = $sql->num_rows();
//			$so=$so+$r;
//		}
//		$st=ceil($so/$so_gioi_han);
//		return $st;
//	}
        
                    
	
	$module_name = 'Sản phẩm';
	if(session_is_registered('countadd')) //get number record input in databases
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
     
                                                        $catid	= isset($_GET["cat_id"])   ? $_GET["cat_id"]   : (isset($_POST["cat_id"])  ? $_POST["cat_id"]  : "0");
                                                        $sql = new db_sql();
                                                        $sql->db_connect();
                                                        $sql->db_select();                
                                                        $chuoi_or =  tinh_chuoi_or();
                                                        $select_query = "SELECT id_product FROM ".DB_PREFIX."product ";
                                                        if($catid != 0)
                                                            $select_query .= " WHERE id_com_cat = '".$catid."'  $chuoi_or  ";				
                                                        $sql->query($select_query);
                                                        $n = $sql->num_rows();
                                                      
                                                        $rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
                                                        $position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
                                                        $position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;	
                                                        $count_rows = $n;
                                                        
                                                        $pages_number = ceil($count_rows/$rows_per_page_of_product);
                                                        $position_page = ($position_page > $pages_number) ? 1 : $position_page;
                                                        $from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
                                                       
                                                        $tv = "SELECT `id_product`, `ten`, `gia`, `id_com_cat`,`publish`,`create_date`,`code_pro`  FROM ".DB_PREFIX."product  ";                                                       
                                                        if($catid !=0 )
                                                            $tv .= " WHERE id_com_cat = '".$catid."'  $chuoi_or  ";
                                                        $tv .= " order  by code_pro limit $from,$rows_per_page_of_product "; 
                                                        $sql->query($tv);
                                                        $k = 0;
                                                        $tem_arr = array();
                                                        while($r = $sql->fetch_array()){
                                                                        $k = $k+1;
                                                                        $tem_arr[$k]["sanphamid"] = $r["id_product"];
                                                                        $tem_arr[$k]["name"] = $r["ten"];
                                                                        $tem_arr[$k]["id_com_cat"] = $r["id_com_cat"];                                                                       
                                                                        $tem_arr[$k]["publish"] = $r["publish"];
                                                                        $tem_arr[$k]["create_date"] = $r["create_date"];
                                                        }
                                                
?>
<?php include("lib/header.php")?>
                    <script language="JavaScript" type="text/javascript">
                            function delProduct(id,position_page) {
                                    if (confirm("Bạn có muốn xóa thật không ?" )) {
                                            window.location.replace("index.php?pages=product&mode=del&act=del&position_page="+position_page+"&id=" + id);			
                                    }
                            }
                            function open_window(id){
                                            window.open("index.php?pages=product&mode=detail&id=" +id ,"","width=700,height=500,left=0,top=0,scrollbars=yes");
                            }
                    </script>

                    <div id="content">
                                        <div class="breadcrumb">
                                                        <a href="/">Home</a> :: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
                                       </div>
                    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
                                       <div class="box">
                                                            <div class="heading">
                                                                <h1><img src="images/category.png" alt="" />Có (<?=  count($tem_arr)?>) sản phẩm</h1> 
                                                                                    <div class="buttons"><a onclick="location = 'index.php?pages=<?= $pages ?>&cat=<?=$catid?>&mode=add'" class="button">Thêm</a></div>
                                                            </div>
                                                            <div class="content">
                                                                                    <div style="float: left">                                      
                                                                                                    <form action="index.php?pages=product" method="post"  enctype="multipart/form-data"  class="header_table">
                                                                                                                            <select name="cat_id" id="cat_id"  onchange="document.location='index.php?pages=product&cat_id=' + document.getElementById('cat_id').value ">
                                                                                                                                            <?
                                                                                                                                                           $sql = new db_sql();
                                                                                                                                                           $sql->db_connect();
                                                                                                                                                           $sql->db_select();
                                                                                                                                                           $select_query = "SELECT id, id_company, id_catalog FROM ".DB_PREFIX."company_catalog order by id ";		
	$sql->query($select_query);                                                                              $sql->query($select_query);
                                                                                                                                                            echo "<option value='0'>";	
                                                                                                                                                                    echo "Tất cả";
                                                                                                                                                            echo "</option>";
                                                                                                                                                            while($q_tv_2=$sql->fetch_array())
                                                                                                                                                            {
                                                                                                                                                                    if($_GET['cat_id']==$q_tv_2['id'])
                                                                                                                                                                    {
                                                                                                                                                                            $select="selected";
                                                                                                                                                                    }
                                                                                                                                                                    else 
                                                                                                                                                                    {
                                                                                                                                                                            $select="";
                                                                                                                                                                    }
                                                                                                                                                                    echo "<option value='$q_tv_2[id]'  $select >";
                                                                                                                                                                            echo get_cat($q_tv_2[id_catalog])." - ".  get_com($q_tv_2[id_company]);						
                                                                                                                                                                    echo "</option>";                                                                                                                                                             
                                                                                                                                                            }
                                                                                                                                            ?>
                                                                                                                                   </select>
                                                                                                                                   <input  name="cat_id" type="hidden" id="cat_id" value="<?=$catid?>">      
                                                                                                                </form>
                                                                                            </div>
                                                                                                
                                                                                            <div style="float: right">                                                                                                           
                                                                                                            <form action="index.php?pages=product" method="post"  enctype="multipart/form-data" >  
                                                                                                                                <input style="width:250px"  id="tu_khoa" value="Từ khóa tìm kiếm" name="tu_khoa" onfocus="if (this.value=='Từ khóa tìm kiếm'){this.value=''};this.style.backgroundColor='#fffde8';" onblur="this.style.backgroundColor='#ffffff';if (this.value==''){this.value='Từ khóa tìm kiếm'}" />
                                                                                                                                <a class="kien"  href="javascript:;" onclick="document.location='index.php?pages=product&cat_id=' + document.getElementById('cap_do').value+'&tu_khoa='+ document.getElementById('tu_khoa').value">Tìm kiếm</a>                                                                                                                                      
                                                                                                            </form>
                                                                                             </div>
                              
                                                                                            <? if(!empty($tem_arr)){ ?>
                                                                                                                <table class="list">
                                                                                                                            <thead>
                                                                                                                                            <tr>
                                                                                                                                                        <td class="tt">Order</td>
                                                                                                                                                        <td class="left">T&ecirc;n sản phẩm</td>
                                                                                                                                                        <td class="left">Thuộc nhà cung cấp - dịch vụ</td>                                                                                                                                                  
                                                                                                                                                        <td class="left">Date</td>
                                                                                                                                                        <td class="left">Publish</td>
                                                                                                                                                        <td class="right">Công cụ</td>
                                                                                                                                            </tr>
                                                                                                                            </thead>
                                                                                                                            <tbody>
                                                                                                                                            <?php
                                                                                                                                              for($i=1; $i<=count($tem_arr); $i++)
                                                                                                                                              {
                                                                                                                                                      $from                           = $from + 1;                                                                                                                                                   
                                                                                                                                                      $sanphamid 	= $tem_arr[$i]['sanphamid'];
                                                                                                                                                      $ten 		= $tem_arr[$i]['name'];
                                                                                                                                                      $change                      = $tem_arr[$i]['publish']==0?1:0;
                                                                                                                                                      $publish                     = $tem_arr[$i]["publish"];
                                                                                                                                                      $id_com_cat               = $tem_arr[$i]["id_com_cat"];                                                                                                                                                    
                                                                                                                                                      $ngaydang 	= change_date123($tem_arr[$i]["create_date"]);
                                                                                                                                                      $select = "select  id_company, id_catalog FROM ".DB_PREFIX."company_catalog where id= $id_com_cat " ;
                                                                                                                                                      $sql->query($select);
                                                                                                                                                      if($r = $sql->fetch_array()){
                                                                                                                                                          $id_company123 = $r[id_company];
                                                                                                                                                          $id_catalog123 = $r[id_catalog];
                                                                                                                                                      }
                                                                                                                                              ?>
                                                                                                                              <tr>
                                                                                                                                                <td class="tt"><?= $from ?></td>
                                                                                                                                                <td class="left"><a title="Information detail" style="CURSOR: hand" onClick="open_window(<?=$sanphamid ?>)"> <?= $ten ?></a></td>
                                                                                                                                                <td class="left"><?= get_com($id_company123) ?> - <?= get_cat($id_catalog123) ?></td>                                                                                                                                               
                                                                                                                                                <td class="left"><?= $ngaydang ?></td>
                                                                                                                                                <td class="left"><?= ($publish == 1 ? 'C&#243;' : 'Kh&#244;ng') ?> <a style="CURSOR: hand" href="index.php?pages=product&mode=del&amp;act=upd&s=<?=$change?>&id=<?=$sanphamid?>">Change</a></td>
                                                                                                                                                <td class="right">[ <a style="CURSOR: hand" href="index.php?pages=product&mode=edit&position_page=<?=$position_page?>&id=<?= $sanphamid ?>">Sửa</a> ]
                                                                                                                                                                  [ <a style="CURSOR: hand" onClick="delProduct('<?=$sanphamid?>','<?=$position_page?>')">Xóa</a> ]
                                                                                                                                                  </td>
                                                                                                                              </tr>
                                                                                                                                                <?php 
                                                                                                                                                   }
                                                                                                                                                   $sql->close();
                                                                                                                                                 ?>
                                                                                                                          </tbody>
                                                                                                                </table>
                                                                                            <?php pages_browser_admin("index.php?pages=product&position_page=",$position_page,$pages_number);?>
                                                                                            <? }else echo "<br><div align=center>Chưa có sản phẩm  nào trong CSDL !</div>";?>
                                                                        </div>
                                                </div>
                        </div>
</div>
                <?php include("lib/footer.php")?>
</body>
</html>