<?php
                define("qaz_wsxedc_qazxc0FD_123K",true);
                $phpbb_root_path = '../config/';
                include($phpbb_root_path."mysql.php");
                include($phpbb_root_path."config.php");
                include($phpbb_root_path."function.php");         
                require_once('../extsource/ItopupClient.php');
                
                function directTopupMobile($itopupClient,$requestID,$targetAccount,$amount){
		echo "__________________________________________________<br>";
		$requestID = $requestID;		
                                                      $targetAccount = $targetAccount;
		$amount = $amount;
		echo "RequestID:<b> ". $requestID. "</b><br>";
		echo "TargetAccount: <b>". $targetAccount. "</b><br>";
		echo "Amount: <b>". number_format($amount,3). "</b> VNĐ<br>";
		$itopupClient->directTopupMobile($requestID, $targetAccount, $amount);
               }
	function directTopupGame($itopupClient,$request_id,$price,$target,$provice_code){
                                                    echo "__________________________________________________<br>";			
                                                    $requestID = $request_id;			
                                                    $amount = $price;		
                                                    $providerCode = $provice_code;		
                                                    $targetAccount = $target;		
		echo "RequestID". $requestID. "</b><br>";
		echo "ServiceProvider:<b> ". $providerCode. "</b><br>";
		echo "TargetAccount: <b>". $targetAccount. "</b><br>";
		echo "Amount: <b>". $amount. "</b> VND<br>";
		$itopupClient->directTopupGame($requestID, $providerCode, $targetAccount, $amount);
	}
        
	// DOWNLOAD SOFTPIN
	function downloadSoftpin($itopupClient,$requestID,$productID,$quantity){
		echo "__________________________________________________<br>";
//		$requestID = $itopupClient->generateRandomRequestID();	
//		$productID = 1;
//		$quantity = 1;
                                                     $requestID = $requestID;
                                                     $productID = $productID;
                                                     $quantity = $quantity;
                                                     
                                                     echo "RequestID". $requestID. "</b><br>";
		echo "ProductID:<b> ". $productID. "</b><br>";
		echo "Quantity: <b>". $quantity. "</b><br>";
		
                
		$itopupClient->downloadSoftpin($requestID, $productID, $quantity);
	}
	//Redownload Softpin
	function reDownloadSoftpin($itopupClient,$requestID){
		echo "__________________________________________________<br>";
		//$requestId = "2012092408390811307116";
                                                     $requestId = $requestID;
		echo "requestID : ".$requestId."<br>";
		$itopupClient->reDownloadSoftpin($requestId);
	}
	//Query balance
	function queryBalance($itopupClient,$request_id){
		$requestID = $request_id;
		$itopupClient->queryBalance($requestID);
	}
	function getDirectTransDetail($itopupClient,$request_id){
	echo "__________________________________________________<br>";
		echo "<br><b>getDirectTransDetail. Cac tham so dau vao: </b><br>";
		$requestID = $request_id;		//Bat buoc phai sinh ra	
		echo "requestID: ".$requestID."<br>";
		$itopupClient->getDirectTransDetail($requestID);
	}
                
                if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="buycard"){                                                   
	 echo "VNPT EPAY Itopup Client Sample <br>";
	 echo "__________________________________________________<br>";
	
	 $itopupClient = new ItopupClient();	
                            $requestID  = $itopupClient->generateRandomRequestID();
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
                            
                            $tongtien = doubleval($price * $num);                            
                            $select = "select Gold from ".DB_PREFIX."member where memberid=$sessionValue";
                            $sql->query($select);
                            if($tem = $sql->fetch_array()){
                                    $gold = $tem["Gold"];
                            }
                            
                            
                             // 1. Login
                             echo "SignIn Result: <br>";
                             $result = $itopupClient->signIn();
                             print_r("ErrorCode: <font color=\"red\">". $itopupClient->errorCode. "</font><br>");
                             print_r("ErrorMessage: <font color=\"red\">". $itopupClient->errorMessage. "</font><br>");
                             print_r("Token: <b>". $itopupClient->token. "</b><br>");
                             print_r("RequestID: <b>". $requestID. "</b><br>");
                             print_r("Số thẻ: <b>". $num. "</b><br>");
                             print_r("Loại thẻ: <b>". $cardType. "</b><br>");
                             print_r("Kiểu thanh toán: <b>". $orderType. "</b><br>");
                             print_r("Số điện thoại: <b>". $get_phone. "</b><br>");
                             print_r("Tài khoản game: <b>". $get_account_game. "</b><br>");
                             print_r("Mã nhà cung cấp: <b>". $company_code. "</b><br>");
                             print_r("Tiền trong tài khoản thành viên: <b>". $gold. "</b><br>");
                             print_r("Giá tiền loại thẻ: <b>". $price. "</b><br>");
                             print_r("Tông tiền của đơn hàng: <b>". $tongtien. "</b><br>");
                           //  queryBalance($itopupClient,$requestID);
                            
                            if($cardType > 0){
                                              // mã xác nhận ngẫu nhiên 
//                                            $confirm_code = '';
//                                            $md5_hash = md5(rand(0,999)); 
//                                            $confirm_code = substr($md5_hash, 15, 5); 
//                                            $id_request = "";
//                                            // insert thông tin request
//                                            $insert = "insert into ".DB_PREFIX."list_request(method,user_id,createdate,code_confirm,publish,IP) values('".$_GET[Webdesign]."','".$sessionValue."','".$create_date."','".$confirm_code."','0','".$ip."')";
//                                            if($sql->query($insert)){
//                                                $select = "SELECT `id` FROM ".DB_PREFIX."list_request  WHERE `method`='".$_GET[Webdesign]."' and `user_id`='".$sessionValue."' and  `createdate` = '".$create_date."' and `code_confirm` = '".$confirm_code."' and  `publish` = '0' and IP='".$ip."'  limit 1";
//                                                if($sql->query($select)){
//                                                    if($r = $sql->fetch_array()){
//                                                            $id_request = $r["id"];
//                                                    }
//                                                }
//                                            }
//                                            
//                                            // insert thông tin vào bảng history
//                                            $insert_his = "insert into ".DB_PREFIX."history_buycard(id_loaithe,qty,thanhtoan,payId,id_request,download) values('".$cardType."','".$num."','".$orderType."','-1','".$id_request."','0')";
//                                            $sql->query($insert_his);
                                            
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
                                                                                                     $get_result  = directTopupMobile($itopupClient,$requestID,$get_phone,$tongtien);
                                                                                                     print_r($get_result);                                                                                                  
                                                                                                     
                                                                                                     $softpin = downloadSoftpin($itopupClient, $requestID, $cardType, $num);
                                                                                                     print_r($softpin);
//                                                                                                      if($get_result['errorCode']!=0){
//                                                                                                                        echo '<h2 style="text-align:center; color:red;">'.$result['errorMessage'].'<h2>';
//                                                                                                       }else{
//                                                                                                                   $softpin = downloadSoftpin($itopupClient, $requestID, $cardType, $num);
//                                                                                                                     while(empty($softpin)){
//                                                                                                                                $softpin = reDownloadSoftpin($itopupClient,$requestID);     
//                                                                                                                    }
//                                                                                                                    
//                                                                                                                    if($softpin['errorCode']==0){
//                                                                                                                              foreach($softpin['products'][0]['softpins'] as $k=>$itm){
//                                                                                                                                      $serial = $itm['softpinSerial'];
//                                                                                                                                      $expiryDate = $itm['expiryDate'];                                                                                                                                      
//                                                                                                                                      $pin = $itopupClient->deCrypt($itm['softpinPinCode']);
//                                                                                                                                      $insert = "insert into ".DB_PREFIX."history_get_services(request_id,pincode,serialcode,product_id,expiryDate) values('".$id_request."','".$pin."','".$serial."','".$cardType."','".$expiryDate."')";
//                                                                                                                                      $sql->query($insert);
//                                                                                                                                }
//                                                                                                                                // tru tien trong tai khoan thanh vien                        
//                                                                                                                               $tem = $gold - $tongtien;
//                                                                                                                               $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' where memberid=$sessionValue";
//                                                                                                                               $sql->query($update_money);
//                                                                                                                                // cap nhat trang thai giao dich và lưu lịch sử
//                                                                                                                               $update = "update ".DB_PREFIX."list_request set publish='1' where id='".$id_request."' ";
//                                                                                                                               if($sql->query($update)){
//                                                                                                                                    $insert = "insert into ".DB_PREFIX."history_buycard(id_loaithe,qty,thanhtoan,payId,id_request,requestID_code,to_phone,download,payId) values('".$cardType."','".$num."','".$orderType."','".$id_request."','".$requestID."','".$get_phone."','1','".$get_result[epayTransID]."')";
//                                                                                                                                    $sql->query($insert);                                                                                                            
//                                                                                                                                   echo '<h2 style="text-align:center; color:red;">Nạp thẻ điện thoại thành công<h2>';                                                                              
//                                                                                                                             }                                                                                                                       
//                                                                                                                 }
//                                                                                                    } 
                                                                                           }                                                                                        
                                                                            }else if($get_account_game !=""){   
                                                                                                     $get_result  = directTopupGame($itopupClient,$requestID,$tongtien,$get_account_game,$company_code);
                                                                                                     print_r($get_result);
                                                                                                      if($get_result['errorCode']!=0){
                                                                                                                        echo '<h2 style="text-align:center; color:red;">'.$result['errorMessage'].'<h2>';
                                                                                                       }else{
                                                                                                                    $softpin = downloadSoftpin($itopupClient, $requestID, $cardType, $num);
                                                                                                                     while(empty($softpin)){
                                                                                                                                $softpin = reDownloadSoftpin($itopupClient,$requestID);     
                                                                                                                    }
                                                                                                                    if($softpin['errorCode']==0){
                                                                                                                           foreach($softpin['products'][0]['softpins'] as $k=>$itm){
                                                                                                                                   $serial = $itm['softpinSerial'];
                                                                                                                                   $expiryDate = $itm['expiryDate'];                                                                                                                                      
                                                                                                                                   $pin = $itopupClient->deCrypt($itm['softpinPinCode']);
                                                                                                                                   $insert = "insert into ".DB_PREFIX."history_get_services(request_id,pincode,serialcode,product_id,expiryDate) values('".$id_request."','".$pin."','".$serial."','".$cardType."','".$expiryDate."')";
                                                                                                                                   $sql->query($insert);
                                                                                                                     }
                                                                                                                        // tru tien trong tai khoan thanh vien                        
                                                                                                                        $tem = $gold - $tongtien;
                                                                                                                        $update_money = "update ".DB_PREFIX."member set Gold='".$tem."' memberid=$sessionValue";
                                                                                                                        $sql->query($update_money);

                                                                                                                         // cap nhat trang thai giao dich và lưu lịch sử
                                                                                                                        $update = "update ".DB_PREFIX."list_request set publish='1' where id='".$id_request."' ";
                                                                                                                        if($sql->query($update)){
                                                                                                                             $insert = "insert into ".DB_PREFIX."history_buycard(id_loaithe,qty,thanhtoan,payId,id_request,requestID_code,to_account_game,download,payId) values('".$cardType."','".$num."','".$orderType."','".$id_request."','".$requestID."','".$get_account_game."','1','".$result[epayTransID]."')";
                                                                                                                             $sql->query($insert);                                                                                                          

                                                                                                                        }
                                                                                                       }
                                                                                                
                                                                                                        echo '<h2 style="text-align:center; color:red;">Nạp tài khoảng game thành công<h2>';                                                                                                                                        
                                                                
                                                                                                    }
                                                                                    }
                                                                        }
                                                          }
                            }else{
                                 echo '<h2 style="text-align:center; color:red;">Có lỗi xảy ra xin vui lòng thử lại<h2>';
                            }              
         }
//echo $msg;
?>
