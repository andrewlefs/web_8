<?php
            session_start();
            define("qaz_wsxedc_qazxc0FD_123K",true);
            $phpbb_root_path = '../config/';
            include($phpbb_root_path."mysql.php");
            include($phpbb_root_path."config.php");        
            include($phpbb_root_path."function.php");
            include($phpbb_root_path."global.php");
            require_once '../extsource/nusaop/nusoap.php';
            
            function sentsmss($sdt,$noidung) {  
                    $wsdl = 'http://sms-gw1.apectech.vn:8081/axis/services/Mt_receicer?wsdl';
                    $client = new nusoap_client($wsdl, true);
                    $msg_id = ceil(rand(0, 1000));    
                    if($sdt ==""){
                            $msisdn= '0932235947';
                    }else{
                            $msisdn = $sdt;
                    }
                    $message = 'HoangGia '.$noidung;
                    $brandname = 'hoanggia';
                    $username = 'hoanggiacorp';
                    $password = 'reh7$8eh^e@92ye';
                    $sharekey = 'FJU445O9G94NFHH30CJ6H';
                    $hashkey = md5("{$msg_id}{$msisdn}{$message}{$brandname}{$username}{$password}{$sharekey}");
                    $params =array('msg_id'=>$msg_id,'msisdn'=>$msisdn,'message'=>$message,'brandname'=>$brandname,'username'=>$username,'password'=>$password,'hashkey'=>$hashkey);
                    $result = $client->call('sendTextMessage', $params);
                  // echo "<p>Apectech Result:". var_dump($result)."</p>";
            }
            
            $pin_invalid                                                                                             = false;
            $card_invalid                                                                                           = false;
            $pin_existing                                                                                            = FALSE;
            $card_existing                                                                                          = false;
            $code_invalid                                                                                           = FALSE;
            $loaithe_invaild                                                                                        = FALSE;
            $check                                                                                                        = FALSE;
            $msg =  '';
            $msg1 =  '';
        
            if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="addmoneycard"  && isset($_GET["method"]) ){
                          $action = $_GET["action"];
                          $method = $_GET["method"];                         
                           $CreateDate = date("Y-m-d");
                           $ip = getIp();
                           global $comid;
                           if($action=="add" && $method=="addcard"){
                                                    $loaithe = $_GET["loaithe"];
                                                    $pincode = $_GET["pincode"];
                                                    $cardcode = $_GET["cardcode"];
                                                    $sessionValue_card = $_GET["sessionValue"];
                                                    $sql = new db_sql();
                                                    $sql->db_connect();
                                                    $sql->db_select();
                                                    
                                                     $name = "";
                                                    //lấy thông tin loại thẻ
                                                    $select = "select name from ".DB_PREFIX."company where id_company = $loaithe and publish= 1 limit 1";
                                                    $sql->query($select);
                                                    if($r = $sql->fetch_array()){
                                                        $name = $r["name"];
                                                    }
                                                    //kết thúc lấy thông tin loại thẻ
                                                    
                                                     if(empty($_SESSION['code'] ) ||
                                                        strcasecmp($_SESSION['code'], $_GET['code']) != 0) {
                                                                   $code_invalid = TRUE;
                                                       }
                                                       
                                                       
		if($loaithe=="" ){
                                                                       $loaithe_invaild = true;
                                                     }  
                                                     
                                                     if($pincode==""){
                                                                         $pin_invalid = true;
                                                     }
                                                     
                                                     if($cardcode==""){
                                                                           $card_invalid = true;
                                                     }
                                                     
                                                     $select = "SELECT `id_loaithe`, `pin_code`, `card_code`  FROM ".DB_PREFIX."history_addmoney_card WHERE `id_loaithe`='$loaithe' and 
                                                                                    ( `pin_code` = '$pincode'  or  `card_code`='$cardcode' )  and  request_id in (select id from ".DB_PREFIX."list_request)  ";
                                                            $sql->query($select);
                                                            if($sql->num_rows() > 0){
                                                                       $check = true;
                                                     }
		
		if(!$loaithe_invaild  && !$code_invalid && !$check && !$pin_invalid && !$card_invalid) {
                                                                                $select =" SELECT `user`, `fullname` FROM ".DB_PREFIX."member WHERE `memberid`= $sessionValue_card limit 1";
                                                                                $sql->query($select);
                                                                                if($r = $sql->fetch_array()){
                                                                                    $user_add_card = $r["user"];
                                                                                    $fullname_add_card= $r["fullname"];
                                                                                }
                                                                                // mã xác nhận ngẫu nhiên 
                                                                                $confirm_code = '';
                                                                                $md5_hash = md5(rand(0,999)); 
                                                                                $confirm_code = substr($md5_hash, 15, 5); 
                                                                                sentsmss("",$confirm_code);
                                                                                
                                                                                // sau khi gửi mã xác nhận tới điện thoại khác hàng thì thực hiện lưu yêu cầu và lịch sử giao dịch
                                                                                $sSQL = "INSERT INTO  ".DB_PREFIX."list_request(`method`,`user_id` ,`publish`,`code_confirm` ,`createdate`,`IP`)
                                                                                                  VALUES ('$method',   '$sessionValue_card',  '0','$confirm_code',  '$CreateDate','$ip') ";
                                                                                // nếu insert vào yêu cầu thành công thực hiện lấy mã yêu cầu insert các thông tin còn lại vào bảng history
                                                                                if($sql->query($sSQL)){
                                                                                                    $select_id = "SELECT `id` FROM ".DB_PREFIX."list_request  WHERE `method` = '".$method."' and `user_id` = '".$sessionValue_card."' 
                                                                                                                            and  `createdate` = '".$CreateDate."' and `code_confirm` = '".$confirm_code."' and `publish` = '0' and `IP` = '".$ip."'  limit 1";
                                                                                                    $sql->query($select_id);
                                                                                                    if($r = $sql->fetch_array()){
                                                                                                        $tem_id = $r["id"];
                                                                                                    }
                                                                                                    $sSQL_insert = "INSERT INTO  ".DB_PREFIX."history_addmoney_card(`id_loaithe` ,`pin_code` ,`card_code`,`request_id`)
                                                                                                                      VALUES ('$loaithe',  '$pincode',  '$cardcode', '$tem_id') ";
                                                                                                    if($sql->query($sSQL_insert)){
                                                                                                                           $msg1 = "Nạp thẻ thành công";
                                                                                                    }
                                                                                                   
                                                                                }
			
                                                                                
		} else {
                                                                                if($code_invalid)
				$msg = "Mã bảo vệ không đúng";
			if($pin_invalid)
				$msg = "Xin vui lòng nhập mã pin.";			
                                                                                if($card_invalid)
				$msg = "Xin vui lòng nhập mã thẻ.";
                                                                                  if($check)
				$msg = "Mã thẻ đã được sử dụng.";
		}
               
		$sql->close();        
     
	}
        if(!empty($msg1) && empty($msg)){         
             echo '                
                 <div class="fLeft sub-right sub-cont-r">
                    <span class="fLeft tl">&nbsp;</span>
                    <span class="fLeft tc tcr">&raquo; Xác nhận nạp thẻ</span>
                    <span class="fLeft tl tr">&nbsp;</span>
                    <div class="fLeft sub-right s-c-r cont-sub-right">
                        <div class="fLeft contNews">                
                            <div class="cont-tabs-dk fastReg">
                                <form id="update-form" action="" method="post" >';                                 
                                                echo '<div>
                                                        <ul class="laylaimk">                                          
                                                                            <li class="inputName">Loại thẻ</li>
                                                                            <li class="inputName inputText">
                                                                                        '.$name.'
                                                                            </li>

                                                                            <li class="inputName">Mã pin thẻ (<span class="red">*</span>)</li>
                                                                            <li class="inputName inputText">
                                                                                             '.$pincode.'
                                                                             </li>
                                                                             <li class="inputName">Mã thẻ (<span class="red">*</span>)</li>
                                                                            <li class="inputName inputText">
                                                                                              '.$cardcode.'
                                                                            </li>                                 
                                                                            <li class="inputName">Mã xác nhận nạp tiền(<span class="red">*</span>)</li>
                                                                            <li class="inputName inputText">     
                                                                                    <input name="vailSMS" id="vailSMS">
                                                                             </li>
                                                        </ul>
                                                </div>
                                                
                                                <p align="right">                                                   
                                                     <input type="hidden" class="stbn" value="'.$loaithe.'"  id="idcheck" />
                                                     <input type="hidden" class="stbn" value="'.$pincode.'"  id="pincheck" />
                                                     <input type="hidden" class="stbn" value="'.$cardcode.'"  id="thecheck" />   
                                                    <input type="button" class="stbn" value="Thực hiện" id="button_submit" onclick="add_money_card()"/>
                                                                                                      
                                                </p>
                                        </form> 
                                        </div>
                                </div>
                                </div>
                                <span class="fLeft bc bc-r">&nbsp;</span>
                </div>';
   }else if(!empty ($msg)){
         echo '<div class="fLeft sub-right sub-cont-r">
                        <span class="fLeft tl">&nbsp;</span>
                        <span class="fLeft tc tcr">&raquo; Thông tin cá nhân</span>
                        <span class="fLeft tl tr">&nbsp;</span>
                        <div class="fLeft sub-right s-c-r cont-sub-right">
                                <div class="fLeft contNews">                
                                        <form id="update-form" action="" method="post">';
                                                            echo $msg;
                                                            echo '<div>
                                                                    <ul class="laylaimk">                                          
                                                                                        <li class="inputName">Chọn loại thẻ</li>
                                                                                        <li class="inputName inputText">
                                                                                                 <select name="loaithe" id="loaithe">';
                                                                                                                for($i=1;$i<=count($comid);$i++){
                                                                                                                            $id_tem = $comid[$i]["id"];
                                                                                                                            echo '<option value="'.$id_tem.'">'.get_com($id_tem).'</option>';
                                                                                                                }                                                                                                                
                                                                                                echo '</select>
                                                                                        </li>

                                                                                        <li class="inputName">Mã pin thẻ (<span class="red">*</span>)</li>
                                                                                        <li class="inputName inputText">
                                                                                                            <input name="pincode" id="pincode" type="text" maxlength="20" value="'.$pincode.'" /><br />
                                                                                         </li>
                                                                                         <li class="inputName">Mã thẻ (<span class="red">*</span>)</li>
                                                                                        <li class="inputName inputText">
                                                                                                             <input name="cardcode" id="cardcode"  type="text" maxlength="255" value="'.$cardcode.'" /><br />
                                                                                        </li>                                 
                                                                                        <li class="inputName">Mã xác nhận (<span class="red">*</span>)</li>
                                                                                        <li class="inputName inputText">     
                                                                                                    <input class="verifyCode" maxlength="10"  name="code" type="text" id="captcha-code">                                                                         
                                                                                                    <span class="verifyCode">
                                                                                                        <img src="http://hpay.189.vn/extsource/get_captcha.php" alt="" id="captcha">
                                                                                                    </span>
                                                                                                    <span class="captcha_img"><img src="http://hpay.189.vn/extsource/refresh.jpg" alt="captcha"  id="captcha-refresh"></span>
                                                                                         </li>
                                                                    </ul>
                                                            </div>                                   
                                                            <p align="right">
                                                                <input type="button" class="stbn" value="Nạp tiền" onclick="check_add_money_card()" />
                                                                 <input type="hidden" value="'.$method.'" name="action" id="method" />

                                                            </p>
                                            </form>                           
                                </div>                               
                     </div>
            </div>
            <span class="fLeft bc bc-r">&nbsp;</span>
    </div>';
   }
}

?>
