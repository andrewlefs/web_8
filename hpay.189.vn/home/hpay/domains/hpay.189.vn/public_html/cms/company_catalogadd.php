<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                           session_start();
                          
	if( isset($_POST["mode"]) && $_POST["mode"] == "add" &&  isset($_POST["pages"]) && $_POST["pages"] == "company_catalog"){
                                                    if(!session_register('countadd')){
                                                            session_register('countadd');
                                                            $HTTP_SESSION_VARS['countadd']=0;
                                                    }
                                                    
                                                     $_SESSION["selected_cd_mnd__789"] =  $_POST['cap_do'];
                                                     $catid_parent = $_POST['cap_do'];
		$company_id = $_POST['company_id'];                                              
		$message1 = $company_id == 0 ? "Hãy chọn nhà cung cấp" : "";
                                                    
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();				
                
		if($message1 ==""){			
			$insert_query = "INSERT  INTO ".DB_PREFIX."company_catalog (id_company ,id_catalog) 
                                                                                                                                            VALUES ('$company_id',  '$catid_parent' )";			
			if($sql->query($insert_query)){	                                                                                                        
				$HTTP_SESSION_VARS['countadd'] = $HTTP_SESSION_VARS['countadd'] + 1;
				$message = "Thông tin nhà cung cấp dịch vụ thứ ".$HTTP_SESSION_VARS['countadd']." &#273;&atilde; &#273;&#432;&#7907;c th&ecirc;m v&agrave;o CSDL";			
			}		
			$n = $sql->count_rows(DB_PREFIX."company_catalog") + 1;										
			$sql->close();	
		}
	}	
	else{
			$sql = new db_sql();
			$sql->db_connect();
			$sql->db_select();
			$n = $sql->count_rows(DB_PREFIX."company_catalog") + 1;
			$sql->close();
	}
?>
<?php include("lib/header.php")?>
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=cate">Quản lý danh mục </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>"; if($message1!="") echo "<div class='success'>Success: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Danh mục sản phẩm</h1>
      <form action=index.php method=post enctype="multipart/form-data" name="cateadd" id="cateadd">
      <div class="buttons"><input type="submit" value="Thêm" name="submit" class="submit1" ><a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
       <div id="tab-general">
       <div id="language1">
            <table class="form">
                 <tr>
                        <td width="150px" >
                                Chọn danh mục sản phẩm <span class="required">*</span>:
                        </td>
                        <td>
                                <?php 
                                        function xac_dinh_menu_con__123_add($id_cha)
                                        {
                                                $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();	                                          
                                                $tv_2= $sql->fetch_rows(DB_PREFIX."catalog", "catalog_parent", $id_cha);
                                                if($tv_2[0]==0)
                                                {
                                                        return "khong";
                                                }
                                                else 
                                                {
                                                        return "co";
                                                }
                                        }
                                        function de_quy_menu__fff_add($id_cha,$kt="")
                                        {
                                                 $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();
                                                $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                $tv="select * from ".DB_PREFIX."catalog where catalog_parent='$id_cha'";
                                               $sql->query($tv);
                                                while($tv_2=$sql->fetch_array())
                                                {
                                                        if($_SESSION["cap_do___kkk"]==$tv_2['id_catalog'])
                                                        {
                                                                $select="selected";
                                                        }
                                                        else 
                                                        {
                                                                $select="";
                                                        }
                                                        echo "<option value='$tv_2[id_catalog]' $select >";
                                                                echo $kt;	
                                                                echo $tv_2['name'];												
                                                        echo "</option>";
                                                        $xac_dinh_menu_con__123=  xac_dinh_menu_con__123_add($tv_2['id_catalog']);
                                                        if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                de_quy_menu__fff_add($tv_2['id_catalog'],$kt);
                                                        }
                                                }	
                                        }
                                ?>
                                <?php 
                                                $sql = new db_sql();
                                                $sql->db_connect();	
                                                $sql->db_select();
                                        echo "<select name='cap_do' style='height:35px'>";
                                                  $tv="select * from ".DB_PREFIX."catalog where catalog_parent=0";
                                                $sql->query($tv);
                                                while($tv_2=$sql->fetch_array())
                                                {
                                                        if($_SESSION["cap_do___kkk"]==$tv_2['id_catalog'])
                                                        {
                                                                $select="selected";
                                                        }
                                                        else 
                                                        {
                                                                $select="";
                                                        }
                                                        echo "<option value='$tv_2[id_catalog]' $select >";
                                                                echo $tv_2['name'];						
                                                        echo "</option>";
                                                        $xac_dinh_menu_con__123=xac_dinh_menu_con__123_add($tv_2['id_catalog']);
                                                        if($xac_dinh_menu_con__123=="co")
                                                        {
                                                                de_quy_menu__fff_add($tv_2['id_catalog']);
                                                        }
                                                }
                                        echo "</select>";
                                ?>
                        </td>
                </tr>
                <tr>
                    <td>Chọn danh mục nhà mạng<span class="required">*</span>:</td>
                    <td>
                        <select name="company_id">
                            <option value="0">-- Chọn nhà mạng --</option>
                            <?php for($i=1;$i<=count($company);$i++){?>
                                    <option value="<?=$company[$i]["id_company"]?>"><?=$company[$i]["name"]?></option>
                            <?}?>
                        </select>
                    </td>
                </tr>
            </table>
          </div>
       </div>
        <input type="hidden" value="Add" name="submit">
        <input name="pages" type="hidden" id="pages" value="company_catalog">
        <input name="mode" type="hidden" id="mode" value="add">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body></html>

