<?php

if (!defined("qaz_wsxedc_qazxc0FD_123K")){
        die("<a href='index.php'>Login</a> to Web Contents Manager !");
}

function xac_dinh_menu_con__newscat($id_cha)
{
        $sql = new db_sql();
        $sql->db_connect();
        $sql->db_select();
        $tv="select count(*)  from ".DB_PREFIX."newscat  where  newscat_parent='$id_cha'";
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

function de_quy_menu__newcat($id_cha,$kt="")
{
        $sql = new db_sql();
        $sql->db_connect();
        $sql->db_select();
        $kt=$kt."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $tv="select * from ".DB_PREFIX."newscat  where  newscat_parent='$id_cha'";                                                        
        $sql->query($tv);

        while($tv_2=$sql->fetch_array())
        {
                if($_SESSION["selected_cd_mnd__newscat"]==$tv_2['id_newscat'])
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
                $xac_dinh_menu_con__123= xac_dinh_menu_con__newscat($tv_2['id_newscat']);
                if($xac_dinh_menu_con__123=="co")
                {
                    de_quy_menu__newcat($tv_2['id_newscat'],$kt);
                }
        }
}


function echo_khoang_trang_newcat($thuoc_menu)
{
        $sql = new db_sql();
        $sql->db_connect();
        $sql->db_select();
        $total = $sql->fetch_rows(DB_PREFIX."newscat", " id_newscat", $thuoc_menu);
        if($total[0]!=0)
        {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $r_tv="select newscat_parent from ".DB_PREFIX."newscat  where   id_newscat='$thuoc_menu'";
               $sql->query($r_tv);
                $r_tv_2=$sql->fetch_array();
                echo_khoang_trang_newcat($r_tv_2['newscat_parent']);
        }
        else 
        {
        }
}

  function lay_chuoi_menu_con__uuu_newcat($id_cha,$c="")
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
                                        $c=  lay_chuoi_menu_con__uuu_newcat($tem[$i]['id_newscat'],$c);
                                }                      
                }
                return $c;
        }

function lay_chuoi_menu_con__ppp_newcat($id_cha)
{
        $c=  lay_chuoi_menu_con__uuu_newcat($id_cha);
        if($c=="")
        {
                return $id_cha;
        }
        else 
        {
                return $id_cha.$c;
        }
}

function lay_mang_menu_con__ppp_newcat($id_cha)
{
        $c=  lay_chuoi_menu_con__ppp_newcat($id_cha);
        $m=explode("_",$c);
        return $m;
}


function delete_images_newcat($idcha){
                        $message = "";
                        if(!empty($idcha) && is_numeric($idcha)){       
                                    $m_abc = array();
                                    $m_abc = lay_mang_menu_con__ppp_newcat($idcha);        // lấy ra  mảng menu con
                                    if($m_abc[0] == $idcha && count($m_abc) > 1){  // nếu mảng menu con khác rỗng thì thực hiện                                  
                                                                                $message = "Xóa không thành công ! Mời bạn xóa hết các menu con";			
                                    }else if($m_abc[0]==$idcha && count($m_abc) == 1){                                    
                                                    $sp            = array();                                    
                                                    $id = $_GET["id"];
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();
				
                                                    // xóa ảnh đại diện và ảnh album
                                                    $select_query = "SELECT anhtin  FROM ".DB_PREFIX."tintuc  WHERE  newscat_id = $idcha";
                                                    $sql->query($select_query);                                    
                                                    $p = 0;
                                                    while ($r = $sql->fetch_array()){
                                                                    $p = $p + 1;                                                          
                                                                    $sp[$p]["anh"]                            = $r["anhtin"];
                                                    }
                     
                                                    if(!empty($sp)){                                                       
                                                                        for($t=1;$t<=count($sp);$t++){                                                                                      
                                                                                            // xóa ảnh đại diện
                                                                                           $anh_daidien  = $sp[$t]["anh"];		
                                                                                            if(!empty($anh_daidien)){
                                                                                                    $file_path2 = $dir_imgnews1.$anh_daidien;
                                                                                                    if(file_exists($file_path2))   unlink("$file_path2");
                                                                                            }
                                                                        }
                                                                        $delete_query = "DELETE FROM ".DB_PREFIX."newscat  WHERE id_newscat = $idcha";          
                                                                        $delete_query1 = "DELETE FROM ".DB_PREFIX."tintuc  WHERE  newscat_id = $idcha";                                                                           
                                                                        $sql->query($delete_query);
                                                                        $sql->query($delete_query1);
                                                                        $sql->close();
                                                                        $message= "<li>Xóa thành công !";
                                                    }else if(empty ($sp)){
                                                                        $delete_query = "DELETE FROM ".DB_PREFIX."newscat  WHERE id_newscat = $idcha";     
                                                                        $delete_query1 = "DELETE FROM ".DB_PREFIX."tintuc  WHERE  newscat_id = $idcha";  
                                                                        $sql->query($delete_query1);
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
