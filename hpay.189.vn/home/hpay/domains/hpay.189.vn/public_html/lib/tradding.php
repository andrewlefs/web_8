<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>Trang ch&#7911;</a>");
                }
                if($Auth["memberid"] < 1){
                        header("Location: /login.html");
                        exit;
                }

                $sql = new db_sql();
                $sql->db_connect();
                $sql->db_select();
                
                $arr_val = array();

                if(isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="tradding"){
                                            $select = "SELECT  lrq.`id` as request_id, lrq.`method` as request_method, lrq.`createdate` as request_createdate,lrq.`publish` as request_publish
                                                                        FROM  ".DB_PREFIX."list_request lrq  where  lrq.user_id ='".$Auth[memberid]."' and lrq.method !='buycard'  ";
                                         
                                            $sql->query($select);
                                            $n = $sql->num_rows();

                                            //$rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
                                            $rows_per_page_of_product = 35;
                                            $position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
                                            $position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;	
                                            $count_rows = $n;
                                            $pages_number = ceil($count_rows/$rows_per_page_of_product);
                                            $position_page = ($position_page > $pages_number) ? 1 : $position_page;
                                            $from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);

                                            $tv = "SELECT   lrq.`id` as request_id, lrq.`method` as request_method, lrq.`createdate` as request_createdate,  lrq.`publish` as request_publish
                                                                        FROM ".DB_PREFIX."list_request lrq  where  lrq.user_id ='".$Auth[memberid]."' and lrq.method !='add_money_banking' 
                                                                         order by lrq.`createdate` desc,lrq.`method` limit $from, $rows_per_page_of_product " ;                                          
                                            $sql->query($tv);
                                            $i = 0;
                                            while ($r = $sql->fetch_array()){
                                                        $i = $i +1;
                                                        $arr_val[$i]["request_id"] = $r["request_id"];
                                                        $arr_val[$i]["request_publish"] = $r["request_publish"];
                                                        $arr_val[$i]["request_method"] = $r["request_method"];
                                                        $arr_val[$i]["request_createdate"] = $r["request_createdate"];
                                            }
                                            
                                            $sql->close();
                }
                
                function publish(){
                    global $arr_val,$position_page,$pages_number;
                    echo '<div class="left_box_slide naptien">
                                <div class="title"><h3>Thống kê giao dịch</h3></div>
                            <div class="content">
                                <table border="1" cellpadding="10">
                                        <tbody>
                                        <tr class="tieude">
                                                <td width="3%">STT</td>
                                            <td>Nội dung</td>
                                            <td width="20%">Thời gian</td>
                                            <td width="20%">Trạng thái</td>
                                        </tr>';
                                          for($j = 1; $j<=count($arr_val);$j++){
                                                        $from = $from + 1;
                                                        $request_method 	= $arr_val[$j]['request_method'];                            
                                                        $request_id               = $arr_val[$j]['request_id'];
                                                        $publish                     = $arr_val[$j]["request_publish"]==1?"Đã xử lý":"Chưa xử lý";
                                                        $ngaydang 	= change_date123($arr_val[$j]["request_createdate"]);

                                                        if($request_method=="add_money_banking")
                                                            $name_pt = "Nạp tiền qua internet banking";
                                                        else if($request_method=="addcard")
                                                            $name_pt = "Nạp tiền qua thẻ cào";
                                                        else if($request_method=="sendmoney")
                                                            $name_pt = "Chuyển khoản";
                                                        else if($request_method=="ruttien")
                                                                $name_pt = "Rút tiền tại đại lý";
                                                        else if($request_method=="naptien")
                                                               $name_pt = "Nạp tiền tại đại lý";          
                                                         
                                       echo '  <tr>
                                            <td align="center">'.$from.'</td>
                                            <td align="left">'.$name_pt.'</td>
                                            <td align="left">'.$ngaydang.'</td>
                                            <td align="left">'.$publish.'</td>
                                        </tr>';
                                       }
                                    echo '</tbody>
                                </table>
                              <!--      <div class="pagings clearfix">
                                                <div class="column1">';
                                                                echo "<div class='phantrang'>"; 
                                                                         echo "<div class='paging01'>";
                                                                                 pages_browser(WEB_DOMAIN."/tradding-page-",$position_page,$pages_number);
                                                                         echo "</div>";
                                                                echo "</div>";
                                                 echo '</div>
                                    </div> -->
                            </div>
                        </div><!--left_box-->';
                }
?>