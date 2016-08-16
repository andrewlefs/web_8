<?php

if (!defined("qaz_wsxedc_qazxc0FD_123K")){
        die("<a href='index.php'>Login</a> to Web Contents Manager !");
}

function xac_dinh_menu_con__123($id_cha)
{
        $sql = new db_sql();
        $sql->db_connect();
        $sql->db_select();
        $tv="select count(*)  from ".DB_PREFIX."catalog  where  catalog_parent='$id_cha'";
        $sql->query($tv);                                                        
        $tv_2=$sql->num_rows();

        if($tv_2==0)
        {
                return "khong";
        }
        else 
        {
                return "co";
        }
}

function de_quy_menu__fff($id_cha,$kt="")
{
        $sql = new db_sql();
        $sql->db_connect();
        $sql->db_select();
        $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $tv="select * from ".DB_PREFIX."catalog  where  catalog_parent='$id_cha'";                                                        
        $sql->query($tv);

        while($tv_2=$sql->fetch_array())
        {
                if($_SESSION["selected_cd_mnd__789"]==$tv_2['id_catalog'])
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
                $xac_dinh_menu_con__123=xac_dinh_menu_con__123($tv_2['id_catalog']);
                if($xac_dinh_menu_con__123=="co")
                {
                        de_quy_menu__fff($tv_2['id_catalog'],$kt);
                }
        }
}


function echo_khoang_trang($thuoc_menu)
{
        $sql = new db_sql();
        $sql->db_connect();
        $sql->db_select();
        $total = $sql->fetch_rows(DB_PREFIX."catalog", " id_catalog", $thuoc_menu);
        if($total[0]!=0)
        {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $r_tv="select catalog_parent from ".DB_PREFIX."catalog  where   id_catalog='$thuoc_menu'";
               $sql->query($r_tv);
                $r_tv_2=$sql->fetch_array();
                echo_khoang_trang($r_tv_2['catalog_parent']);
        }
        else 
        {
        }
}

  function lay_chuoi_menu_con__uuu($id_cha,$c="")
  {
                 $sql = new db_sql();
                $sql->db_connect();
                $sql->db_select();
                $tv="select id_catalog from ".DB_PREFIX."catalog  where catalog_parent='$id_cha'";
                $sql->query($tv);         
                $tem = array();
                $i = 0;
                while($tv_2=$sql->fetch_array())
                {         
                                $i = $i + 1;
                                $tem[$i]["id_catalog"] = $tv_2['id_catalog'];
                 }
                 
                 for($i=1;$i<=count($tem);$i++){                   
                 
                                $c= $c."_".$tem[$i]['id_catalog']; 
                                $a_tv_2 = $sql->fetch_rows(DB_PREFIX."catalog","catalog_parent", $tem[$i][id_catalog]);                        
                                if($a_tv_2[0]!=0)
                                {
                                        $c=lay_chuoi_menu_con__uuu($tem[$i]['id_catalog'],$c);
                                }                      
                }
                return $c;
        }

function lay_chuoi_menu_con__ppp($id_cha)
{
        $c=lay_chuoi_menu_con__uuu($id_cha);
        if($c=="")
        {
                return $id_cha;
        }
        else 
        {
                return $id_cha.$c;
        }
}

function lay_mang_menu_con__ppp($id_cha)
{
        $c=lay_chuoi_menu_con__ppp($id_cha);
        $m=explode("_",$c);
        return $m;
}


function delete_images($idcha){
                        $message = "";
                        if(!empty($idcha) && is_numeric($idcha)){       
                                    $m_abc = array();
                                    $m_abc = lay_mang_menu_con__ppp($idcha);        // lấy ra  mảng menu con
                                    if($m_abc[0] == $idcha && count($m_abc) > 1){  // nếu mảng menu con khác rỗng thì thực hiện                                  
                                                    $message = "Xóa không thành công ! Mời bạn xóa hết các menu con";			
                                    }else if($m_abc[0]==$idcha && count($m_abc) == 1){                                    
                                                    $sp            = array();                                    
                                                    $id = $_GET["id"];
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();
				
                                                    // xóa ảnh đại diện và ảnh album
                                                    $select_query = "SELECT `id_product`, `anh` FROM ".DB_PREFIX."product WHERE `id_com_cat` in (SELECT `id` FROM ".DB_PREFIX."company_catalog  WHERE `id_catalog` = $idcha)";
                                                    $sql->query($select_query);                                    
                                                    $p = 0;
                                                    while ($r = $sql->fetch_array()){
                                                                    $p = $p + 1;
                                                                    $sp[$p]["id_product"]               = $r["id_product"];
                                                                    $sp[$p]["anh"]                            = $r["anh"];
                                                    }
                     
                                                    if(!empty($sp)){                                                       
                                                                        for($t=1;$t<=count($sp);$t++){

                                                                                            // lấy ảnh của sản phẩm và xóa
                                                                                            $album      =  array();
                                                                                            $id_pro = $sp[$t]["id_product"];
                                                                                            $select_query = "SELECT images FROM ".DB_PREFIX."proimg  WHERE  id_pro = $id_pro";
                                                                                            $sql->query($select_query);
                                                                                            $l = 0;
                                                                                            while($row = $sql->fetch_array()){
                                                                                                            $l=$l+1;
                                                                                                            $album[$l]["anh"] = $row["images"];
                                                                                            }

                                                                                            if(!empty($album)){
                                                                                                             for($h=1; $h<=count($album);$h++){	
                                                                                                                            $anh = $album[$h]["anh"];		
                                                                                                                            if(!empty($anh)){
                                                                                                                                    $file_path = $dir_imgproducts.$anh;
                                                                                                                                    if(file_exists($file_path))	unlink("$file_path");
                                                                                                                                    $file_path1 = $dir_imgproducts."origin/".$anh;
                                                                                                                                    if(file_exists($file_path1))unlink("$file_path1");

                                                                                                                            }
                                                                                                           }	
                                                                                            }

                                                                                            // xóa ảnh đại diện
                                                                                           $anh_daidien  = $sp[$t]["anh"];		
                                                                                            if(!empty($anh_daidien)){
                                                                                                    $file_path2 = $dir_imgproducts.$anh_daidien;
                                                                                                    if(file_exists($file_path2))	unlink("$file_path2");

                                                                                                    $file_path3 = $dir_imgproducts."origin/".$anh_daidien;
                                                                                                    if(file_exists($file_path3))	unlink("$file_path3");

                                                                                            }
                                                                        }
                                                                        $delete_query = "DELETE FROM ".DB_PREFIX."catalog  WHERE id_catalog = $idcha";                                                                   	
                                                                        $sql->query($delete_query);
                                                                        $sql->close();
                                                                        $message= "<li>Xóa thành công !";
                                                    }else if(empty ($sp)){
                                                                        $delete_query = "DELETE FROM ".DB_PREFIX."catalog  WHERE id_catalog = $idcha";                                                                   	
                                                                        $sql->query($delete_query);
                                                                        $sql->close();
                                                                        $message= "<li>Xóa thành công !";
                                                    }                         
                                    }                                   
                            }else{
                                    $message = "Lỗi không nhận dạng mã danh mục";
                            }
                            
                            return $message;
}



?>
