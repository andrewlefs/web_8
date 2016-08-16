<?php
                    if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                    die("<a href='../index.php'>Home</a>");
                    }
                    $news = array();
                    $view = array();

                    global $arr_new;
                    if($Webdesign == "newscompany")
                    {
                        $id_new = $_GET["id"];
                        $sql = new db_sql();
                        $sql->db_connect();
                        $sql->db_select();	
                        $select_query = "SELECT `tinid`, `tieude`, `noidung`, `nguontin`, `ngaydang`, `anhtin`, `trichdan`, `views`, `tags`, `publish` FROM ".DB_PREFIX."tintuc where `newscat_id`='".$id_new."' ";
                        $sql->query($select_query);
                        $count_rows = $sql->num_rows();
                        //$rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
                        $rows_per_page_of_product = 20;
                         $position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
                         $position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;	
                         $pages_number = ceil($count_rows/$rows_per_page_of_product);
                         $from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
                         $select_query1 = "SELECT `tinid`, `tieude`, `noidung`, `nguontin`, `ngaydang`, `anhtin`, `trichdan`, `views`, `tags`, `publish` FROM ".DB_PREFIX."tintuc where `newscat_id`='".$id_new."' ORDER BY ngaydang DESC LIMIT $from, $rows_per_page_of_product";
                         $sql->query($select_query1);
                        $i = 0;
                        while($rows = $sql->fetch_array()){
                                $ngaydang = $rows["ngaydang"];
                                $i = $i + 1;
                                $view[$i]["tinid"]                      = $rows["tinid"];
                                $view[$i]["newscat_id"]          = $rows["newscat_id"];
                                $view[$i]["tieude"]                   = $rows["tieude"];
                                $view[$i]["anhtin"]                     = $rows["anhtin"];
                                $view[$i]["trichdan"]               = $rows["trichdan"];
                                $view[$i]["noidung"]                = strip_tags(strimString($rows["noidung"],60));
                                $view[$i]["ngaydang"]               = change_date123($rows["ngaydang"]);
                        }
                        
                        for($j=1;$j<=count($arr_new);$j++){
                            if($arr_new[$j]["id_newscat"]==$id_new){
                                            $name = $arr_new[$j]["name"];
                            }
                        }
                        $sql->close();	
                }
                $title = array(	"newscompany" => $name , 	);


function publish(){
    global  $view, $dir_imgnews1,$position_page,$pages_number,$name;
    echo '<div class="title"><h1>'.$name.'</h1></div>
                    <div class="content">';
                           if(count($view)>0){
                                echo '<ul class="list_tin">';
                                                    for($i=1;$i<=count($view);$i++){
                                                                if($i%2!=0){                                                    
                                                                echo '<li>
                                                                                <div class="img_tin"><a href="'.WEB_DOMAIN.'/'.  huu($view[$i]["tieude"]).'-'.$view[$i]["tinid"].'.html"><img src="'.WEB_DOMAIN.$dir_imgnews1.$view[$i]["anhtin"].'" alt="ảnh tin" /></a></div>
                                                                                <div class="content">
                                                                                    <h2><a href="'.WEB_DOMAIN.'/'.  huu($view[$i]["tieude"]).'-'.$view[$i]["tinid"].'.html">'.$view[$i]["tieude"].'</a></h2>
                                                                                    <p>'.  strip_tags(strimString($view[$i]["trichdan"], 150)).'</p>
                                                                                    <a href="'.WEB_DOMAIN.'/'.  huu($view[$i]["tieude"]).'-'.$view[$i]["tinid"].'.html" class="chitiet">Xem chi tiết</a>
                                                                                </div>
                                                                        </li>';
                                                                }else{
                                                                        echo '<li class="fright">
                                                                            <div class="img_tin"><a href="'.WEB_DOMAIN.'/'.  huu($view[$i]["tieude"]).'-'.$view[$i]["tinid"].'.html"><img src="'.WEB_DOMAIN.$dir_imgnews1.$view[$i]["anhtin"].'" alt="ảnh tin" /></a></div>
                                                                                <div class="content">
                                                                                    <h2><a href="'.WEB_DOMAIN.'/'.  huu($view[$i]["tieude"]).'-'.$view[$i]["tinid"].'.html">'.$view[$i]["tieude"].'</a></h2>
                                                                                    <p>'.  strip_tags(strimString($view[$i]["trichdan"], 150)).'</p>
                                                                                    <a href="'.WEB_DOMAIN.'/'.  huu($view[$i]["tieude"]).'-'.$view[$i]["tinid"].'.html" class="chitiet">Xem chi tiết</a>
                                                                                </div>
                                                                        </li>';
                                                                        }
                                                          }
                                            echo '</ul>
                                          <div class="clear"></div> 
                                            <div class="control">
                                            <ul class="pagination">';
                                                             pages_browser_admin(WEB_DOMAIN."/tin-tuc-trang-",$position_page,$pages_number);
                                             echo '</ul></div>';
                                            }  else {
                                                        echo "Đang cập nhật dữ liệu";
                                            }
                                echo '</div>';
}

?>