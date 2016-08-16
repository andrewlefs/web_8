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
                        if($_SERVER['REQUEST_METHOD']=='POST'){
                                        $kieu = $_POST["kieu"];
                                        $money = $_POST["money"];
                                        $content = $_POST["content"];                                        
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

                                                         $maxacnhan = $kieu." ".$word_2;
                                                         $create_date = date("Y-m-d");
                                                         $sql = new db_sql();
                                                         $sql->db_connect();
                                                         $sql->db_select();
                                                           // sau khi gửi mã xác nhận tới điện thoại khác hàng thì thực hiện lưu yêu cầu và lịch sử giao dịch
                                                          $sSQL = "INSERT INTO  ".DB_PREFIX."list_request(`method`,`user_id` ,`publish`,`code_confirm` ,`createdate`)
                                                                            VALUES ('$kieu',   '$Auth[memberid]',  '0','$maxacnhan',  '$create_date') ";
                                                          if($sql->query($sSQL)){
                                                                             $select_id = "SELECT `id` FROM `kien_list_request` WHERE `method` = '".$kieu."' and `user_id` = '".$Auth[memberid]."' 
                                                                                                     and  `createdate` = '".$create_date."' and `code_confirm` = '".$maxacnhan."' and `publish` = '0' limit 1";
                                                                             $sql->query($select_id);
                                                                             if($r = $sql->fetch_array()){
                                                                                 $tem_id = $r["id"];
                                                                             }
                                                                             if(!empty($tem_id)){
                                                                                            $sSQL_insert = "INSERT INTO  ".DB_PREFIX."history_request(`money` ,`comment`,`request_id`)
                                                                                                              VALUES ('$money',  '$content', '$tem_id') ";
                                                                                            if($sql->query($sSQL_insert)){
                                                                                                unset($tem_id,$money,$content,$maxacnhan);
                                                                                                                   $msg = "Gửi yêu cầu thành công";
                                                                                            }
                                                                             }else{
                                                                                            $msg = "Giao dịch thất bại";
                                                                             }

                                                         }

                                        }else if($code_invalid){
                                            $msg = "Mã bảo chưa đúng";
                                        }else if($money < 0){
                                            $msg = "Không nhập số tiền âm";
                                        }


                        }

                        function publish(){
                                             global $money,$msg,$content;    
                                            echo '<div class="left_box_slide">
                                                            <div class="title"><h3>Thông tin yêu cầu</h3></div>
                                                            <div class="content">';                                                                           
                                                                             if($msg=="Gửi yêu cầu thành công"){
                                                                                 echo ' <p style="color: blue">'.$msg.'</p>';
                                                                             }else{
                                                                                  echo '<p style="color: red">'.$msg.'</p>';
                                                                             }
                                                                            echo '<form action="'.WEB_DOMAIN.'/request.html" method="post">
                                                                            <ul>
                                                                                            <li>
                                                                                                <p class="text">Chọn kiểu giao dịch<span>*</span></p>
                                                                                                <p class="input">
                                                                                                                 <select name="kieu">
                                                                                                                                <option value="naptien">Nạp tiền</option>
                                                                                                                                <option value="ruttien">Rút tiền</option>
                                                                                                                </select>
                                                                                                </p>
                                                                                            </li>
                                                                                            <li>
                                                                                                <p class="text">Số tiền <span>*</span></p>
                                                                                                <p class="input"><input name="money"  type="text" maxlength="11" value="'.$money.'" id="MemberRequest_Money" data-target="money"/> <span id="currentMoney"></span><br /></p>
                                                                                            </li>
                                                                                            <li>
                                                                                                <p class="text">Nội dung<span>*</span></p>
                                                                                                <p class="input"><textarea style="min-height:100px; max-width:450px; min-width:450px">'.$content.'</textarea></p>
                                                                                            </li>
                                                                                            <li>
                                                                                                <p class="text">Mã xác nhận<span>*</span></p>
                                                                                                <p class="input"><input type="text" id="code" name="code"  value="" placeholder="Mã xác nhận" /></p>
                                                                                            </li>
                                                                                            <li>
                                                                                                <p class="text"></p>
                                                                                                <p class="input"><span class="img_capcha"><img  id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" /></span><span class="fresh"><img  id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg" /></span></p>
                                                                                            </li>
                                                                                            <li>
                                                                                                <p class="text"></p>
                                                                                                <p class="input"><input type="submit" value="Cập nhật" /></p>
                                                                                            </li>
                                                                            </ul>
                                                            </div>
                                         </div><!--left_box-->';
                        }
                  
?>