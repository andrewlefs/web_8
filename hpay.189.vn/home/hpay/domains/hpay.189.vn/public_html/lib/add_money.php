<?php
            define("qaz_wsxedc_qazxc0FD_123K",true);
         
                        
            $phpbb_root_path = '../config/';
            include($phpbb_root_path."mysql.php");
            include($phpbb_root_path."config.php");
            include($phpbb_root_path."function.php");              
             include($phpbb_root_path."global.php");   
            include('../extsource/BKTransactionAPI.php');
            
            $smscode_invaild = FALSE;
        
            if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="addmoneycard_confirm"){
	$action = $_GET["action"];
                            $msg =  '';
	if($action=="add_confirm"){
		$loaithe = $_GET["loaithe"];		
                                                     $cardcode = $_GET["cardcode"];
                                                     $pincode = $_GET["pincode"];
                                                     $vailSMS = $_GET["code"];
                                                     $sessionValue = $_GET["sessionValue"];
                                                     if($vailSMS==""){
                                                            $smscode_invaild = true;
                                                     }
                                                   
		if( !$smscode_invaild) {
                                                                $sql = new db_sql();
                                                                $sql->db_connect();
                                                                $sql->db_select();
                                                                // nếu smscode khác rỗng thực hiện kiểm tra mã
                                                                $select = "select id,code_confirm from ".DB_PREFIX."list_request where `user_id` ='".$sessionValue."' and code_confirm = '".$vailSMS."' ";
                                                                $sql->query($select);
                                                                $row =$sql->fetch_array();
                                                                $id = $row["id"];
                                                                $r = $sql->num_rows();
                                                                // nếu tồn tại mã kiểm tra gửi tới điện thoại ta làm: - check mệnh giá thẻ và trả về số tiền trên hệ thống của bảo kim
                                                                if($r==1){
                                                                                //------------Chon mang--------------------
                                                                                $ten = get_com($loaithe);                                                                            
                                                                                //-------end chon mang-----------------
                                                                                
                                                                                $bk = new BKTransactionAPI("https://www.baokim.vn/the-cao/saleCard/wsdl");//link thật
                                                                                $transaction_id = time();
                                                                                $secure_pass = 'ebc9f951ea3020e8';
                                                                                /*
                                                                                 * API nap the cao dien thoai cho Merchant
                                                                                 * */
                                                                                $info_topup = new TopupToMerchantRequest();
                                                                                $info_topup->api_password = 'likemienphinet978kwjhs';
                                                                                $info_topup->api_username = 'likemienphinet';
                                                                                $info_topup->card_id = $loaithe;
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
                                                                                                $select_money = "Select Gold from ".DB_PREFIX."member where memberid='".$sessionValue."' and Published=1";
                                                                                                $sql->query($select_money);
                                                                                                if($r =$sql->fetch_array()){
                                                                                                    $mn = $r["Gold"];                                                                                    
                                                                                                }
                                                                                                $mn  += $tien;
                                                                                                $update_mn ="update ".DB_PREFIX."member set Gold=$mn where memberid='".$sessionValue."'";
                                                                                                $sql->query($update_mn);
                                                                                                // sau khi cộng tiền cho user thành công chúng ta update trạng thái về đã kích hoạt
                                                                                                $update_query = "update ".DB_PREFIX."list_request set publish='1' where id='".$id."' ";
                                                                                                if($sql->query($update_query)){
                                                                                                               $msg =  "Bạn đã thanh toán thành công thẻ cào '.$ten.' với mệnh giá ".number_format($tien,3);
                                                                                                               unset($id,$loaithe,$pincode,$cardcode,$vailSMS,$mn,$tien);
                                                                                                }
                                                                                                $sql->close();   
                                                                                }else {
                                                                                                $msg =  "check_card";
                                                                                }
                                                                              
                                                                }else {
                                                                            $msg = "check_sms";
                                                                }         
		} 
	} 
        }
   
        echo $msg;

?>
