<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
         session_start();
                            
                            function tinh_chuoi_or_new()
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
                                                    $chuoi_or=$chuoi_or."tieude like '%$q%' or ";
                                            }
                                    }
                                    if($chuoi_or!="")
                                    {
                                            $chuoi_or=substr($chuoi_or,0,-3);
                                            $chuoi_or=" and ( ".$chuoi_or." ) ";
                                    }
                                    return $chuoi_or;
                            }
                            
                            function  xac_dinh_menu_con__new($id_cha)
	{
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();		
		$tv_2       =  $sql->fetch_rows(DB_PREFIX."newscat", "newscat_parent", $id_cha);                                                 
		if($tv_2[0]==0)
		{
			return "khong";
		}
		else 
		{
			return "co";
		}
	}
        
                           function de_quy_menu_new($id_cha,$kt="")
                            {
                                    $sql = new db_sql();
                                    $sql->db_connect();
                                    $sql->db_select();
                                    $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                    $tv="select * from ".DB_PREFIX."newscat  where  newscat_parent='$id_cha'";                                                        
                                    $sql->query($tv);

                                    while($tv_2=$sql->fetch_array())
                                    {
                                            if($_GET["newscat_id"]==$tv_2['id_newscat'])
                                            {
                                                    $select="selected";
                                            }
                                            else 
                                            {
                                                    $select="";
                                            }
                                            echo "<option value='$tv_2[id_newscat]' $select >";
                                                    echo $kt;	
                                                    echo $tv_2['name'];												
                                            echo "</option>";
                                            $xac_dinh_menu_con__123= xac_dinh_menu_con__new($tv_2['id_newscat']);
                                            if($xac_dinh_menu_con__123=="co")
                                            {
                                                    de_quy_menu_new($tv_2['id_newscat'],$kt);
                                            }
                                    }
                            }
        
                            function lay_chuoi_menu_con__new($id_cha,$c="")
	{
                                                        $sql = new db_sql();
                                                        $sql->db_connect();
                                                        $sql->db_select();
                                                        $tv="select id_newscat from ".DB_PREFIX."newscat  where newscat_parent='$id_cha'";
                                                        $sql->query($tv);         
                                                        $tem = array();
                                                        $i = 0;
                                                        while($tv_2=$sql->fetch_array())
                                                        {         
                                                                        $i = $i + 1;
                                                                        $tem[$i]["id_newscat"] = $tv_2['id_newscat'];
                                                         }

                                                         for($i=1;$i<=count($tem);$i++){   
                                                                        $c= $c."_".$tem[$i]['id_newscat']; 
                                                                        $a_tv_2 = $sql->fetch_rows(DB_PREFIX."newscat","newscat_parent", $tem[$i][id_newscat]);                        
                                                                        if($a_tv_2[0]!=0)
                                                                        {
                                                                                $c= lay_chuoi_menu_con__new($tem[$i]['id_newscat'],$c);
                                                                        }                      
                                                        }
                                                        return $c;
	}
        
	function lay_chuoi_menu_con__ppp_new($id_cha)
	{
		$c= lay_chuoi_menu_con__new($id_cha);
		if($c=="")
		{
			return $id_cha;
		}
		else 
		{
			return $id_cha.$c;
		}
	}
	
	function lay_mang_menu_con__ppp_new($id_cha)
	{
		$c=lay_chuoi_menu_con__ppp_new($id_cha);
		$m=explode("_",$c);
		return $m;
	}
	function tinh_chuoi_union__ppp_new($catid)
	{
                                                     $sql = new db_sql();
                                                     $sql->db_connect();
                                                     $sql->db_select();
                                                     $chuoi_or           =        tinh_chuoi_or_new();
		$m                        = lay_mang_menu_con__ppp_new($catid);
		$tv="";
		for($i=0;$i<count($m);$i++)
		{
			$id=$m[$i];
                                                                                $select = "select count(*) from ".DB_PREFIX."tintuc where newscat_id='$id' $chuoi_or"; 
                                                                                $sql->query($select);
                                                                                $r = $sql->num_rows();						
			if($id!="")
			{
				$tv=$tv." ( select * from ".DB_PREFIX."tintuc where newscat_id='$id' $chuoi_or order by ngaydang desc ) union";
			}
		}
		$tv=substr($tv,0,-6);
		return $tv;
	}   
        
                          function tinh_st___rrr_new($so_gioi_han)
	{
                                                     $sql = new db_sql();
                                                     $sql->db_connect();
                                                     $sql->db_select();
                                                     
		$chuoi_or       =   tinh_chuoi_or_new();
		$m=  lay_mang_menu_con__ppp_new($_GET['cat_id']);
		$tv="";
		$so=0;
		for($i=0;$i<count($m);$i++)
		{
			$id=$m[$i];
                                                                                $select = "select count(*) from ".DB_PREFIX."tintuc where newscat_id='$id' $chuoi_or"; 
                                                                                $sql->query($select);
                                                                                $r = $sql->num_rows();
			$so=$so+$r;
		}
		$st=ceil($so/$so_gioi_han);
		return $st;
	}
	
	$module_name = 'Tin tức';
	if(session_is_registered('countadd')) //get number record input in databases
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
     
                                                   $newscat_id	= isset($_GET["newscat_id"])   ? $_GET["newscat_id"]   : (isset($_POST["newscat_id"])  ? $_POST["newscat_id"]  : "");
                                                        $sql = new db_sql();
                                                        $sql->db_connect();
                                                        $sql->db_select();                                                     
                                                        
                                                        $sql->query($select_query);
                                                 
                                                        $rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
                                                        $position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
                                                        $position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;	
                                                        
                                                        $pages_number   = tinh_st___rrr_new($rows_per_page_of_product);                                                  
                                                        
                                                        $position_page = ($position_page > $pages_number) ? 1 : $position_page;
                                                        $from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
                                                        $chuoi_union__ppp= tinh_chuoi_union__ppp_new($newscat_id);                                                        
                                                        $tv   =  $chuoi_union__ppp." limit $from,$rows_per_page_of_product ";                    
                                                        $sql->query($tv);
                                                        $k = 0;
                                                        $tem_arr = array();
                                                        while($r = $sql->fetch_array()){
                                                                        $k = $k+1;
                                                                        $tem_arr[$k]["tinid"] = $r["tinid"];
                                                                        $tem_arr[$k]["tieude"] = $r["tieude"];
                                                                        $tem_arr[$k]["publish"] = $r["publish"];
                                                                        $tem_arr[$k]["ngaydang"] = $r["ngaydang"];
                                                        }		
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delNew(id, newscat,sn_id,position_page) {
		if (confirm("Bạn có muốn xóa thật không ?" )) {
			window.location.replace("index.php?pages=new&mode=del&act=del&position_page="+position_page+"&newscat="+newscat+"&id=" + id);			
		}
	}
	function open_window(id){
			window.open("index.php?pages=new&mode=detail&id=" +id ,"","width=800,height=600,left=0,top=0,scrollbars=yes");
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=new&newscat=<?=$newscat_id?>">Category</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Tin tức</h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=new&mode=add'" class="button">Thêm</a><a onclick="$('#form').submit();" class="button">Delete</a></div>
    </div>

    <div class="content">           
        <tr>
          <td class="header_table">
              <div style="float: left">                                      
                            <form action="index.php?pages=new" method="post"  enctype="multipart/form-data"  class="header_table">
                                                    <select name="cap_do" id="cap_do"  onchange="document.location='index.php?pages=new&newscat_id=' + document.getElementById('cap_do').value ">
                                                                    <?
                                                                                   $sql = new db_sql();
                                                                                   $sql->db_connect();
                                                                                   $sql->db_select();
                                                                                    $q_tv="select  id_newscat,name  from ".DB_PREFIX."newscat  where newscat_parent=0";
                                                                                    $sql->query($q_tv);
                                                                                    echo "<option value='0'>";	
                                                                                            echo "Tất cả";
                                                                                    echo "</option>";
                                                                                    while($q_tv_2=$sql->fetch_array())
                                                                                    {
                                                                                            if($_GET['newscat_id']==$q_tv_2['id_newscat'])
                                                                                            {
                                                                                                    $select="selected";
                                                                                            }
                                                                                            else 
                                                                                            {
                                                                                                    $select="";
                                                                                            }
                                                                                            echo "<option value='$q_tv_2[id_newscat]'  $select >";
                                                                                                    echo $q_tv_2['name'];						
                                                                                            echo "</option>";
                                                                                            $xac_dinh_menu_con__123= xac_dinh_menu_con__new($q_tv_2['id_newscat']);
                                                                                            if($xac_dinh_menu_con__123=="co")
                                                                                            {
                                                                                                de_quy_menu_new($q_tv_2['id_newscat']);
                                                                                            }
                                                                                    }
                                                                    ?>
                                                           </select>
                                                           <input  name="newscat_id" type="hidden" id="newscat_id" value="<?=$newscat_id?>">      
                                        </form>
                    </div>
                    <?php 
                                if($_GET['tu_khoa']=="")
                                {
                                        $tu_khoa_input="Từ khóa tìm kiếm";
                                }
                                else 
                                {
                                        $tu_khoa_input=$_GET['tu_khoa'];
                                }
                        ?>

                    <div style="float: right">                                                                                                           
                                    <form action="index.php?pages=new" method="post"  enctype="multipart/form-data" >  
                                                        <input style="width:250px"  id="tu_khoa" value="Từ khóa tìm kiếm" name="tu_khoa" onfocus="if (this.value=='Từ khóa tìm kiếm'){this.value=''};this.style.backgroundColor='#fffde8';" onblur="this.style.backgroundColor='#ffffff';if (this.value==''){this.value='Từ khóa tìm kiếm'}" />
                                                        <a class="kien"  href="javascript:;" onclick="document.location='index.php?pages=new&newscat_id=' + document.getElementById('cap_do').value+'&tu_khoa='+ document.getElementById('tu_khoa').value">Tìm kiếm</a>                                                                                                                                      
                                    </form>
                     </div>
          </td>
        </tr>

          <? if(!empty($tem_arr)){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="tt">Order</td>
              <td class="left">T&ecirc;n bản tin</td>
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
                                   $tinid                           = $tem_arr[$i]['tinid'];
                                   $tieude                      = $tem_arr[$i]['tieude'];
                                   $change                      = $tem_arr[$i]['publish']==0?1:0;
                                   $publish                     = $tem_arr[$i]["publish"];
                                    $ngaydang 	= change_date123($tem_arr[$i]["ngaydang"]);			
             ?>
          
            <tr>
              <td class="tt"><?= $from ?></td>
              <td class="left"><a title="Information detail" style="CURSOR: hand" onClick="open_window(<?=$tinid ?>)"><?= $tieude ?></a></td>
              <td class="left"><?= $ngaydang ?></td>
              <td class="left"><?= ($publish == 1 ? 'C&#243;' : 'Kh&#244;ng') ?> <a style="CURSOR: hand" href="index.php?pages=new&mode=del&amp;act=upd&s=<?=$change?>&id=<?=$tinid?>">Change</a></td>
              <td class="right">[ <a style="CURSOR: hand" href="index.php?pages=new&mode=edit&position_page=<?=$position_page?>&id=<?= $tinid ?>">Sửa</a> ]
                                [ <a style="CURSOR: hand" onClick="delNew('<?=$tinid?>','<?=$position_page?>')">Xóa</a> ]
                </td>
            </tr>
            <?php 
		} $sql->close();
		?>

        </tbody>
        </table>
        <?php pages_browser_admin("index.php?pages=new&position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có nhà sản xuất nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>