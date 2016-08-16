<?php
                        if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                        die("<a href='../index.php'>Trang ch&#7911;</a>");
                        }
                        if($Auth["memberid"] < 1){
                                header("Location: /login.html");
                                exit;
                        }
                        
                        $code_invalid = FALSE;
                        $msg = "";
                        $method = "";
                        
                        if(isset($_GET["Webdesign"]) && isset($_GET["method"]) && $_GET["Webdesign"]=="sendTo"){
                            $method = $_GET["method"];
                        }
                        
                        if($_SERVER['REQUEST_METHOD']=='POST'){
                                    $money = $_POST["money"];        
                                    $method = $_POST["method"];
                                    $phone = $_POST["phone"];
                                    if(empty($_SESSION['code'] ) ||
                                      strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                 $code_invalid = TRUE;
                                     }

                                       $money = (double)str_replace(".", "", $money);
                                       
                                       if(!$code_invalid && $money > 0){
                                                      for ($i = 0; $i < 4; $i++) 
                                                      {
                                                              $word_2 .= chr(rand(97, 122));
                                                      }
                                                     $maxacnhan = $method." ".$word_2;
                                                     $create_date = date("Y-m-d");
                                                     $sql = new db_sql();
                                                     $sql->db_connect();
                                                     $sql->db_select();
                                                       // sau khi gửi mã xác nhận tới điện thoại khác hàng thì thực hiện lưu yêu cầu và lịch sử giao dịch
                                                      $sSQL = "INSERT INTO  ".DB_PREFIX."list_request(`method`,`user_id` ,`publish`,`code_confirm` ,`createdate`)
                                                                        VALUES ('$method',   '$Auth[memberid]',  '0','$maxacnhan',  '$create_date') ";
                                                      if($sql->query($sSQL)){
                                                                         $select_id = "SELECT `id` FROM `kien_list_request` WHERE `method` = '".$method."' and `user_id` = '".$Auth[memberid]."' 
                                                                                                 and  `createdate` = '".$create_date."' and `code_confirm` = '".$maxacnhan."' and `publish` = '0' limit 1";
                                                                         $sql->query($select_id);
                                                                         if($r = $sql->fetch_array()){
                                                                             $tem_id = $r["id"];
                                                                         }
                                                                         if(!empty($tem_id)){
                                                                                    $sSQL_insert = "INSERT INTO  ".DB_PREFIX."history_tranfer(`tranto` ,`money` ,`request_id`)
                                                                                                      VALUES ('$phone','$money','$tem_id') ";
                                                                                    if($sql->query($sSQL_insert)){
                                                                                                 unset($tem_id,$money,$maxacnhan);
                                                                                                 $msg = "ok";
                                                                                    }
                                                                         }else{
                                                                             $msg = "Gửi yêu cầu không thành công";
                                                                         }

                                                     }

                                       }else if($code_invalid){
                                           $msg = "Mã bảo chưa đúng";
                                       }else if($money < 0){
                                           $msg = "Không nhập số tiền âm";
                                       }
                        }

                        function publish(){
                            global $msg,$method;  
                            echo '<div class="left_box_slide">
                                                    <div class="title"><h3>Yêu cầu chuyển khoản</h3></div>
                                                    <div class="content">';
                                                    if($msg=="ok"){
                                                        echo '<p style="color: blue">Gửi yêu cầu thành công<p>';
                                                    }else{
                                                        echo '<p style="color: red">'.$msg.'<p>';
                                                    }
                                                    echo '<form action="'.WEB_DOMAIN.'/sendTo.html" method="post">
                                                        <ul>
                                                                <li>
                                                                <p class="text">Số điện thoại người nhận <span>*</span></p>
                                                                <p class="input"><input type="text" name="phone"  maxlength="15" value=""  id="phone_sendto"  placeholder="Số điện thoại người nhận"  /><div id="currentPhone" style="padding-left: 0px;color: red"></div></p>
                                                            </li>
                                                            <li>
                                                                <p class="text">Số tiền <span>*</span></p>
                                                                <p class="input"><input name="money"  type="text" maxlength="11" value="" id="MemberRequest_Money" data-target="money"  placeholder="Số tiền" /><span id="currentMoney" style="padding-left: 15px;"></span></p>
                                                            </li>
                                                            <li>
                                                                <p class="text">Mã xác nhận<span>*</span></p>
                                                                <p class="input"><input type="text" value="" placeholder="Mã xác nhận"  id="code" name="code" /></p>
                                                            </li>
                                                            <li>
                                                                <p class="text"></p>
                                                                <p class="input"><span class="img_capcha"><img  id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" alt="captcha" /></span>
                                                                    <span class="fresh"><img id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg" alt="Refresh captcha" /></span></p>
                                                            </li>
                                                            <li>
                                                                <p class="text"></p>
                                                                <p class="input"> <input type="hidden" value="'.$method.'" name="method">
                                                                    <input type="submit" value="Thực hiện" id="submit_send" /></p>
                                                            </li>
                                                        </ul>
                                                        </form>
                                                    </div>
                                    </div><!--left_box-->';
                        }

?>