<?php                   
            session_start();
            define("qaz_wsxedc_qazxc0FD_123K",true);             
            $phpbb_root_path = '../config/';
            include($phpbb_root_path."mysql.php");
            include($phpbb_root_path."config.php");
            include($phpbb_root_path."function.php");
            include($phpbb_root_path."global.php");
            include("../extsource/nusaop/nusoap.php");
            
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
            
            
            $sotien_invaild                                                                                         = FALSE;
            $nganhang_invaild                                                                                  = FALSE;
            $check_user_bank                                                                                   = FALSE;
            $code_invalid                                                                                           = FALSE;
            $msg =  '';
            $msg1 =  '';
            $sql = new db_sql();
            $sql->db_connect();
            $sql->db_select();
        
            if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="addmoneybanking" && isset($_GET["action"]) && $_GET["action"]=="xacnhan"){
                         $sessionValue = $_GET["sessionValue"];
	$action = $_GET["action"];                           
                          $method = $_GET["method"];
                           $CreateDate = date("Y-m-d");
                           $ip = getIp();
	if($action=="xacnhan" && $method=="addbank"){
                                                         $sessionValue = $_GET["sessionValue"];
                                                    $nganhang_id = $_GET["nganhang"];
                                                    $number_money = $_GET["number_money"];
                                                    
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
                                                        strcasecmp($_SESSION['code'], $_GET['code']) != 0) {
                                                                   $code_invalid = TRUE;
                                                     }
                                                      
                                                  
		
		if(!$nganhang_invaild && !$sotien_invaild  && !$code_invalid && !$check_user_bank) {
                                                                                $select =" SELECT `user`, `fullname` FROM `kien_member` WHERE `memberid`= $sessionValue limit 1";
                                                                                $sql->query($select);
                                                                                if($r = $sql->fetch_array()){
                                                                                    $user_add_bank = $r["user"];
                                                                                    $fullname_add_bank = $r["fullname"];
                                                                                }
                                                                                
                                                                                // nếu tất cả thông tin đúng tự động sinh mã ngẫu nhiên để gửi tới điện thoại người dùng xác thực
                                                                                $word_2 = "ADDBANK ";
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
                                                                                            $select_id = "SELECT `id` FROM `kien_list_request` WHERE `method` = '".$method."' and `user_id` = '".$sessionValue."' 
                                                                                                                                      and  `createdate` = '".$CreateDate."' and `code_confirm` = '".$word_2."' and `publish` = '0' and IP='".$ip."'  limit 1";
                                                                                            $sql->query($select_id);
                                                                                            if($r = $sql->fetch_array()){
                                                                                                $tem_id = $r["id"];
                                                                                            }

                                                                                            $sSQL_inser  = "INSERT INTO  ".DB_PREFIX."history_addmoney_bank(`id_bank` ,`number_money`,`id_request`)
                                                                                                         VALUES ('$nganhang_id',  '$number_money', '$tem_id') ";
                                                                                            if($sql->query($sSQL_inser)){
                                                                                                         $msg1 = "Nạp thẻ thành công";
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
			
		}
               
		$sql->close();        
            }
        if(!empty($msg1) && empty($msg)){         
             echo '                
                 <div class="fLeft sub-right sub-cont-r">
                    <span class="fLeft tl">&nbsp;</span>
                    <span class="fLeft tc tcr">&raquo; Thông tin tóm tắt</span>
                    <span class="fLeft tl tr">&nbsp;</span>
                    <div class="fLeft sub-right s-c-r cont-sub-right">
                        <div class="fLeft contNews">                
                            <div class="cont-tabs-dk fastReg">
                                <form id="update-form" action="" method="post" >';                                 
                                                echo '<div>
                                                        <ul class="laylaimk">                                          
                                                                            <li class="inputName">Tên tài khoản</li>
                                                                            <li class="inputName inputText">
                                                                                        '.$fullname_add_bank.'
                                                                            </li>

                                                                            <li class="inputName">Số tài khoản (<span class="red">*</span>)</li>
                                                                            <li class="inputName inputText">
                                                                                             '.$number_card_bank.'
                                                                             </li>
                                                                             <li class="inputName">Số tiền(<span class="red">*</span>)</li>
                                                                            <li class="inputName inputText">
                                                                                              '.number_format($number_money,2).' VNĐ
                                                                            </li>                                 
                                                                             <li class="inputName">Nội dung chuyển tiền(<span class="red">*</span>)</li>
                                                                            <li class="inputName inputText">
                                                                                              '.$word_2.'
                                                                            </li>                                                                                    
                                                        </ul>
                                                </div>
                                                <div class="clear margin-top">&nbsp;</div>                                                                                             
                                        </form> 
                                        </div>
                                </div>
                                 </div>
                      <span class="fLeft bc bc-r">&nbsp;</span>                                
                </div>';
   }else if(!empty ($msg) && empty ($msg1)){
       global $bank;
       echo '<div class="fLeft sub-right sub-cont-r">
        <span class="fLeft tl">&nbsp;</span>
        <span class="fLeft tc tcr">&raquo; Thông tin thẻ nạp</span>
        <span class="fLeft tl tr">&nbsp;</span>
        <div class="fLeft sub-right s-c-r cont-sub-right">
            <div class="fLeft contNews">                
                <div class="cont-tabs-dk fastReg">
                    <form id="update-form" action="" method="post">';
                                   echo $msg;
                                    echo '<div>
                                            <ul class="laylaimk">                                          
                                                                 <li class="inputName">Chọn ngân hàng</li>
                                                                <li class="inputName inputText">
                                                                                <select name="bank_id" id="bank_id">
                                                                                            <option value="0">-- Chọn ngân hàng --</option>';
                                                                                            for($i=1;$i<=count($bank);$i++){
                                                                                                echo '<option value="'.$bank[$i]["id"].'" >'.$bank[$i]["title"].'</option>';
                                                                                            }
                                                                                echo '</select>
                                                                </li>
                                                           
                                                                <li class="inputName">Số tiền muốn nạp (<span class="red">*</span>)<br />(Chưa trừ phí)</li>
                                                                <li class="inputName inputText">
                                                                                    <input name="moneyadd" id="moneyadd" type="text" maxlength="11" value="'.$number_money.'" data-target="moneyadd" /><br />
                                                                                     <p style="width: 382px">(Số tiền nạp phải nằm trong khoảng từ 10.000₫ đến 100.000.000₫)</p>
                                                                 </li>
                                                                 <li class="inputName">Phí dịch vụ (<span class="red">*</span>)</li>
                                                                <li class="inputName inputText">
                                                                                     (0%)
                                                                </li>                                 
                                                                <li class="inputName">Số tiền nhận (<span class="red">*</span>)<br />(Sau khi trừ phí)</li>
                                                                <li class="inputName inputText">     
                                                                                <input name="addmoney" id="addmoney" type="text" maxlength="20" value="'.$number_money.'" disabled="disabled"/><br />
                                                                 </li>
                                                                  <li class="inputName">Mã số an toàn(<span class="red">*</span>)</li>
                                                                <li class="inputName inputText">     
                                                                            <input class="verifyCode" maxlength="10"  name="code" type="text" id="captcha-code">                                                                         
                                                                            <span class="verifyCode">
                                                                                <img src="../extsource/get_captcha.php" alt="" id="captcha">
                                                                            </span>
                                                                            <span class="captcha_img"><img src="../extsource/refresh.jpg" alt="captcha"  id="captcha-refresh"></span>
                                                                 </li>
                                            </ul>
                                    </div>
                                    <div class="clear margin-top">&nbsp;</div>
                                 
                                    <p align="right">
                                        <input type="button" class="stbn" value="Xác nhận"  onclick="check_add_money_bank()" /> 
                                        <input type="hidden"  value="'.$method.'" id="method" /> 
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
