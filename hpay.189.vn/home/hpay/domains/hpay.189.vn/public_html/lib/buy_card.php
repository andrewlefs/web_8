<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>Home</a>");
                }
                
                
                 require_once('./extsource/nusaop/nusoap.php'); 
                 
                $type = "";
                $id_company = array(); 
                $product = array();               
                $sql = new db_sql();
                $sql->db_connect();
                $sql->db_select();
                $company_code = "";
                $logo ="";
                $companyname = "";
                $msg = "";
                 $ip = getIp(); 
                 $id_request = "";
                global  $company;
                
                if(isset($_GET["id_company"]) && $_GET["Webdesign"] == "buy_card")
                {
                                    $id_company = isset($_GET["id_company"]) && is_numeric($_GET["id_company"]) ? $_GET["id_company"] : 0;
                                    
                                    for($i=1; $i<=count($company); $i++){
                                            if($company[$i]["id_company"]==$id_company){
                                                    $companyname = $company[$i]["name"];
                                                    $logo = $company[$i]["logo"];
                                                    $company_code = $company[$i]["company_code"];
                                                    break;
                                            }
                                     }
                                     
                                     $select_type = "select type from ".DB_PREFIX."catalog where id_catalog in(select id_catalog from ".DB_PREFIX."company_catalog where id_company='".$id_company."')";
                                     $sql->query($select_type);
                                     if($r = $sql->fetch_array()){
                                                $type = $r["type"];
                                     }
                                     
                                     $select_pro = "select id_product,ten from ".DB_PREFIX."product where id_com_cat in(select id from ".DB_PREFIX."company_catalog where id_company='".$id_company."' )";
                                     $sql->query($select_pro);
                                     $i = 0;
                                     while ($row = $sql->fetch_array()){
                                                $i = $i + 1;
                                                $product[$i]["id_product"] = $row["id_product"];
                                                $product[$i]["ten"] = $row["ten"];
                                     }
                                    $title = array("buy_card" => $companyname , );
                 }
                 
                 if($_SERVER['REQUEST_METHOD']=='POST' && $_POST["method"]=="buycard"){                      
                                    //  đăng nhập hệ thống services
                                    $newService = new nusoap_client('http://itopup-test.megapay.net.vn:8086/ItopupService1.4/services/TopupInterface?wsdl',true); 
                                    $user_megapay ="hoanggia1";
                                    $pass_megapay = "123!@#$";
                                    
                                    $param = array('username'=>$user_megapay, 'password'=> $pass_megapay); 
                                    $result_login = $newService->call('signInAsPartner', $param);               
                                  
                                 //   $phone_test = "0932235947";                              
                                 //   $amount_test ="10000";// chính là giá tiền tương ứng với danh sách mã do nhà cung cấp cấp
                                 //   $game_tk_test = "epay_test";                     
                                   
                                    
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


                                         $id_product = $_POST['product'];// id san pham
                                         $payType =$_POST['payType'];// kieu thanh toan
                                         $member_id = $Auth["memberid"];// user mua the
                                         $get_phone = $_POST["mobile"]; // so dien thoai nhan the
                                        $game_tk = $_POST["game_tk"];// tai khhoan game
                                     //    $game_tk = "epay_test";
                                         
                                       //  lấy thông tin mã của sản phẩm và giá của sản phẩm
                                        $seletc = "select gia,code_pro  from ".DB_PREFIX."product where id_product=$id_product and publish='1' limit 1";
                                        $sql->query($seletc);
                                        if($r = $sql->fetch_array()){
                                            $price = doubleval($r["gia"]);   
                                            $code_pro = $r["code_pro"];
                                        }
                                        
                                        $select = "select Gold from ".DB_PREFIX."member where memberid=$member_id";
                                        $sql->query($select);
                                        if($tem = $sql->fetch_array()){
                                                $gold = $tem["Gold"];
                                        }                                    
                                        
                                           $create_date = date("Y-m-d");
                                           
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
                                            $insert_tran = "INSERT INTO  ".DB_PREFIX."transaction  (`payId` ,`member_id` ,`product_id` ,`qty` ,`created` ,`status` ,`is_topup` ,`downloaded` ,`ip_download` ,`confirm_code`)VALUES ( '-1',  '".$member_id."',  '".$id_product."',  '1',  '".$create_date."',  '0',  '1', '0','".$ip."','".$confirm_code."')";
                                            $sql->query($insert_tran);                                                    
                                              if($gold < $price){
                                                      $msg = '<h2 style="text-align:center; color:red;">Không đủ tiền mua thẻ<h2>';
                                              }   
                                              else{
                                                        if($get_phone !="" && $game_tk ==""){
                                                                                      // tao giao dich thanh cong lay ma giao dich
                                                                                    $select_id_tran = "SELECT id FROM ".DB_PREFIX."transaction  where confirm_code='".$confirm_code."' and `member_id`='".$member_id."' and `ip_download`='".$ip."' limit 1";
                                                                                    $sql->query($select_id_tran);
                                                                                    if($t = $sql->fetch_array()){
                                                                                               $id_tran = $t["id"];
                                                                                    }
                                                                                   $requestID  = generateRandomRequestID(); 
                                                                                    $param = array(
                                                                                                               'username' => $user_megapay, // user name đăng nhập hệ thống
                                                                                                               'requestID' => $requestID,// mã ngẫu nhiên
                                                                                                               'token' => $token,  // sinh ra sau khi đăng nhập thành công
                                                                                                               'targetAccount' => trim($get_phone),// số điện thoại cần nạp tiền phải đúng định dạng 09,01,....
                                                                                                               'amount' => $price); // số tiền
                                                                                    
                                                                                   $reesult =  $newService->call("partnerDirectTopupMobile",$param);
//                                                                                   echo '_________________________________________________<br />';
//                                                                                   print_r("Giá trị đầu ra thẻ điện thoại : <br />");
//                                                                                   print_r("Mã giao dịch epay trả về: ".$reesult["epayTransID"]."<br />");
//                                                                                   print_r("Mã lỗi: ".$reesult["errorCode"]."<br />");
//                                                                                   print_r("Thông báo trả về: : ".$reesult["errorMessage"]."<br />");
//                                                                                   print_r("Số dư còn lại: ".$reesult["merchantBalance"]."<br />");
//                                                                                   print_r("Mã đối tác: ".$reesult["merchantID"]."<br />");
//                                                                                   print_r("Số điện thoại nhận tiền: ".$get_phone."<br />");
//                                                                                   print_r("Mã giao dịch: ".$select_id_tran."<br />");
//                                                                                   print_r("RequesstID: ".$requestID."<br />");
//                                                                                   print_r("Mã giao dịch: ".$id_tran."<br />");
                                                                                   
                                                                                  if($reesult['errorCode']!=0){
                                                                                            $msg =  '<h2 style="text-align:center; color:red;">'.$reesult['errorMessage'].'<h2>';
                                                                                  }else{
                                                                                                                                                                           
                                                                                                                   // tru tien trong tai khoan thanh vien                        
                                                                                                                   $tem = $gold - $price;
                                                                                                                   $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' where memberid=$member_id";
                                                                                                                   $sql->query($update_money);
                                                                                                                   // cập nhật trang thái giao dịch
                                                                                                                   $update = "update ".DB_PREFIX."transaction set `requestID`='".$requestID."' ,status='1',downloaded='1',payId='".$reesult["epayTransID"]."',mobile='".$get_phone."' where id='".$id_tran."' ";
                                                                                                                    if($sql->query($update)){
                                                                                                                                     $msg =  '<h2 style="text-align:center; color:blue;">Nạp thẻ điện thoại thành công<h2>';      
                                                                                                                    }
                                                                                  }
                                                                            }else    if($game_tk !="" && $get_phone==""){    
                                                                                                            // get code_provider 
                                                                                                        $select_provider_code = "select company_code from ".DB_PREFIX."company where id_company in(select id_company from ".DB_PREFIX."company_catalog where id in (select id_com_cat from ".DB_PREFIX."product where id_product='".$id_product."')) limit 1";
                                                                                                        $sql->query($select_provider_code);
                                                                                                        if($s = $sql->fetch_array()){
                                                                                                            $provider_code = $s["company_code"];
                                                                                                        }
                                                                                                        
                                                                                                        $provider_test ="FPT";
//                                                                                                        if($provider_code != "FPT"){
//                                                                                                             $provider_test ="FPT";
//                                                                                                        }else{
//                                                                                                            $provider_test = $provider_code;
//                                                                                                        }
                                                                                                      // tao giao dich thanh cong lay ma giao dich
                                                                                                        $select_id_tran = "SELECT id FROM ".DB_PREFIX."transaction  where confirm_code='".$confirm_code."' and `member_id`='".$member_id."' and `ip_download`='".$ip."' limit 1";
                                                                                                        $sql->query($select_id_tran);
                                                                                                        if($t = $sql->fetch_array()){
                                                                                                                   $id_tran = $t["id"];
                                                                                                        }
                                                                                                        
                                                                                                        $requestID_test1  = generateRandomRequestID(); 
                                                                                                        $param = array(
                                                                                                                                   'username' => $user_megapay, // user name đăng nhập hệ thống
                                                                                                                                   'requestID' => $requestID_test1,// mã ngẫu nhiên
                                                                                                                                   'token' => $token,  // sinh ra sau khi đăng nhập thành công
                                                                                                                                   'targetAccount' => trim($game_tk),// tên tài khoản game
                                                                                                                                   'amount' => $price,
                                                                                                                                   'providerCode' => $provider_test); // mã nhà cung cấp game nằm trong danh sách
                                                                                                      $get_result = $newService->call("partnerDirectTopupGame",$param);
//                                                                                                      echo '_________________________________________________<br />';
//                                                                                                            print_r("Giá trị đầu ra thẻ game : <br />");
//                                                                                                            print_r("Mã giao dịch epay trả về: ".$get_result["epayTransID"]."<br />");
//                                                                                                            print_r("Mã lỗi: ".$get_result["errorCode"]."<br />");
//                                                                                                            print_r("Thông báo trả về: : ".$get_result["errorMessage"]."<br />");
//                                                                                                            print_r("Số dư còn lại: ".$get_result["merchantBalance"]."<br />");
//                                                                                                            print_r("Mã đối tác: ".$get_result["merchantID"]."<br />");
                                                                                                      if($get_result['errorCode']!=0){
                                                                                                                        $msg =  '<h2 style="text-align:center; color:red;">'.$get_result['errorMessage'].'<h2>';
                                                                                                       }else{
                                                                                                                            // tru tien trong tai khoan thanh vien                        
                                                                                                                   $tem = $gold - $price;
                                                                                                                   $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' where memberid=$member_id";
                                                                                                                   $sql->query($update_money);
                                                                                                                   // cập nhật trang thái giao dịch
                                                                                                                   $update = "update ".DB_PREFIX."transaction set `requestID`='".$requestID_test1."' ,status='1',downloaded='1',payId='".$reesult["epayTransID"]."',game_account='".$game_tk."' where id='".$id_tran."' and ip_download='".$ip."' and 'confirm_code'='".$confirm_code."' ";
                                                                                                                    if($sql->query($update)){
                                                                                                                                     $msg =  '<h2 style="text-align:center; color:blue;">Nạp game thành công<h2>';      
                                                                                                                    }
                                                                                                       }                                                                                                                                  
                                                                                   
                                                                                    }else if($get_phone !="" && $game_tk!=""){ 
                                                                                                           $msg =  '<h2 style="text-align:center; color:red;">Bạn chỉ được chọn một trong hai loại để nạp thẻ! Xin cảm ơn<h2>'; 
                                                                                    }
                                                                       }
                                                                     $sql->close();
                                  }
                                                                              
                                          
              function buycard(){
                  global  $companyname,$logo,$dir_imglogos1,$type,$product,$id_company,$msg;               
                  echo '<div class="thecao napthe">
                                                <div class="header_the">
                                                            <div class="left_hthe">
                                                                                <div class="title"><h3>Bạn đã chọn nhà mạng<span>'.$companyname.'</span></h3><a href="">Hướng dẫn giao dịch</a></div>
                                                                                <div id="tabContaier">
                                                                                            <ul>
                                                                                                <li class="active"><a alt="#tab1" class="icon1">Nạp thẻ trực tiếp</a></li>
                                                                                                <li><a alt="#tab2" class="icon2">Mua mã thẻ</a></li>
                                                                                            </ul>
                                                                               </div>
                                                            </div>
                                                            <div class="right_hthe"><img src="'.WEB_DOMAIN.$dir_imglogos1.$logo.'" alt="" /></div>
                                             </div><!--header_the-->
                                            <div class="clear"></div>
                                            <div class="content">
                                                                    <div class="box_nd">
                                                                                    <div id="tab1" class="tabContents">'.$msg .'
                                                                                                    <form action="'.WEB_DOMAIN.'/buy-card/'.  huu($companyname).'-'.$id_company.'"  method="post" onsubmit="return check_lg();">
                                                                                                                    <div class="left">
                                                                                                                                    <p class="lable">Mệnh giá thẻ nạp</p>
                                                                                                                                    <p class="input">
                                                                                                                                                <select name="product" id="product">';
                                                                                                                                                                    for($j = 1; $j<=count($product);$j++){
                                                                                                                                                                                     echo '<option value="'.$product[$j]["id_product"].'">'.$product[$j]["ten"].'</option>';
                                                                                                                                                                    }
                                                                                                                                                 echo '</select>
                                                                                                                                    </p>
                                                                                                                                    <p class="lable">Hình thức thanh toán</p>
                                                                                                                                    <p class="input">
                                                                                                                                                    <select name="payType" id="payType">
                                                                                                                                                                  <option value="1">Trừ  tiền trực tiếp trong tài khoản</option>
                                                                                                                                                                  <option value="2">Qua ngân lượng</option>
                                                                                                                                                                  <option value="3">Qua bảo kim</option>
                                                                                                                                                     </select>
                                                                                                                                    </p><input type="hidden" value="'.$type.'" id="type" name="type">';
                                                                                                                                      
                                                                                                                                    if($type=="mobile"){
                                                                                                                                                echo '<p class="lable">Số điện thoại cần nạp</p>
                                                                                                                                                <p class="input">
                                                                                                                                                                <input type="text"  name="mobile" id="mobile" />
                                                                                                                                                </p>';
                                                                                                                                    }else if($type=="game"){
                                                                                                                                                echo '<p class="lable">Tên tài khoản game</p>
                                                                                                                                                <p class="input">
                                                                                                                                                                <input type="text"  name="game_tk" id="game_tk" />
                                                                                                                                                </p>';
                                                                                                                                    }else if($type=="both"){
                                                                                                                                                echo '<p class="lable">Số điện thoại cần nạp</p>
                                                                                                                                                <p class="input">
                                                                                                                                                                <input type="text"  name="mobile" id="mobile" />
                                                                                                                                                </p>
                                                                                                                                                <p class="lable">Tên tài khoản game</p>
                                                                                                                                                <p class="input">
                                                                                                                                                                <input type="text"  name="game_tk" id="game_tk" />
                                                                                                                                                </p>';
                                                                                                                                    }
                                                                                                                    echo '</div>
                                                                                                                    <div class="right">
                                                                                                                                    <p class="note">
                                                                                                                                                <span>Chú ý:</span>
                                                                                                                                                Quý khách hàng vui lòng kiểm tra kĩ lại thông tin đã nhập “ mệnh giá tiền,số điện thoại cần nạp..trước khi nhấp  Nạp tiền ngay”
                                                                                                                                     </p>
                                                                                                                                      <input type="hidden" value="buycard" name="method">
                                                                                                                                    <input type="submit" value="Nạp tiền ngay"/>   
                                                                                                                    </div>
                                                                                                     </form>
                                                                                    </div>
                                                                                    <div id="tab2" class="tabContents">
                                                                                                 <div id="result"></div>
                                                                                                <form action="#">
                                                                                                        <div class="left">
                                                                                                                                                                                                                                      
                                                                                                                        <p class="lable">Mệnh giá thẻ nạp</p>
                                                                                                                        <p class="input">
                                                                                                                                         <select name="product_id" id="product_id">';
                                                                                                                                                                    for($j = 1; $j<=count($product);$j++){
                                                                                                                                                                                     echo '<option value="'.$product[$j]["id_product"].'">'.$product[$j]["ten"].'</option>';
                                                                                                                                                                    }
                                                                                                                                        echo '</select>
                                                                                                                        </p>
                                                                                                                        <p class="lable">Số lượng thẻ</p>
                                                                                                                        <p class="input">
                                                                                                                                            <input type="text"  name="num_card" id="num_card" />
                                                                                                                        </p>
                                                                                                                        <p class="lable">Hình thức thanh toán</p>
                                                                                                                        <p class="input">
                                                                                                                                            <select name="paytype" id="paytype">
                                                                                                                                                                  <option value="1">Trừ  tiền trực tiếp trong tài khoản</option>
                                                                                                                                                                  <option value="2">Qua ngân lượng</option>
                                                                                                                                                                  <option value="3">Qua bảo kim</option>
                                                                                                                                             </select>
                                                                                                                        </p>
                                                                                                        </div>
                                                                                                        <div class="right">
                                                                                                                            <p class="note"><span>Chú ý:</span> 
                                                                                                                                                            Quý khách hàng vui lòng kiểm tra kĩ lại thông tin đã nhập “ mệnh giá tiền,số lượng thẻ..trước khi nhấp  Mua thẻ”
                                                                                                                            </p>
                                                                                                                            <p class="lable">Hình thức nhận mã thẻ</p>
                                                                                                                            <p class="input">
                                                                                                                                                    <select  name="getType" id="getType">
                                                                                                                                                                    <option value="1">Nhận qua mail</option>
                                                                                                                                                                    <option value="2">Nhận qua sms</option>
                                                                                                                                                  </select>
                                                                                                                            </p>
                                                                                                                            <div class="box_total" id="box_total">
                                                                                                                            </div>
                                                                                                                                                <input type="button" value="Mua thẻ" name="" onclick="buy_card_code()" />
                                                                                                         </div>
                                                                                               </form>
                                                                                        </div>
                                                                    </div><!--box_nd-->
                                            </div><!--content-->
                        </div><!--napthe-->
                        <div class="line_thecao"></div>';
                  }
        
?>