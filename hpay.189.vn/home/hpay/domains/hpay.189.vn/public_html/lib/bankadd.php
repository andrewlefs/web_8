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
              
                $msg = "";
                $msg1 = "";

                if($_POST["pages"]=="bankadd" && $_POST["action"]=="add"){
                                    $id_bank                                 = $_POST["bank"];
                                    $account_number                 = $_POST["account_number"];
                                    $anh_mattruoc                       = isset($_FILES["mattruoc"]["name"]) 	? $_FILES["mattruoc"]["name"]: '';
                                    $anh_matsau                          =  isset($_FILES["matsau"]["name"]) 	? $_FILES["matsau"]["name"]: '';
                                    $phone                                    = $_POST["phone_number"];
                                    
                                   if(empty($_SESSION['code'] ) ||
                                        strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                    $msg = "Mã bảo vệ chưa đúng ";
                                    }

                                    if($id_bank==0){
                                        $msg = "Bạn chưa chọn ngân hàng";
                                    }
                                    if(empty($account_number)){
                                        $msg = "Bạn chưa nhập số tài khoản ngân hàng";
                                    }
                                    
                                    if($id_bank!=0 && $account_number!=""){
                                                  $sSQL = "SELECT count(*) as total
                                                        FROM ".DB_PREFIX."user_bank   WHERE  bankid='".$id_bank."' and bank_number='".$account_number."' ";
                                                        $sql->query($sSQL);
                                                        $total = $sql->fetch_array();
                                                        if($total["total"] > 0)
                                                               $msg = "Tài khoản ngân hàng này đã được sử dụng";
                                    }
                                    
                                    if(empty($phone)){
                                        $msg = "Bạn chưa nhập số điện thoại";
                                    }else{
                                            $sSQL = "SELECT count(*) as total
                                                        FROM ".DB_PREFIX."member   WHERE  user='".$phone."' ";
                                            $sql->query($sSQL);
                                            $total = $sql->fetch_array();
                                            if($total["total"]!=1)
                                                   $msg = "Số điện thoại này chưa đúng";
                                    }
                                    if(empty($anh_mattruoc)){
                                        $msg = "Bạn chưa nhập ảnh mặt trước chứng minh thư <br />";
                                    }
                                    if(empty($anh_matsau)){
                                        $msg = "Bạn chưa nhập ảnh mặt sau chứng minh thư <br />";
                                    }

                                    if(empty($msg)){
                                        // upload hình ảnh chứng minh thư lên server
                                                if ( !empty($anh_mattruoc)){
                                                                    $filename = "";
                                                                    $start = strpos($anh_mattruoc,".");
                                                                    $type  = substr($anh_mattruoc,$start,strlen($anh_mattruoc));
                                                                    if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
                                                                            $message1 = "Tệp ảnh phải có kiểu tệp là .jpg hoặc .gif";             
                                                                     }
                                                                    else{
                                                                                    if($message1==""){
                                                                                                            $filename = time().$type;
                                                                                                            if (!copy($_FILES['mattruoc']['tmp_name'], "./uploads/imgother/thumb/".$filename)) die ("Cannot upload file.");
                                                                                                            thumb($_FILES['mattruoc']['tmp_name'], './uploads/imgother/'.$filename, $ratio_image_width, $ratio_image_width, false);
                                                                                         }
                                                                    }
                                                 }

                                                 if ( !empty($anh_matsau)){
                                                                    $filename1 = "";
                                                                    $start = strpos($anh_matsau,".");
                                                                    $type  = substr($anh_matsau,$start,strlen($anh_matsau));
                                                                    if ((strtolower($type)!=".gif")&&(strtolower($type)!=".jpg")){
                                                                            $message1 = "Tệp ảnh phải có kiểu tệp là .jpg hoặc .gif";             
                                                                                                                            }
                                                                    else{
                                                                                if($message1==""){
                                                                                                        $filename1 = time().$type;
                                                                                                        if (!copy($_FILES['matsau']['tmp_name'], "./uploads/imgother/thumb/".$filename1)) die ("Cannot upload file.");
                                                                                                        thumb($_FILES['matsau']['tmp_name'], './uploads/imgother/'.$filename1, $ratio_image_width, $ratio_image_width, false);
                                                                                     }
                                                                    }
                                               }

                                               $use = $Auth["memberid"];

                                               $insert_query = "INSERT INTO  ".DB_PREFIX."user_bank(`userid` ,`bankid` ,`bank_number`,`mattruoc`,`matsau`,`publish`) 
                                                   VALUES ( '$use',  '$id_bank',  '$account_number','$filename','$filename1','0')";                                            
                                             if($sql->query($insert_query)){
                                                    $msg = "ok";
                                                    unset($use,$id_bank,$account_number,$filename,$filename1);
                                                    $sql->close();
                                                }
                                                   
                                    }                                    
                                       
                }
                function publish(){
                        global $bank,$account_number,$anh_matsau,$anh_mattruoc,$phone,$msg; 
                         echo '
                <div class="left_box_slide">
                	<div class="title"><h3>Thông tin đăng ký tài khoản ngân hàng</h3></div>
                    <div class="content">
                            <div class="error_message">';
                                        if($msg !="ok"){
                                        echo '<h2 style="color: red">'.$msg.'</h2>';
                                        }else{
                                                echo '<h2 style="color: blue">Thêm thành công! Tài khoản của bản sẽ được chúng tôi  kiểm tra và gửi thông tin click hoạt tới số điện thoại của bạn trong vòng 7 ngày</h2>';
                                                }
                            echo '</div>
                            <form action="'.WEB_DOMAIN.'/add-bank.html" method="post" enctype="multipart/form-data">
                                    <ul>
                                                        <li>
                                                        <p class="text">Chọn ngân hàng <span>*</span></p>
                                                        <p class="input">
                                                                     <select name="bank" id="bank">
                                                                                <option value="0">-- Chọn ngân hàng --</option>';
                                                                                for($i=1;$i<=count($bank);$i++){
                                                                                    echo '<option value="'.$bank[$i]["id"].'">'.$bank[$i]["title"].'</option>';
                                                                                }
                                                                    echo '</select>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p class="text">Số tài khoản <span>*</span></p>
                                                        <p class="input">
                                                                        <input name="account_number" type="text" maxlength="100" value="'.$account_number.'" />
                                                        </p>
                                                    </li>                           
                                                    <li>
                                                        <p class="text">Số điện thoại <span>*</span></p>
                                                        <p class="input"><input id="test" name="phone_number" type="text" maxlength="100" value="'.$phone.'" title="Số điện thoại đăng ký sms banking phải trùng với số điện thoại đăng ký Hpay của bạn" /></p>
                                                    </li>
                                                     <li>
                                                        <p class="text">Ảnh mặt trước chứng minh thư  nhân dân<span>*</span></p>
                                                        <p class="input">
                                                                   <input id="matruoc" name="mattruoc" type="file"  value="'.$anh_mattruoc.'" />
                                                        </p>
                                                    </li>
                                                   <li>
                                                        <p class="text">Ảnh mặt sau chứng minh thư  nhân dân<span>*</span></p>
                                                        <p class="input">
                                                                   <input id="matsau" name="matsau" type="file"  value="'.$anh_matsau.'" />
                                                        </p>
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
                                                        <p class="input">
                                                         <input type="hidden"  value="add" name="action" />
                                                                      <input type="hidden"  value="bankadd" name="pages" />
                                                                      <input type="submit"  value="Đăng ký" />
                                                                     <!-- <input type="submit"  value="Đăng ký" disabled="disabled" id="sm"/>     -->                                                                              

                                                    </li>
                                           </ul>
                                </form>
                    </div>
                </div><!--left_box-->';
                }

?>