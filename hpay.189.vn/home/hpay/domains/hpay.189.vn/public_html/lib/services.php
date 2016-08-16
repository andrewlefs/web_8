<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>Home</a>");
                }
                $pro = array();
                $id_company = array(); 
                $sql = new db_sql();
                $sql->db_connect();
                $sql->db_select();
                $option = $HTTP_GET_VARS["Webdesign"];
                if(isset($_GET["id_service"]) && $_GET["Webdesign"] == "services"){
                                    $id_service = isset($_GET["id_service"]) && is_numeric($_GET["id_service"]) ? $_GET["id_service"] : 0;
                                    
                                    for($i=1; $i<=count($cat); $i++){
                                            if($cat[$i]["catid"]==$id_service){
                                                    $catname = $cat[$i]["catname"];
                                                    break;
                                            }
                                     }
                                     
                                     // get id_company Provided 
                                     $select_id_company = "select id,id_company from ".DB_PREFIX."company_catalog  where id_catalog ='".$id_service." '";
                                     $sql->query($select_id_company);
                                     $n = $sql->num_rows();
                                     $i  = 0;
                                     while ($r = $sql->fetch_array()){
                                                    $i =  $i +1;
                                                    $id_company[$i]["id"] = $r["id"];
                                                    $id_company[$i]["id_company"] = $r["id_company"];
                                     }
                           
                                    $title = array("services" => $catname , );
                }
                
                
                function get_images($id_com){
                                    $ha = "";
                                    $sql = new db_sql();
                                    $sql->db_connect();
                                    $sql->db_select();
                                    $select = "select logo from  ".DB_PREFIX."company where id_company=$id_com limit 1";
                                    $sql->query($select);
                                    if($r = $sql->fetch_array()){
                                                $ha = $r["logo"];
                                    }
                                    $sql->close();
                                    return $ha;
                }
                $sql->close();


                function company_network(){
                                global $n,$id_company,$dir_imglogos1;
                                if($n > 0){
                                            echo ' <ul>';
                                                        for($i=1;$i<=count($id_company);$i++){
                                                                        $id_tem = $id_company[$i]["id"];
                                                                        $logo = get_images($id_tem);
                                                                        echo '<li><a href="'.WEB_DOMAIN.'/buy-card/'.  huu(get_com($id_tem)).'-'.$id_tem.'" title="'.  get_com($id_tem).'">
                                                                                                <div class="img_thecao">
                                                                                                        <img src="'.WEB_DOMAIN.$dir_imglogos1.$logo.'" alt="'.get_com($id_tem).'" />
                                                                                                </div>
                                                                                           </a>
                                                                       </li>';
                                                        }
                                             echo '</ul>';
                                }else{
                                            echo "Đang cập nhật nhà cung cấp dịch vụ";
                                }
                }
        
?>