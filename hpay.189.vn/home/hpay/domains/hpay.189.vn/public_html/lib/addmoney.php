<?php
            if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                            die("<a href='../index.php'>Trang ch&#7911;</a>");
            }
            if($Auth["memberid"] < 1){
                    header("Location: /login.html");
                    exit;
            }
            require_once './extsource/nusaop/nusoap.php';
            require_once './extsource/BKTransactionAPI.php';
       
            $code_invalid = false;
            $companyid_check = false; 
            $companyid_check_exist = false;
            $smscode_invaild = false;
            $smscode_exis = false;
            $msg =  '';
            $msg2 = '';
            $msg3 = "";
            $user = "";
            $cmt = "";
            $fullname = "";
            $email = "";
            $ip = "";
            $company_name =  "";
            $pincode ="";
            $cardcode ="";
            $company_id = "";
            $pages = "";
            $method = "";      
            $tab_active = "";
            if(isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="addmoney"){
                            $sql = new db_sql();
                            $sql->db_connect();
                            $sql->db_select();
                            $memberid =$Auth["memberid"];
                            $ip = getIp();
                            $pages = $_GET["Webdesign"];
                            $select = "SELECT `user`, `cmt`, `fullname`,`email` FROM ".DB_PREFIX."member WHERE `memberid`=$memberid and `Published`=1 limit 1";
                            $sql->query($select);
                            if($r = $sql->fetch_array()){
                                            $user = $r["user"];
                                            $cmt = $r["cmt"];
                                            $fullname = $r["fullname"];
                                            $email = $r["email"];
                            }
                            $tab_active = "tab1";                
                            $sql->close();
            }


            if($_SERVER['REQUEST_METHOD']=='POST'  && $pages="addmoney"){
                            $method = $_POST["method"];
                            if($method=="check_add_money_card"){
                                        $sql = new db_sql();
                                        $sql->db_connect();
                                        $sql->db_select();
                                        $company_id = $_POST["loaithe"];
                                        $pincode = $_POST["pincode"];
                                        $cardcode = $_POST["cardcode"];
                                        $CreateDate = date("Y-m-d");
                                        
                                        $tab_active = "tab1";
                                        if($company_id==""){
                                             $companyid_check = TRUE; 
                                        }else{
                                            $select = "select id_company from ".DB_PREFIX."company where id_company='".$company_id."'";
                                            $sql->query($select);
                                            $num = $sql->num_rows();
                                            if($num != 1){
                                                    $companyid_check_exist = TRUE;
                                            }
                                        }
                                        
                                        $company_name = get_com($company_id);
                                        
                                        if(empty($_SESSION['code'] ) ||
                                                      strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                                 $code_invalid = TRUE;
                                                     }
                                                     
                                       if(!$companyid_check  && !$code_invalid && !$companyid_check_exist) {                                                           
                                                                // mã xác nhận ngẫu nhiên 
                                                                $confirm_code = '';
                                                                $md5_hash = md5(rand(0,999)); 
                                                                $confirm_code = substr($md5_hash, 15, 5); 
                                                                sentsmss("",$confirm_code);

                                                                // sau khi gửi mã xác nhận tới điện thoại khác hàng thì thực hiện lưu yêu cầu và lịch sử giao dịch
                                                                $sSQL = "INSERT INTO  ".DB_PREFIX."list_request(`method`,`user_id` ,`publish`,`code_confirm` ,`createdate`,`IP`)
                                                                                  VALUES ('$method',   '$memberid',  '0','$confirm_code',  '$CreateDate','$ip') ";
                                                                // nếu insert vào yêu cầu thành công thực hiện lấy mã yêu cầu insert các thông tin còn lại vào bảng history
                                                                if($sql->query($sSQL)){
                                                                                    $select_id = "SELECT `id` FROM ".DB_PREFIX."list_request  WHERE `method` = '".$method."' and `user_id` = '".$memberid."' 
                                                                                                            and  `createdate` = '".$CreateDate."' and `code_confirm` = '".$confirm_code."' and `publish` = '0' and `IP` = '".$ip."'  limit 1";
                                                                                    $sql->query($select_id);
                                                                                    if($r = $sql->fetch_array()){
                                                                                        $tem_id = $r["id"];
                                                                                    }
                                                                                    $sSQL_insert = "INSERT INTO  ".DB_PREFIX."history_addmoney_card(`id_loaithe` ,`pin_code` ,`card_code`,`request_id`)
                                                                                                      VALUES ('$company_id',  '$pincode',  '$cardcode', '$tem_id') ";
                                                                                    if($sql->query($sSQL_insert)){
                                                                                                           $msg = "check_add_money_ok";
                                                                                    }
                                                                }              
		} else {
                                                                                if($code_invalid)
				$msg = "Mã bảo vệ không đúng";
			if($companyid_check)
				$msg = "Xin vui lòng chọn loại thẻ";			
                                                                                if($companyid_check_exist)
				$msg = "Không tồn tại nhà mạng này";
		}
                                    $sql->close();  
                            }else if($method ="add_money_card"){
                                       $company_id = $_POST["idcheck"];
                                       $pincode = $_POST["pincheck"];
                                       $cardcode = $_POST["thecheck"];
                                       $vailSMS = $_POST["vailSMS"];
                                       $msg = $_POST["check_msg"];
                                        $tab_active = "tab1";
                                        $company_name = get_com($company_id);
                                        if($vailSMS==""){
                                                           $smscode_invaild = true;
                                         }
                                        if( !$smscode_invaild) {
                                                                $sql = new db_sql();
                                                                $sql->db_connect();
                                                                $sql->db_select();
                                                                // nếu smscode khác rỗng thực hiện kiểm tra mã
                                                                $select = "select id  from ".DB_PREFIX."list_request where `user_id` ='".$memberid."' and code_confirm = '".$vailSMS."' ";
                                                                $sql->query($select);
                                                                $row =$sql->fetch_array();
                                                                $id = $row["id"];
                                                                $r = $sql->num_rows();
                                                                // nếu tồn tại mã kiểm tra gửi tới điện thoại ta làm: - check mệnh giá thẻ và trả về số tiền trên hệ thống của bảo kim
                                                                if($r==1){
                                                                                $bk = new BKTransactionAPI("https://www.baokim.vn/the-cao/saleCard/wsdl");//link thật
                                                                                $transaction_id = time();
                                                                                $secure_pass = 'ebc9f951ea3020e8';
                                                                                /*
                                                                                 * API nap the cao dien thoai cho Merchant
                                                                                 * */
                                                                                $info_topup = new TopupToMerchantRequest();
                                                                                $info_topup->api_password = 'likemienphinet978kwjhs';
                                                                                $info_topup->api_username = 'likemienphinet';
                                                                                $info_topup->card_id = $company_id;
                                                                                $info_topup->merchant_id = '11065';
                                                                                $info_topup->pin_field = $pincode;
                                                                                $info_topup->seri_field = $cardcode;
                                                                                $info_topup->transaction_id = $transaction_id;
                                                                                $data_sign_array = (array)$info_topup;
                                                                                ksort($data_sign_array);

                                                                                $data_sign = md5($secure_pass . implode('', $data_sign_array));
                                                                                $info_topup->data_sign = $data_sign;
                                                                                $test = new TopupToMerchantResponse();
                                                                                $test = $bk->DoTopupToMerchant($info_topup);
                                                                                print_r($test);
                                                                                 if($test->error_code==0){
                                                                                                switch($test->info_card)
                                                                                                {
                                                                                                        case 10000 :
                                                                                                                $tien = 10000.000;
                                                                                                                break;
                                                                                                        case 20000 :
                                                                                                                $tien = 20000.000;
                                                                                                                break;
                                                                                                        case 30000 :
                                                                                                                $tien = 30000.000;
                                                                                                                break;
                                                                                                        case 50000 :
                                                                                                                $tien = 50000.000;
                                                                                                                break;
                                                                                                        case 100000 :
                                                                                                                $tien = 100000.000;
                                                                                                                break;
                                                                                                        case 200000 :
                                                                                                                $tien = 200000.000;
                                                                                                                break;
                                                                                                        case 300000 :
                                                                                                                $tien = 300000.000;
                                                                                                                break;
                                                                                                        case 500000 :
                                                                                                                $tien = 500000.000;
                                                                                                                break;
                                                                                                }
                                                                                                      // sau khi lấy được giá trị tiền tương ứng với số thẻ đã nhắn ta lấy thông tin số tiền hiện tại của thành viên rồi cộng tiền vào cho thành viên
                                                                                                $select_money = "Select Gold from ".DB_PREFIX."member where memberid='".$memberid."' and Published=1";
                                                                                                $sql->query($select_money);
                                                                                                if($r =$sql->fetch_array()){
                                                                                                    $mn = $r["Gold"];                                                                                    
                                                                                                }
                                                                                                $mn  += $tien;
                                                                                                $update_mn ="update ".DB_PREFIX."member set Gold='".$mn."' where memberid='".$memberid."'";
                                                                                                $sql->query($update_mn);
                                                                                                // sau khi cộng tiền cho user thành công chúng ta update trạng thái về đã kích hoạt
                                                                                                $update_query = "update ".DB_PREFIX."list_request set publish='1',method='".$method."' where id='".$id."' ";
                                                                                                if($sql->query($update_query)){
                                                                                                               $msg =  "Bạn đã nạp thành công thẻ cào '.$company_name.' với mệnh giá ".number_format($tien,3);
                                                                                                               unset($id,$company_id,$pincode,$cardcode,$vailSMS,$mn,$tien);
                                                                                                }
                                                                                                $sql->close();   
                                                                                               $msg2 ="ok";
                                                                                     }else{
                                                                                           $msg2 ="Mã thẻ không đúng hoặc đã được sử dụng";
                                                                                     }
                                                                            
                                                                }else {
                                                                           $msg2 =  "Mã xác nhận không đung";
                                                                }         
		} 
                            }
            }

function publish(){
     global $pincode,$cardcode,$comid,$msg,$company_name,$pincode,$cardcode,$company_id,$msg2, $addmoney,$bank,$msg3;  
     echo '<div class="left_box_slide naptien">
                	<div class="title"><h3>Nạp tiền tài khoản</h3></div>
                    <div class="content">
                                    <div id="tabContaier1">
                                       <ul>
                                           <li class="active"><a alt="#tab1" class="icon1">Nạp tiền bằng thẻ cào</a></li>
                                           <li><a alt="#tab2" class="icon2">Chuyển khoản bằng internet banking</a></li>
                                       </ul>
                                   </div>
                    	<div class="box_nd">';                     
                                    echo '<div id="tab1" class="tabContents1">
                                        <div class="left">';
                                            if($msg != "check_add_money_ok"){
                                            echo '<div class="error"><p><h2 style="color: red; font-size: 13">'.$msg.'</h2><p></div>
                                                <form id="napthebk" action="'.WEB_DOMAIN.'/giao-dich/nap-tien.html" name="napthebk" onSubmit="return validate()" method="post">
                                        <p class="lable">Chọn nhà mạng</p>
                                            <p class="input">
                                               <select name="loaithe" id="loaithe">';
                                                                for($i=1;$i<=count($comid);$i++){
                                                                            $id_tem = $comid[$i]["id"];
                                                                            echo '<option value="'.$id_tem.'">'.get_com($id_tem).'</option>';
                                                                }                                                                                                                
                                                echo '</select>
                                            </p>
                                            <p class="lable">Mã pin thẻ <span>*</span></p>
                                            <p class="input">
                                                <input name="pincode" id="pincode" type="text" maxlength="20" placeholder="mã pin" value="'.$pincode.'" />
                                            </p>
                                            <p class="lable">Mã thẻ<span>*</span></p>
                                            <p class="input">
                                                <input type="text" name="cardcode" id="cardcode"  type="text" maxlength="20" placeholder="Mã thẻ cào" value="'.$cardcode.'" />
                                            </p>
                                            <p class="lable">Mã xác nhận<span>*</span></p>
                                            <p class="input">
                                                <input type="text" value="" placeholder="Mã xác nhận"  id="code" name="code" />
                                            </p>
                                            <p class="input">
                                                <span class="img_capcha"><img  id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" alt="captcha" /></span>
                                                <span class="fresh"><img id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg" alt="Refresh captcha" /></span>
                                            </p>
                                        </div>
                                        <div class="right">
                                            <p class="note"><span>Chú ý:</span> Quý khách hàng vui lòng kiểm tra kĩ lại thông tin đã nhập “Nhà mạng,mã pin,mã thẻ nạp..trước khi nhấp  Nạp tiền ngay”</p>                                           
                                            <input type="hidden"  value="check_add_money_card" name="method" />                                         
                                             <input type="submit" value="Thực hiện" />
                                        </div>
                                        </form>';
                                                }else if($msg =="check_add_money_ok"){    
                                                    if($msg2 == "ok"){
                                                            echo '<script type="text/javascript">alert("'.$msg2.'");</script>';
                                                            header("Location: ".WEB_DOMAIN."/giao-dich/nap-tien.html");
                                                    }else{
                                                        echo '<div><p><h2 style="color: red; font-size: 13;">'.$msg2.'</h2></p></div>';
                                                    }
                                                    echo '<form  action="'.WEB_DOMAIN.'/giao-dich/nap-tien.html" method="post">
                                                                 <p class="lable">Loại thẻ <span>*</span></p>
                                                                <p class="input">
                                                                    <input type="text" maxlength="20" value="'.$company_name.'" disabled="disabled" />
                                                                </p>
                                                                 <p class="lable">Mã pin thẻ <span>*</span></p>
                                                                <p class="input">
                                                                    <input type="text" maxlength="20" value="'.$pincode.'" disabled="disabled" />
                                                                </p>
                                                                <p class="lable">Mã thẻ<span>*</span></p>
                                                                <p class="input">
                                                                    <input type="text"   type="text" maxlength="20" value="'.$cardcode.'"  disabled="disabled"/>
                                                                </p>
                                                                <p class="lable">Mã xác nhận nạp thẻ <span>*</span></p>
                                                                <p class="input">
                                                                    <input name="vailSMS" id="vailSMS" type="text" maxlength="20" placeholder="mã xác nhận" value="" />
                                                                </p>
                                                                <input type="hidden" class="stbn" value="'.$company_id.'" name="idcheck"  id="idcheck" />
                                                                <input type="hidden" class="stbn" value="'.$pincode.'" name="pincheck"  id="pincheck" />
                                                                <input type="hidden" class="stbn" value="'.$cardcode.'"  name="thecheck" id="thecheck" />                                                                
                                                                <input type="hidden"  value="add_money_card" id="method" name="method" />
                                                                <input type="hidden"  value="'.$msg.'" id="check_msg" name="check_msg" />
                                                                <input type="hidden"  value="add_money_card"  name="method" />  
                                                               <input type="submit"  value="Thực hiện" />
                                                               </div>
                                                               <div class="right">
                                                                <p class="note"><span>Chú ý:</span> Quý khách hàng vui lòng kiểm tra kĩ lại thông tin đã nhập “Nhà mạng,mã pin,mã thẻ nạp..trước khi nhấp  Thực hiện”</p>     
                                                            </div>';                                                        
                                                    echo '</form>';
                                                }
                                    echo '</div>';                                                                   
                                    echo '<div id="tab2" class="tabContents1">                                      
                                                        <div class="left">                 
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
                                                                                                <input   id="moneyadd" type="text" maxlength="11" value="" data-target="moneyadd" />
                                                                                    </p>
                                                                                    <p class="input" style="font-style:italic; color:#E74310; font-size:11px">
                                                                                       " Số tiền nạp phải nằm trong khoảng từ 10.000 vnđ đến 100.000.000 vnđ"
                                                                                    </p>
                                                                                    <p class="lable">Phí dịch vụ <span class="phi" style="">0%</span><input type="hidden" value="0" id="rose_money" name="rose_money"></p>
                                                                                    <p class="lable"  style="margin:10px 0px">Số tiền nhận được sau khi trừ phí dịch vụ</p>
                                                                                     <input  id="addmoney" type="text" maxlength="20" value="" disabled="disabled" style="width:252px; padding:4px 3px; border:1px solid #ddd; color:#666"/>
                                                                                    <p class="lable">Mã xác nhận<span>*</span></p>
                                                                                    <p class="input">
                                                                                            <input type="text" value="" placeholder="Mã xác nhận"  id="captcha-code" name="code" />
                                                                                    </p>
                                                                                    <p class="input">
                                                                                        <span class="img_capcha"><img  id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" alt="captcha" /></span>
                                                                                        <span class="fresh"><img id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg" alt="Refresh captcha" /></span>
                                                                                    </p>
                                                                                    <div class="clear"></div>
                                                                                    <p class="note"><span>Chú ý:</span> Quý khách hàng vui lòng kiểm tra kĩ lại thông tin đã nhập “Ngân hàng,Số tiền muốn nạp..trước khi nhấp  Xác nhận”</p>                                                                                      
                                                                                    <input type="hidden" value="add_money_banking" id="method_add_bank">
                                                                                    <input type="button" value="Xác nhận" name="" onclick="check_add_money_bank()" />          
                                                                    </form>
                                                        </div>                                        
                                    </div>';
                              
                                echo '</div><!--box_nd-->
                    </div>
                </div><!--left_box-->';
}

?>