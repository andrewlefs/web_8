<?
            if (!defined('qaz_wsxedc_qazxc0FD_123K')){		
                            die("<a href='../index.php'>Home</a>");
            }
            function do_html_header($title){
                            $cale = $_lang == 'vn' ?'VN':'EN';
                            global $Auth, $message, $_lang, $lang, $image_tt, $Webdesign, $config_HG;
                            include("theme/header.tpl");
                            }
            function do_html_footer(){
                            global $_lang, $lang, $config_HG;
                            include("theme/footer.tpl");
                            }
           
            function  nav_menu(){
                global $cat;              
                        echo '<ul>';
                                   for($i=1;$i<=count($cat);$i++){
                                             echo '<li><a href="'.WEB_DOMAIN.'/'.  huu($cat[$i]["catname"]).'-'.$cat[$i]["catid"].'.htm">'.$cat[$i]["catname"].'</a></li>';
                                   }
                       echo '</ul>';
            }
            
            function khuyenmai(){
                global $arr_new;
                if(!empty($arr_new[7])){
                        $id_new = $arr_new[7]["id_newscat"];
                        $sql = new db_sql();
                        $sql->db_connect();
                        $sql->db_select();
                         $select_query = "SELECT `tinid`, `tieude` FROM ".DB_PREFIX."tintuc WHERE `newscat_id` = '".$id_new."' and publish='1' ";
                        $sql->query($select_query);	
                        $box3 = array();
                        $i = 0;
                       while ($row = $sql->fetch_array()){		
                                    $i = $i + 1;
                                    $box3[$i]["tinid"] 	= $row["tinid"];
                                    $box3[$i]["tieude"] 	= $row["tieude"];
                       }
                       $sql->close();
                echo '  <div class="title"><h3></h3></div>
                                            <div class="content">
                                            <ul id="carouse1">';
                                            for($j=1;$j<=count($box3);$j++){
                                                         echo '<li><a href="'.WEB_DOMAIN.'/'. huu($box3[$j]["tieude"]).'-'.$box3[$j]["tinid"].'.html">'.$box3[$j]["tieude"].'</a></li>';
                                             }
                                            echo '</ul>
                                            </div>';
                }else{
                    
                }
              }
             function top_main(){
                 global $config_HG,$yahoo;
                        echo '<div class="time">'.date("d/m/Y H:i  A").'</div>
                                <div class="hotro">
                                        <ul>
                                                    <li class="hotline">'.$config_HG[1]["contact"].'</li>';
                                                      for($i=1; $i<=count($yahoo); $i++)	{
                                                        echo '<a href="ymsgr:sendIM?'.$yahoo[$i]["nickname"].'"><img src="http://opi.yahoo.com/online?u='.$yahoo[$i]["nickname"].'" alt="" /><span>'.$yahoo[$i]["yahooname"].'</span></a>';
                                                        }         
                                                  
                                        echo '</ul>
                                </div>';
             }
             
             function bottom_main(){
                        global  $bank,$dir_imglogos1;                      
                        echo '<div class="about">
                                                    <div class="title"><h3>Hệ thống sms 6x65</h3></div>
                                                    <div class="content">
                                                                <img class="daidien" src="'.TPL_LINK.'/images/imgdaidien.png" alt="" />
                                                                <p>Với đội ngũ thiết kế đồ họa và kĩ sư công nghệ thông tin trẻ trung nheietj huyết có trach nhiệm cao trong công việc.Hoàng gia tự tin là nhà thiết kế web hàng đầu Việt Nam hiện nay.Quý khách sẽ hài lòng khi hợp tác với công ty Hoàng gia.</p>
                                                                <p>Với đội ngũ thiết kế đồ họa và kĩ sư công nghệ thông tin trẻ trung nheietj huyết có trach nhiệm cao trong công việc.Hoàng gia tự tin là nhà thiết kế web hàng đầu Việt Nam hiện nay.Quý khách sẽ hài lòng khi hợp tác với công ty Hoàng gia.</p>
                                                                <a href="'.WEB_DOMAIN.'/gioi-thieu.htm" class="chitiet"><img src="'.TPL_LINK.'/images/iconchitiet.png" alt="" /></a>
                                                    </div>
                                </div><!--about-->
                                <div class="list_bank">
                                                    <div class="title"><h3>Chấp nhận thanh toán</h3></div>
                                                    <ul>';
                                                                for($i=1;$i<=count($bank);$i++){
                                                                            echo '<li><a href="'.$bank[$i]["url"].'" target="_bank">
                                                                                                    <div class="img_bank">
                                                                                                                <img src="'.WEB_DOMAIN.$dir_imglogos1.$bank[$i]["logo"].'"  alt="'.$bank[$i]["title"].'"/>
                                                                                                    </div>
                                                                                            </a>
                                                                            </li>';                                                            
                                                                 }
                                                    echo '</ul>
                                </div><!--bank-->';
             }
             
             
            function top_cart(){
                    global $mycart;
                    $count_cart = count($mycart);
                    echo $count_cart;
            }
            function catalog(){
                    global $cat;
                        for($i=1; $i<=count($cat); $i++){
                         echo '<li><a href="'.WEB_DOMAIN.'/cat/'.$cat[$i]["catid"].'/'.huu($cat[$i]["catname"]).'.html" title="'.$cat[$i]["catname"].'">'.$cat[$i]["catname"].'</a></li>';
                        }      
            }

            function catalog_footer(){
                global $cat;
                  for($i=1; $i<=count($cat); $i++){
                      echo ' <a href="'.WEB_DOMAIN.'/cat/'.$cat[$i]["catid"].'/'.huu($cat[$i]["catname"]).'.html" title="'.$cat[$i]["catname"].'">'.$cat[$i]["catname"].'</a> / ';
                  }
            }
            function slider(){
                global $slider, $dir_imgslider1;                    
                    for($i=1;$i<=count($slider);$i++){
                       
                    echo '<a href="'.$slider[$i]["link"].'" title="'.$slider[$i]["content"].'"><img src="'.WEB_DOMAIN.$dir_imgslider1.$slider[$i]["logo"].'" alt="'.$slider[$i]["content"].'" width="640"  /></a>';
                    }
            }

            function yahoo(){
                global $yahoo, $config_HG;        
                    echo '<div class="hotline">';
                    if(count($yahoo)>0){
                        echo '<p class="yahoo">';
                        for($i=1; $i<=count($yahoo); $i++)	{
                        echo '<a href="ymsgr:sendIM?'.$yahoo[$i]["nickname"].'"><img src="http://opi.yahoo.com/online?u='.$yahoo[$i]["nickname"].'" alt="" /><span>'.$yahoo[$i]["yahooname"].'</span></a>';
                        }          
                        echo '</p>';
                        }else {}            
                        echo '  <p class="phone">Hotline :<span> '.$config_HG["intro"].'</span></p>
                                </div>';
            }

            function Pro_hot(){
                    global $pro_hot, $dir_imgproducts1;        

                    if(count($pro_hot)>0){
                        for($i=1; $i<=count($pro_hot); $i++)	{
                            $Hpurl    = WEB_DOMAIN.'/istore/'.$pro_hot[$i]["id"].'-'.huu($pro_hot[$i]["name"]).'.html';
                            echo '<li class="jeans" id="jeans">
                                    <div class="img_sp"><a href="'.$Hpurl.'"><img src="'.WEB_DOMAIN.$dir_imgproducts1.$pro_hot[$i]["img"].'" alt="" /></a></div>
                                    <p><a href="'.$Hpurl.'" class="title">'.$pro_hot[$i]["name"].'</a></p>
                                    <p><span class="gia">'.gia($pro_hot[$i]["price"]).'</span><a href="'.$Hpurl.'">Chi tiết</a></p>
                                </li>';
                        }
                        }else {}  
                    }
                

            function left_catalog(){
                    $sql = new db_sql();
                    $sql->db_connect();
                    $sql->db_select();
                    $tv="select * from ".DB_PREFIX."catalog  where catalog_parent='0' ";
                    $sql->query($tv);
                    echo '<div id="webwidget_vertical_menu" class="webwidget_vertical_menu">               
                            <ul>';
                                    while($tv_2=$sql->fetch_array())
                                    {
                                                 $xac_dinh_menu_con= xac_dinh_menu_con__left_123($tv_2['id_catalog']);                                    
                                                 if($xac_dinh_menu_con=="co")
                                                 {
                                                            echo "<li class='webwidget_vertical_menu_down_drop'  style='border: 0px solid rgb(170, 170, 170); margin-bottom: 2px; background-color: rgb(255, 255, 255); width: 225px; height: 30px;'>";
                                                                          echo "<a href='javascript:;' style='color: rgb(51, 51, 51); font-size: 12px; line-height: 30px; display: block;'>";
                                                                                    echo $tv_2['name'];
                                                                         echo "</a>";
                                                                        echo "<ul style='border: 0px solid rgb(170, 170, 170); background-color: rgb(255, 255, 255); left: 225px; top: 0px;'>";
                                                                                    de_quy_menu__left_123($tv_2[id_catalog]);
                                                                        echo "</ul>
                                                                       </li>";
                                                    }else{
                                                        echo "<li class='webwidget_vertical_menu_down_drop'  style='border: 0px solid rgb(170, 170, 170); margin-bottom: 2px; background-color: rgb(255, 255, 255); width: 225px; height: 30px;'>";
                                                                    echo "<a href='".WEB_DOMAIN."/product-".  huu($tv_2[name])."-".$tv_2[id_catalog]."' style='color: rgb(51, 51, 51); font-size: 12px; line-height: 30px; display: block;'>";
                                                                        echo $tv_2['name'];
                                                                echo "</a>
                                                        </li>";
                                                    }

                                    } 
                    echo "</ul>
                        </div>";

            }      

            function logos(){
                global $logo, $dir_imglogos1 ;
                        for($i=1; $i<=count($logo); $i++){
                      echo '<a href="http://'.$logo[$i]["link"].'" title="Liên kết quảng cáo" target="_bank"><img src="'.WEB_DOMAIN.$dir_imglogos1.$logo[$i]["logo"].'" alt="Liên kết quảng cáo" /></a>';
                      } 	
            }


            // Left Menus
            function dhtml_procat_menu(){
                global $cat,  $dir_imglogos1 ;    
                echo '<div>
                                    <ul>';
                                    for($i=1;$i<=count($cat);$i++){
                                        $tem_sub = get_subcat($cat[$i]["catid"]);
                                        if(!empty($tem_sub)){
                                            echo '<li><a href="'.WEB_DOMAIN.'/cat/'.$cat[$i]["catid"].'/'.huu($cat[$i]["catname"]).'.html"><img src="'.WEB_DOMAIN.$dir_imglogos1.$cat[$i]["img"].'" alt="" />'.$cat[$i]["catname"].'</a>
                                            <ul>';
                                                                    for($j=1;$j<=count($tem_sub);$j++){
                                                                        echo '<li><a href="'.WEB_DOMAIN.'/cat-'.$cat[$i]["catid"].'-'.$tem_sub[$j]["subcatid"].'-'.  huu($tem_sub[$j]["subcatname"]).'.html">'.$tem_sub[$j]["subcatname"].'</a></li>';
                                                                    }
                                                                echo '</ul>
                                                </li>';
                                            }else if(empty ($tem_sub)){
                                                echo '<li><a href="'.WEB_DOMAIN.'/cat/'.$cat[$i]["catid"].'/'.huu($cat[$i]["catname"]).'.html"><img src="'.WEB_DOMAIN.$dir_imglogos1.$cat[$i]["img"].'" alt="" />'.$cat[$i]["catname"].'</a></li>';
                                            }
                                        }                            
                                    echo '</ul>
                              </div>';
            }



            function counter(){ 
                        creatLOG($_SERVER['REMOTE_ADDR']);
                        global $counter;
                        echo '<p>Đang online: <span>'.  getTOTAL().'</span></p><p>Tổng truy cập:<span>'.  number_format($counter,0).'</span></p>';
            }
           

            function menu_footer(){
                global $cat;
                echo '<ul>';
                    for($i=1;$i<=count($cat);$i++){
                                    echo '<li><a href="'.WEB_DOMAIN.'/product/'.$cat[$i]["catid"].'-'.  cut_space(name_ascii($cat[$i]["catname"])).'.html">'.$cat[$i]["catname"].'</a></li>|';
                    }
                                echo '</ul>';
            }
            
            function thongtin(){
                global $config_HG;              
                echo ' <p class="title">'.$config_HG[1]["sitename"].'</p>
                            <p>'.$config_HG[1]["footer"].'</p>';
            }
?>