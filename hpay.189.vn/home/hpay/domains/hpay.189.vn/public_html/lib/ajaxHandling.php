<?php
            define("qaz_wsxedc_qazxc0FD_123K",true);            
            session_start();
            $phpbb_root_path = '../config/';
            include($phpbb_root_path."mysql.php");
            include($phpbb_root_path."config.php");        
            include($phpbb_root_path."function.php");
            include($phpbb_root_path."global.php");
           include("../extsource/nusaop/nusoap.php");
                   
             
                function getDirectTransDetail($valiable_login,$username,$requestID,$token){
                                $param = array(
                                                            'username' => $username, // user name đăng nhập hệ thống
                                                            'requestID' => $requestID,// mã ngẫu nhiên
                                                            'token' => $token  // sinh ra sau khi đăng nhập thành công
                                                        ); 
                                return $valiable_login->call("getDirectTransDetail",$param);
                }

                function queryBalance($valiable_login,$username,$requestID,$token){
                                    $param = array(
                                                            'username' => $username, // user name đăng nhập hệ thống
                                                            'requestID' => $requestID,// mã ngẫu nhiên
                                                            'token' => $token  // sinh ra sau khi đăng nhập thành công
                                                        ); 
                                      return $valiable_login->call("queryBalance",$param);
                }

                function partnerChangePassword($valiable_login,$username,$oldPassword,$newPassword,$token){
                                  $param = array(
                                                            'username' => $username,
                                                            'oldPassword' => $oldPassword, // user name đăng nhập hệ thống
                                                            'newPassword' => $newPassword,// mã ngẫu nhiên
                                                            'token' => $token  // sinh ra sau khi đăng nhập thành công
                                                        ); 
                                 return  $valiable_login->call("partnerChangePassword",$param);
                }
              
            $fun = $_POST["func"];
            switch ($fun){
                case "total":
                    total();
                    break;   
                case "checklogin":
                    checklogin();
                    break;  
                  case "add_money_banking":
                    add_money_banking();
                    break;  
                  case "check_phone_sendto":
                    check_phone_sendto();
                    break;  
                  case "buy_card_code":
                    buy_card_code();
                    break;  
            }
            
            // function mua thẻ trực tiếp trên hệ thống bằng cách  lấy mã thẻ về mail hoặc điện thoại
            function buy_card_code() {
                           $sql = new db_sql();
                           $sql->db_connect();
                           $sql->db_select();
                           $ip = getIp();
                            $result_message = "";
                            $memberid = $_POST["sessionValue"]; // user mua thẻ
                            if($memberid > 1){
                            $product_id = $_POST["product_id"];// loại thẻ
                            $qty = $_POST["qty"];//số lượng
                            $typereturn = $_POST["typereturn"];// hình thức trả thẻ(qua mail hoặc tinh nhắn)
                            $payType = $_POST["paytype"];// hình thức thanh toán
                            $create_date = date("Y-m-d");
                            if($product_id>0 && $qty>0){
                                        // tính giá triết khấu
                                        //taọ giao dịch (tạo liist_request)
                                               // mã xác nhận ngẫu nhiên 
                                            $confirm_code = '';
                                            $md5_hash = md5(rand(0,999)); 
                                            $confirm_code = substr($md5_hash, 15, 5); 
                                           
                            
                                            // chek xem có đủ tiền mua thẻ hay không
                                                //kiểm tra số lượng thẻ và kiểu thẻ
                                        $num = is_numeric($qty)?$qty:0;
                                        $seletc = "select gia from ".DB_PREFIX."product where id_product=$product_id";
                                        $sql->query($seletc);
                                        if($r = $sql->fetch_array()){
                                            $price = doubleval($r["gia"]);                                                                
                                        }

                                        $tongtien = $price * $num;                            
                                        $select = "select Gold from ".DB_PREFIX."member where memberid=$memberid";
                                        $sql->query($select);
                                        if($tem = $sql->fetch_array()){
                                                $gold = $tem["Gold"];
                                        }
                                               //tính tiền hoa hồng và tạo giao dịch 
                                           /* chưa thực hiện
                                            $packagebonus = PackageBonus::model()->find('package_id='.$member->package_id.' and name ="'.$provider->name.'"');       
                                            $price = $product->price;
                                            $qty=1;
                                            $tien_bonus =$packagebonus->value*$price/100;
                                            $pricelevel1 = 0;
                                            $price_off = $price-$tien_bonus;
                                            */
                                             // mã xác nhận ngẫu nhiên 
                                            $confirm_code = '';
                                            $md5_hash = md5(rand(0,999)); 
                                            $confirm_code = substr($md5_hash, 15, 25); 
                                            $insert_tran = "INSERT INTO  ".DB_PREFIX."transaction  (`payId` ,`member_id` ,`product_id` ,`qty` ,`created` ,`status` ,`is_topup` ,`downloaded` ,`ip_download` ,`confirm_code`)VALUES ( '-1',  '".$memberid."',  '".$product_id."',  '".$qty."',  '".$create_date."',  '0',  '1', '0','".$ip."','".$confirm_code."')";
                                            $sql->query($insert_tran);                          
                                            
                                        if($gold < $tongtien){
                                                  $result_message = '<h2 style="text-align:center; color:red;">Không đủ tiền mua thẻ<h2>';
                                        }else{
                                                      // tao giao dich thanh cong lay ma giao dich
                                                $select_id_tran = "SELECT id FROM ".DB_PREFIX."transaction  where confirm_code='".$confirm_code."' and `member_id`='".$memberid."' and `ip_download`='".$ip."' limit 1";
                                                $sql->query($select_id_tran);
                                                if($t = $sql->fetch_array()){
                                                           $id_tran = $t["id"];
                                                }
                                             
                                                 //  đăng nhập hệ thống services
                                                $newService = new nusoap_client('http://itopup-test.megapay.net.vn:8086/ItopupService1.4/services/TopupInterface?wsdl',true); 
                                                $user_megapay ="hoanggia1";
                                                $pass_megapay = "123!@#$";
                                                $keyBirthdayTime = '2013/12/18 16:36:16.040'; 
                                               $key = "2770403f86a5f3828b18233b";


                                                $param = array('username'=>$user_megapay, 'password'=> $pass_megapay); 
                                                $result_login = $newService->call('signInAsPartner', $param);               

                                                $errorCode = "";
                                                $errorMessage = "";
                                                $token = "";

                                                 if ($result_login != null){
                                                                $errorCode = $result_login["errorCode"];
                                                                $errorMessage = $result_login["errorMessage"];
                                                                if (($errorCode == -3) || ($errorCode == 0)){
                                                                        $token = $result_login["token"];
                                                                }
                                                                else{
                                                                        $token = "";
                                                                }
                                                  }else{
                                                                $errorCode = -1;
                                                                $errorMessage = "Not connect VNPT EPAY WS";
                                                                $token = "";
                                                  }            
//                                                  print_r("errorCode: ".$errorCode."<br />");
//                                                  print_r("errorMessage".$errorMessage."<br />");
//                                                  print_r("token: ".$token."<br />");

                                              //      $qty_test = 2;
                                            //        $product_id_teest = 1;// mã cua viettel 10000
                                                  // lay thong tin ma the trong danh sach services
                                                  $select_product_code = "select code_pro from ".DB_PREFIX."product where id_product='".$product_id." limit 1'";
                                                  $sql->query($select_product_code);
                                                  if($tem_code = $sql->fetch_array()){
                                                        $code_pro = $tem_code["code_pro"];
                                                  }
                                                                        // khởi tạo các giá trị thể thiết lập tới server
                                                                    $requestID  = generateRandomRequestID();        
                                                                       $listItems = array(array(
                                                                        'productId'=>$code_pro,
                                                                        'quantity'=>$qty
                                                                     ));
                                                                       
                                                                      $param_down = array(
                                                                            'username' => $user_megapay, 
                                                                            'requestID' => $requestID,
                                                                            'token' => $token,
                                                                            'keyBirthdayTime' => $keyBirthdayTime,
                                                                            'buyItems' => $listItems); 

                                                                    $re_param_down = array(
                                                                               'username' => $user_megapay, 
                                                                               'requestId' => $requestID,
                                                                               'keyBirthdayTime' => $keyBirthdayTime,
                                                                               'token' => $token);
                                                  
                                                                    $result_services = $newService->call('partnerDownloadSoftpinV10', $param_down);
                                                                   
                                                                    while(empty($result_services)){
                                                                        $result_services = $newService->call('partnerRedownloadSoftpin', $re_param_down);        
                                                                    }
                                                                    if($result_services['errorCode'] !=0){    // nếu ko có lỗi sảy ra 
                                                                                        $result_message =  '<h2 style="text-align:center; color:red;">'.$result_services['errorMessage'].'</h2>';
                                                                    }  else {
//                                                                                     echo 'ket qủa doownload____________________<br />';
//                                                                 
//                                                                    print_r("Mã giao dịch epay trả về: ".$result_services["epayTransID"]."<br />");
//                                                                    print_r("Mã lỗi : ".$result_services["errorCode"]."<br />");
//                                                                    print_r("Thông báo lỗi: ".$result_services["errorMessage"]."<br />");
//                                                                    print_r("Tài khoản đối tác: ".$result_services["merchantBalance"]."<br />");
//                                                                    print_r("Tên nhóm sản phẩm: ".$result_services["products"][0]["categoryName"]."<br />");
//                                                                    print_r("Chiếu khấu: ".$result_services["products"][0]["commission"]."<br />");
//                                                                    print_r("Mã sản phẩm: ".$result_services["products"][0]["productId"]."<br />");
//                                                                    print_r("Giá trị  sản phẩm: ".$result_services["products"][0]["productValue"]."<br />");
//                                                                    print_r("Tên nhà cung cấp: ".$result_services["products"][0]["serviceProviderName"]."<br />");
//                                                                    print_r("Hạn sử dụng: ".$result_services["products"][0]["softpins"]["expiryDate"]."<br />");
//                                                                
                                                                    $tem_a = array();
                                                                    for($i=0;$i<count($result_services['products'][0]['softpins']);$i++){
                                                                                    $tem_a[$i]["expiryDate"] = $result_services['products'][0]['softpins'][$i]["expiryDate"];
                                                                                    $tem_a[$i]["softpinPinCode"] = $result_services['products'][0]['softpins'][$i]["softpinPinCode"];
                                                                                    $tem_a[$i]["softpinSerial"] = $result_services['products'][0]['softpins'][$i]["softpinSerial"];
                                                                    }
                                                                     
//                                                                    for($i=0;$i<count($tem_a);$i++){
//                                                                                    print_r("Mã pin dạng mã hóa thứ ".($i+1)." : ".$tem_a[$i]["softpinPinCode"]."<br />");
//                                                                                     print_r("Mã pin dạng giải  mã hóa thứ ".($i+1)." : ".deCrypt($tem_a[$i]["softpinPinCode"],$key)."<br />");
//                                                                                    print_r("Serial thứ  ".($i+1)." : ".$tem_a[$i]["softpinSerial"]."<br />");
//                                                                                    print_r("Hạn sử dụng thứ  ".($i+1)." : " .$tem_a[$i]["expiryDate"]."<br />");
//                                                                    }
                                                                   
                                                                   // insert ma the tra ve tu services
                                                                       for($i=0;$i<count($tem_a);$i++){
                                                                                    $insert_softpin = "INSERT INTO  ".DB_PREFIX."his_download_softpin (`transaction_id` ,`softpinPinCode` ,`softpinSerial` ,`product_id` ,`expiryDate` ,`member_id` ,`created`)
                                                                                                    VALUES ('".$id_tran."',  '".$tem_a[$i]["softpinPinCode"]."',  '".$tem_a[$i]["softpinSerial"]."',  '".$product_id."',  '" .$tem_a[$i]["expiryDate"]."',  '".$memberid."',  '".$create_date."')";
                                                                                    $sql->query($insert_softpin);
                                                                       }
                                                                        // tru tien trong tai khoan thanh vien                        
                                                                            $tem = $gold - $tongtien;
                                                                            $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' where memberid=$memberid";
                                                                            $sql->query($update_money);
                                                                            // cập nhật trang thái giao dịch
                                                                            $update = "update ".DB_PREFIX."transaction set `requestID`='".$requestID."' ,status='1',downloaded='1',payId='".$result_services["epayTransID"]."'  where id='".$id_tran."' ";
                                                                             $sql->query($update);

                                                                    $str="";
                                                                 for($i=0;$i<count($tem_a);$i++){
                                                                      $str .='Mã thẻ thứ '.($i+1).' : '.deCrypt($tem_a[$i]["softpinPinCode"],$key).'  || Serial thứ '.($i+1).' : '.$tem_a[$i]["softpinSerial"].'<br />';
                                                                  }
                                                                // sau khi lấy danh sách thẻ thực hiện gui mail cho khach hàng
                                                                // lay thong tin email
                                                                $select = "select user,email,fullname from ".DB_PREFIX."member where memberid=$memberid";
                                                                $sql->query($select);
                                                                if($r = $sql->fetch_array()){
                                                                    $user = $r["user"];
                                                                        $email = $r["email"];
                                                                        $fullname  = $r["fullname"];
                                                                }

                                                                        if($typereturn==1){
                                                                             ob_start();
                                                                                               $mail_content = ob_get_contents();
                                                                                               require_once '../extsource/phpmailer/class.phpmailer.php';
                                                                                               $mail  = new PHPMailer();
                                                                                               // nội dung mail 
                                                                                               $body="\r\n"; 
                                                                                               $body.= $str; 
                                                                                               $body       = eregi_replace("[\]",'',$body);
                                                                                               $mail->IsSMTP(); 
                                                                                               $mail->SMTPAuth   = true;                
                                                                                               $mail->SMTPSecure = "ssl";                 
                                                                                               $mail->Host       = "smtp.gmail.com";      
                                                                                               $mail->Port       = 465;                 
                                                                                               $mail->Username   = "kienlv@hoanggia.biz";  
                                                                                               $mail->Password   = "giadinhlatatca@123";          
                                                                                               $mail->SetFrom($email,$fullname);                                                                          
                                                                                               $mail->Subject    = "Thông tin xác nhận website hpay.189.vn";
                                                                                               $mail->CharSet = "utf-8";
                                                                                               $mail->MsgHTML($body);
                                                                                               $address = $email;
                                                                                             //   $address = "iwcofms@gmail.com";
                                                                                               $mail->AddAddress($address ,$fullname);
                                                                                    //           $mail->AddBCC($address,  $fullname);
                                                                                               $mail->Send();    
                                                                                              $result_message =  '<h2 style="text-align:center; color:blue;">Thông tin mã thẻ đã được gửi tới mail của quý khách ! Quý khác vui lòng đăng nhập mail để nhận mã thẻ</h2>';
                                                                         }else if($typereturn==2){
                                                                                $str="";
                                                                                for($i=0;$i<count($tem_a);$i++){
                                                                                     $str .= 'pin '.($i+1).' : '.deCrypt($tem_a[$i]["softpinPinCode"],$key).' Serial  '.($i+1).' : '.$tem_a[$i]["softpinSerial"].'';
                                                                                 }
                                                                             // thực hiện gửi mã tới số điện thoại
                                                                             sentsmss("",$str);
                                                                             $result_message =  '<h2 style="text-align:center; color:blue;">Thông tin mã thẻ đã được gửi tới số điện thoại của quý khách ! Quý khác vui lòng đăng nhập mail để nhận mã thẻ</h2>';
                                                                         }
                                                            }
                                     }
                          }else{
                              $result_message =  '<h2 style="text-align:center; color:red;">Có lỗi xảy ra</h2>';
                          }
                          
                          }  else {
                                 $result_message =  '<h2 style="text-align:center; color:red;">Bạn phải đăng nhập để mua thẻ</h2>';
                          }
                            
                            echo $result_message;
            }                     
            
            // function kiểm tra số điện thoại chuyển khoản có trong database không
            function check_phone_sendto(){
                $thongbao ="";
                  $sessionValue = $_POST["sessionValue"];
                  $phone = $_POST["phone_sendto"];
                  
                  if($phone=="" || preg_match("/([a-z])+$/",$phone)){
                            $thongbao =  'Số điện thoại không được để trống và không chứa ký tự';
                  }
                  if($sessionValue==$phone){
                             $thongbao =  'Bạn không được chuyển khoản cho chính bạn! Mời nhập số điện thoai khác';
                   }
                  if($thongbao =="") {
                           $sql = new db_sql();
                           $sql->db_connect();
                           $sql->db_select();
                           $select = "select user  from ".DB_PREFIX."member where user='".$phone."' and memberid != '".$sessionValue."' ";
                           $sql->query($select);
                           $r = $sql->num_rows();
                           if($r >=1){
                               $thongbao ="";
                           }else{
                               $thongbao = 'Số điện thoại này không tồn tại trên hệ thống mời bạn chọn số khác ';
                           }
                           
                }
                 if($thongbao !=""){
                     $thongbao .= '<script type="text/javascript">$("#phone_sendto").focus();                               
                                 </script>';
                     }
                         
                 echo $thongbao;
           }
            function total(){
                                                $id_pr = $_POST["product_id"];
                                                $num_card = $_POST["num_card"];
                                                $sql = new db_sql();
                                                $sql->db_connect();
                                                $sql->db_select();
                                                $select = "select gia from ".DB_PREFIX."product where id_product='".$id_pr."' limit 1";
                                                $sql->query($select);
                                                if($r = $sql->fetch_array()){
                                                            $tem = $r["gia"];
                                                }
                                                $total = $tem*$num_card;
                                                echo ' <p>Tổng tiền:</p>
                                                            <p class="price">'.$num_card.'<span>x</span>'.number_format($tem,0).' VNĐ=<span class="corl">'.  number_format($total,0).' VNĐ</span></p>';
           }
           
           
           function checklogin(){
                                            $username_invalid 	= false;
                                           $password_invalid 	= false;
                                            $uuser = $_POST["username"];
                                            $paass = $_POST["pwr"];
                                            $mahoa = md5($paass);     
                                            $Auth_login = array();
                                            $msg = "";
                                            if(!eregi('^[a-zA-Z0-9_]+$',$uuser))
		$username_invalid = true;
                                            if($uuser=='' || strlen($uuser) < 4)
                                                      $username_invalid = true;
                                            if($paass=='' || strlen($paass) < 6)
		$password_invalid = true;
                                            
                                            if(!$username_invalid && !$password_invalid) {
                                                            $sql = new db_sql();
                                                            $sql->db_connect();
                                                            $sql->db_select();
                                                            $sSQL = "SELECT memberid, user, cmt, fullname, id_loaivi,email,Gold, signdate  from ".DB_PREFIX."member WHERE  pass='".$mahoa."' and  user='".$uuser."' and Published='1' ";
                                                            $sql->query($sSQL);
                                                            $count = $sql->num_rows();
                                                            if($count >= 1){
                                                                    if($row = $sql->fetch_array()){
                                                                                $Auth_login["memberid"]                                    = $row["memberid"];
                                                                                $Auth_login["user"]                                             = $row["user"];
                                                                                $Auth_login["fullname"]                                     = $row["fullname"];                                   
                                                                                $Auth_login["cmt"]                                              = $row["cmt"];
                                                                                $Auth_login["id_loaivi"]                                     = $row["id_loaivi"];
                                                                                $Auth_login["email"] 	                          = $row["email"];
                                                                                $Auth_login["signdate"] 	                          = $row["signdate"];                                                                        
                                                                    }
                                                                        $sql->close();
                                                                        $msg = $Auth_login;
                                                            }else{
                                                                        $msg =  "Thành viên này không tồn tại";
                                                            }
                                            }else if($password_invalid){
		$msg='Vui lòng nhập Mật khẩu chính xác';
                                            }
                                            else if($username_invalid){
                                                    $msg='Vui lòng nhập Tên đăng nhập chính xác';
                                           }                                          
                           echo $msg;
           }
           
           function  add_money_banking(){
                            $sotien_invaild                                                                                         = FALSE;
                            $nganhang_invaild                                                                                  = FALSE;
                            $check_user_bank                                                                                   = FALSE;
                            $code_invalid                                                                                           = FALSE;
                            $msg =  '';
                            $msg1 =  '';
                             $sessionValue = $_POST["sessionValue"];
                           
                          $method = $_POST["method"];
                           $nganhang_id  = $_POST["nganhang"];
                            $number_money = $_POST["number_money"];
                           $CreateDate = date("Y-m-d");
                           $ip = getIp();
                           if($method=="add_money_banking"){
                                                     $sql = new db_sql();
                                                            $sql->db_connect();
                                                            $sql->db_select();
                                                     $number_money = (double)str_replace(".", "", $number_money);
		if($nganhang_id==0 ){
                                                                       $nganhang_invaild = true;
                                                     } 
                                                     
                                                     if($number_money=="" || $number_money < 0 ){
                                                                       $sotien_invaild = true;
                                                     }  
                                                      // check xem user thực hiện giao dịch đã đăng ký tài khoản ngân hàng này hay chưa
                                                     $select = "SELECT `id`, `userid`, `bankid`, `bank_number` FROM ".DB_PREFIX."user_bank WHERE `userid` =$sessionValue  and `bankid` = $nganhang_id and `publish` = 1";
                                                     $sql->query($select);
                                                     $total = $sql->num_rows();
                                                     if($total != 1 ){
                                                         $check_user_bank = true;
                                                     } 
                                                     
                                                     if($r = $sql->fetch_array()){
                                                             $number_card_bank = $r["bank_number"];
                                                     }
                                                    
                                                    
                                                     if(empty($_SESSION['code'] ) ||
                                                        strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                                   $code_invalid = TRUE;
                                                     }
                                                     if(!$nganhang_invaild && !$sotien_invaild  && !$code_invalid && !$check_user_bank) {
                                                                                $select =" SELECT `user`, `fullname` FROM ".DB_PREFIX."member WHERE `memberid`= $sessionValue limit 1";
                                                                                $sql->query($select);
                                                                                if($r = $sql->fetch_array()){
                                                                                    $user_add_bank = $r["user"];
                                                                                    $fullname_add_bank = $r["fullname"];
                                                                                }
                                                                                // nếu tất cả thông tin đúng tự động sinh mã ngẫu nhiên để gửi tới điện thoại người dùng xác thực
                                                                             
                                                                                for ($i = 0; $i < 4; $i++) 
                                                                                {
                                                                                        $word_2 .= chr(rand(97, 122));
                                                                                }
                                                                                // gửi mã này tới điện thoại của khách
                                                                                sentsmss("",$word_2);
                                                                                
                                                                                // sau khi gửi mã xác nhận tới điện thoại khác hàng thì thực hiện lưu yêu cầu và lịch sử giao dịch
                                                                                $sSQL = "INSERT INTO  ".DB_PREFIX."list_request(`method`,`user_id` ,`publish`,`code_confirm` ,`createdate` ,`IP`)
                                                                                                  VALUES ('$method',   '$sessionValue',  '0','$word_2',  '$CreateDate','$ip') ";
                                                                                // nếu insert vào yêu cầu thành công thực hiện lấy mã yêu cầu insert các thông tin còn lại vào bảng history
                                                                                if($sql->query($sSQL)){
                                                                                            $select_id = "SELECT `id` FROM ".DB_PREFIX."list_request WHERE `method` = '".$method."' and `user_id` = '".$sessionValue."' 
                                                                                                                                      and  `createdate` = '".$CreateDate."' and `code_confirm` = '".$word_2."' and `publish` = '0' and IP='".$ip."'  limit 1";
                                                                                            $sql->query($select_id);
                                                                                            if($r = $sql->fetch_array()){
                                                                                                    $tem_id = $r["id"];
                                                                                                      $sSQL_inser  = "INSERT INTO  ".DB_PREFIX."history_addmoney_bank(`id_bank` ,`number_money`,`id_request`)
                                                                                                             VALUES ('$nganhang_id',  '$number_money', '$tem_id') ";
                                                                                                    if($sql->query($sSQL_inser)){
                                                                                                                 $msg1 = "Nạp tiền thành công";
                                                                                                  }   
                                                                                            }else{
                                                                                                $check_user = true;
                                                                                            }
                                                                                          
                                                                                }
                                                                                
		} else {
                                                                                if($nganhang_invaild)
				$msg = "Bạn chưa chọn ngân hàng";
			if($sotien_invaild)
				$msg = "Bạn chưa nhập số tiền";						
			if($code_invalid)
				$msg = "Mã bảo vệ chưa đúng";		
                                                                                if($check_user_bank)
				$msg = "Bạn chưa đăng ký tài khoản tại ngân hàng này";
                                                                                  if($check_user)
				$msg = $sSQL_inser;
			
		}
               
		$sql->close();        
            
                           }
                            if($msg1== "Nạp tiền thành công" && empty($msg)){
                                        echo '<div class="left">
                                                            <p class="lable" style="color: blue">'.$msg1.'</p>
                                                            <p class="lable">Tên chủ tài khoản ngân hàng  </p>
                                                            <p class="input">
                                                                        <input    type="text"  value="'.$fullname_add_bank.'"  disabled="disabled"/>
                                                            </p>
                                                            <p class="lable">Số tài khoản ngân hàng  </p>
                                                            <p class="input">
                                                                        <input    type="text"  value="'.$number_card_bank.'"  disabled="disabled"/>
                                                            </p>
                                                             <p class="lable">Số tiền muốn nạp</p>
                                                            <p class="input">
                                                                        <input    type="text"  value="'.  number_format($number_money,0).'"  disabled="disabled"/>
                                                            </p>
                                        </div>';
                            }else if(!empty ($msg) && empty ($msg1)){
                                        global $bank;
                                        echo '<div class="left">
                                                        <h2 style="color: red;">'.$msg.'</h2>
                                                        <form action="#">                                                                           
                                                                                <p class="lable">Chọn ngân hàng</p>
                                                                                    <p class="input">
                                                                                        <select name="bank_id" id="bank_id">
                                                                                                    <option value="0">-- Chọn ngân hàng --</option>';
                                                                                                    for($i=1;$i<=count($bank);$i++){
                                                                                                        echo '<option value="'.$bank[$i]["id"].'">'.$bank[$i]["title"].'</option>';
                                                                                                    }
                                                                                        echo '</select>
                                                                                    </p>
                                                                                    <p class="lable">Số tiền muốn nạp  <span>*</span><i style="font-size:12px; font-style:italic; color:#888">Chưa tính phí dịch vụ</i></p>
                                                                                    <p class="input">
                                                                                                <input   id="moneyadd" type="text" maxlength="11" value="'.$number_money.'" data-target="moneyadd" />
                                                                                    </p>
                                                                                    <p class="input" style="font-style:italic; color:#E74310; font-size:11px">
                                                                                       " Số tiền nạp phải nằm trong khoảng từ 10.000 vnđ đến 100.000.000 vnđ"
                                                                                    </p>
                                                                                    <p class="lable">Phí dịch vụ .........<span class="phi" style="">0%</span></p>
                                                                                    <p class="lable"  style="margin:10px 0px">Số tiền nhận được sau khi trừ phí dịch vụ .........</p>
                                                                                     <input  id="addmoney" type="text" maxlength="20" value="" disabled="disabled"/>
                                                                                    <p class="lable">Mã xác nhận<span>*</span></p>
                                                                                    <p class="input">
                                                                                            <input type="text" value="" placeholder="Mã xác nhận"  id="captcha-code" name="code" />
                                                                                    </p>
                                                                                    <p class="input">
                                                                                        <span class="img_capcha"><img  id="captcha"  alt="captcha" src="../extsource/get_captcha.php" alt="captcha" /></span>
                                                                                        <span class="fresh"><img id="captcha-refresh"  alt="Refresh captcha" src="../extsource/refresh.jpg" alt="Refresh captcha" /></span>
                                                                                    </p>
                                                                                    <div class="clear"></div>
                                                                                    <p class="note"><span>Chú ý:</span> Quý khách hàng vui lòng kiểm tra kĩ lại thông tin đã nhập “Ngân hàng,Số tiền muốn nạp..trước khi nhấp  Xác nhận”</p>                                                                                      
                                                                                    <input type="hidden" value="add_money_banking" id="method_add_bank">
                                                                                    <input type="button" value="Xác nhận" name="" onclick="check_add_money_bank()" />          
                                                                    </form>
                                        </div>';
                            }
           }
           
        
?>
