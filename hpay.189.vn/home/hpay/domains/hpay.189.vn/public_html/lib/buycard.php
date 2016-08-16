<?php
                define("qaz_wsxedc_qazxc0FD_123K",true);
                $phpbb_root_path = '../config/';
                include($phpbb_root_path."mysql.php");
                include($phpbb_root_path."config.php");
                include($phpbb_root_path."function.php");         
                require_once('../extsource/nusaop/nusoap.php');     
                
//                $newService = new nusoap_client('http://itopup-test.megapay.net.vn:8086/ItopupService1.4/services/TopupInterface?wsdl',true); 
//                $user_megapay ="acc_test3";
//                $pass_megapay = "123!@#$";
//                $keyBirthdayTime = '2013/02/22 11:40:27.057';
                
                
                $newService = new nusoap_client('http://service2.vnpttopup.com.vn:8080/ItopupService1.4/services/TopupInterface?wsdl',true); 
                $user_megapay ="HOANGGIA";
                $pass_megapay = "15935661642633";
                $keyBirthdayTime = '2013/04/20 11:39:04.660'; 
                
                $param = array('username'=>$user_megapay, 'password'=> $pass_megapay); 
                $result_login = $newService->call('signInAsPartner', $param);               
                $requestID  = generateRandomRequestID(); 
                
                
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
                
                  print_r("Token: ".$token);
          
                //------------------------ cac ham cho  service the --------------------------
                function generateRandomRequestID(){
                            $strFormat = 'YmdHis'; //bo u
                            $date = new DateTime();
                            $xxxx = "";
                            for ($i = 0; $i < 8; $i++){
                                    $xxxx .= rand(0, 9);
                            }
                            $requestID = $date->format($strFormat) . $xxxx;
                            return $requestID;

                  }

                function pkcs5_unpad($text)
                {
                        $pad = ord($text{strlen($text)-1});
                        if ($pad > strlen($text)) return false;
                        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
                        return substr($text, 0, -1 * $pad);
                }

                function decryptText($encryptText, $key123)
                {
                            if($key123==""){
                                        //$key ="c0cf49ebbd1a15ebbcec1ae4";
                                            $key = "96ea4d4c8c49743622dc696a";
                            }else{
                                         $key = $key123;
                            }
                            $key = substr($key, 0, 24);
                            $iv = substr($key, 0, 8);
                            $keyData = "\xA2\x15\x37\x08\xCA\x62\xC1\xD2"
                                    . "\xF7\xF1\x93\xDF\xD2\x15\x4F\x79\x06"
                                    . "\x67\x7A\x82\x94\x16\x32\x95";
                            $cipherText = base64_decode($encryptText);
                            $res = mcrypt_decrypt("tripledes", $key, $cipherText, "cbc", $iv);
                            $resUnpadded = pkcs5_unpad($res);
                            return $resUnpadded;
                }
                
                
                // ma hoa
            function encrypt2($input, $key_seed='hoanggia.biz'){
                        $input = trim($input);     
                        $block = mcrypt_get_block_size('tripledes', 'ecb');      
                        $len = strlen($input);      
                        $padding = $block - ($len % $block);      
                        $input .= str_repeat(chr($padding),$padding);    
                        $key = substr(md5($key_seed),0,24);    
                        $iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);    
                        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);  
                        $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input,  MCRYPT_MODE_ECB, $iv);
                        return base64_encode($encrypted_data);  
            }

            //gia ma
            function decrypt2($input, $key_seed='hoanggia.biz')  {  
                        $input = base64_decode($input);  
                        $key = substr(md5($key_seed),0,24);  
                        $text=mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB,'12345678');  
                        $block = mcrypt_get_block_size('tripledes', 'ecb');  
                        $packing = ord($text{strlen($text) - 1});  
                        if($packing and ($packing < $block)){  
                            for($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--){   
                                if(ord($text{$P}) != $packing){  
                                    $packing = 0;
                                } 
                            }
                        }  
                        $text = substr($text,0,strlen($text) - $packing); 
                        return $text;  
                }  
                
                if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="buycard"){  
                            $sql =  new db_sql();
                            $sql->db_connect();
                            $sql->db_select();
                            
                            $number_card = $_GET["sluong"];                             
                            $cardType = $_GET['cardType'];
                            $orderType =$_GET['orderType'];
                            $sessionValue = $_GET["sessionValue"];
                           
                            $get_phone = $_GET["get_phone"];
                            $get_account_game = $_GET['get_account_game'];
                            $company_code = $_GET['company_code'];
                            $create_date = date("Y-m-d");
                            $ip = getIp();                          
                            
                              //kiểm tra số lượng thẻ và kiểu thẻ
                            $num = is_numeric($number_card)?$number_card:0;
                            $seletc = "select gia from ".DB_PREFIX."product where id_product=$cardType";
                            $sql->query($seletc);
                            if($r = $sql->fetch_array()){
                                $price = doubleval($r["gia"]);                                                                
                            }
                            
                            $tongtien = $price * $num;                            
                            $select = "select Gold from ".DB_PREFIX."member where memberid=$sessionValue";
                            $sql->query($select);
                            if($tem = $sql->fetch_array()){
                                    $gold = $tem["Gold"];
                            }
                            
                            if($cardType > 0){
                                              // mã xác nhận ngẫu nhiên 
                                            $confirm_code = '';
                                            $md5_hash = md5(rand(0,999)); 
                                            $confirm_code = substr($md5_hash, 15, 5); 
                                            $id_request = "";
                                            // insert thông tin request
                                            $insert = "insert into ".DB_PREFIX."list_request(method,user_id,createdate,code_confirm,publish,IP) values('".$_GET[Webdesign]."','".$sessionValue."','".$create_date."','".$confirm_code."','0','".$ip."')";
                                            if($sql->query($insert)){
                                                $select = "SELECT `id` FROM ".DB_PREFIX."list_request  WHERE `method`='".$_GET[Webdesign]."' and `user_id`='".$sessionValue."' and  `createdate` = '".$create_date."' and `code_confirm` = '".$confirm_code."' and  `publish` = '0' and IP='".$ip."'  limit 1";
                                                if($sql->query($select)){
                                                    if($r = $sql->fetch_array()){
                                                            $id_request = $r["id"];
                                                    }
                                                }
                                            }
                                            
                                            // insert thông tin vào bảng history
                                            $insert_his = "insert into ".DB_PREFIX."history_buycard(id_loaithe,qty,thanhtoan,payId,id_request,download) values('".$cardType."','".$num."','".$orderType."','-1','".$id_request."','0')";
                                            $sql->query($insert_his);
                                            
                                              if($gold < $tongtien){
                                                      echo '<h2 style="text-align:center; color:red;">Không đủ tiền mua thẻ<h2>';
                                              }   else{
                                                                if($orderType !=1){
                                                                    echo '<h2 style="text-align:center; color:red;">Chức năng này chưa hoàn thiện mời bạn chọn kiểu thanh toán khác<h2>';
                                                                }else{
                                                                            if($get_phone !=""){
                                                                                        if(!is_numeric($get_phone)){
                                                                                                    echo '<h2 style="text-align:center; color:red;">Mời bạn nhập lại số điện thoại<h2>';
                                                                                        }else{
                                                                                                       // gọi tới  directTopupMobile($itopupClient);
                                                                                                     $param = array(
                                                                                                                    'username' => $user_megapay ,
                                                                                                                    'targetAccount' => trim($get_phone),
                                                                                                                    'amount' => $tongtien,
                                                                                                                    'requestID' => $requestID,
                                                                                                                    'token' => $token
                                                                                                      ); 
                                                                                                      $get_result = $newService->call('partnerDirectTopupMobile', $param);
                                                                                                      print_r($get_result);

                                                                                                      if($get_result['errorCode']!=0){
                                                                                                                        echo '<h2 style="text-align:center; color:red;">'.$get_result['errorMessage'].'<h2>';
                                                                                                       }else{
                                                                                                                                // tru tien trong tai khoan thanh vien                        
                                                                                                                               $tem = $gold - $tongtien;
                                                                                                                               $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' where memberid=$sessionValue";
                                                                                                                               $sql->query($update_money);
                                                                                                                                // cap nhat trang thai giao dich và lưu lịch sử
                                                                                                                               $update = "update ".DB_PREFIX."list_request set publish='1' where id='".$id_request."' and IP='".$ip."'";
                                                                                                                               if($sql->query($update)){
                                                                                                                                    $insert = "insert into ".DB_PREFIX."history_buycard(id_loaithe,qty,thanhtoan,payId,id_request,requestID_code,to_phone,download,payId) values('".$cardType."','".$num."','".$orderType."','".$id_request."','".$requestID."','".$get_phone."','1','".$get_result[epayTransID]."')";
                                                                                                                                    $sql->query($insert);                             
                                                                                                                             }                                             
                                                                                                                             
                                                                                                                                   // thực hiện get_download soft pin from servecies
                                                                                                                                     //Build list Items
                                                                                                                                    $buyItem = array('productId'=> $cardType, 'quantity' => $num);
                                                                                                                                    $listItems = array($buyItem);
                                                                                                                                    $param_softpin  = array(
                                                                                                                                                                'username' =>$user_megapay, 
                                                                                                                                                                'requestID' => $requestID,
                                                                                                                                                                'token' => $token,
                                                                                                                                                                'keyBirthdayTime' => $keyBirthdayTime,
                                                                                                                                                                'buyItems' => $listItems
                                                                                                                                     );
                                                                                                                                    
                                                                                                                                     $re_param_softpin  = array(
                                                                                                                                                                'username' =>$user_megapay, 
                                                                                                                                                                'requestID' => $requestID,
                                                                                                                                                                'token' => $token,
                                                                                                                                                                'keyBirthdayTime' => $keyBirthdayTime                                                                                                                                                             
                                                                                                                                     );
                                                                                                                                     
                                                                                                                                    $result_softpin  = $newService->call('partnerDownloadSoftpinV10', $param_softpin);				
                                                                                                                                    print_r($result_softpin);
                                                                                                                                  
                                                                                                                                    while(empty($result_softpin)){
                                                                                                                                        $result_softpin = $newService->call('partnerRedownloadSoftpin', $re_param_softpin);        
                                                                                                                                    }  
                                                                                                                                    
                                                                                                                                    print_r($result_softpin);
                                                                                                                                    if ($result_softpin != null){
                                                                                                                                            $errorCode = $result_softpin["errorCode"];
                                                                                                                                            $errorMessage = $result_softpin["errorMessage"];
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                    if($errorCode==0){
                                                                                                                                            //$epayTransID =  $result_softpin["epayTransID"];
                                                                                                                                            foreach($result_softpin['products'][0]['softpins'] as $k=>$itm){
                                                                                                                                                   $pin =  decryptText($itm['softpinPinCode'],"");
                                                                                                                                                   //$itm['softpinPinCode']=  encrypt2($itm['softpinPinCode']);
                                                                                                                                                  // $attributes=$itm;
                                                                                                                                                   //$member_id=$sessionValue;
                                                                                                                                                   //$transaction_id= $epayTransID;
                                                                                                                                                   $product_id = $cardType;
                                                                                                                                                   //$created =date('Y-m-d H:i:s'); 
                                                                                                                                                   $softpinPinCode = $pin;
                                                                                                                                                   $serial = $itm['softpinSerial'];
                                                                                                                                                   $expiryDate = $itm['expiryDate'];
                                                                                                                                                   $requestid  = $id_request;
                                                                                                                                                   $insert = "insert into ".DB_PREFIX."history_get_services(request_id,pincode,serialcode,product_id,expiryDate) values('".$requestid."','".$softpinPinCode."','".$serial."','".$product_id."','".$expiryDate."')";
                                                                                                                                                   $sql->query($insert);                                                                                                                                                   
                                                                                                                                           }
                                                                                                                                    }
                                                                                                                                   echo '<h2 style="text-align:center; color:red;">Nạp thẻ điện thoại thành công<h2>';      
                                                                                                                 }
                                                                                                    } 
                                                                            }else if($get_account_game !=""){   
                                                                                                    $param = array(
                                                                                                                'username' => $user_megapay ,
                                                                                                                'providerCode' => $company_code,
                                                                                                                'targetAccount' => trim($get_account_game),
                                                                                                                'amount' => $price,
                                                                                                                'requestID' => $requestID,
                                                                                                                'token' => $token
                                                                                                       ); 

                                                                                                      $get_result = $newService->call('partnerDirectTopupGame', $param);
                                                                                                      
                                                                                                      if($get_result['errorCode']!=0){
                                                                                                                        echo '<h2 style="text-align:center; color:red;">'.$get_result['errorMessage'].'<h2>';
                                                                                                       }else{
                                                                                                                        // tru tien trong tai khoan thanh vien                        
                                                                                                                        $tem = $gold - $tongtien;
                                                                                                                        $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' memberid=$sessionValue";
                                                                                                                        $sql->query($update_money);

                                                                                                                         // cap nhat trang thai giao dich và lưu lịch sử
                                                                                                                        $update = "update ".DB_PREFIX."list_request set publish='1' where id='".$id_request."' and IP='".$ip."' ";
                                                                                                                        if($sql->query($update)){
                                                                                                                             $insert = "insert into ".DB_PREFIX."history_buycard(id_loaithe,qty,thanhtoan,id_request,requestID_code,to_account_game,download,payId) values('".$cardType."','".$num."','".$orderType."','".$id_request."','".$requestID."','".$get_account_game."','1','".$get_result[epayTransID]."')";
                                                                                                                             $sql->query($insert);                                                                                                          

                                                                                                                        }
                                                                                                       }                                                                                                
                                                                                                        echo '<h2 style="text-align:center; color:red;">Nạp tài khoảng game thành công<h2>';                                                                                                                                        
                                                                                    }else{ 
                                                                                                    echo '<h2 style="text-align:center; color:red;">Có lỗi xảy ra xin vui lòng thử lại<h2>';
                                                                                     }
                                                                        }
                                                          }
                            }else{
                                 echo '<h2 style="text-align:center; color:red;">Có lỗi xảy ra xin vui lòng thử lại<h2>';
                            }              
            }
//echo $msg;
?>
