<?php
session_start();
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home</a>");
}


if($Webdesign == 'hoadon'){
            $sql = new db_sql();
            $sql->db_connect();
            $sql->db_select();
            $select = "select sanpham_id,sanpham_soluong,`ky_danh`, `coquan`, `diachi`, `dienthoai`, `fax`, `email` from hoa_don order by id desc limit 1";
            $sql->query($select);
            if($row = $sql->fetch_array()){
            $hoadon_spid = $row['sanpham_id'];
            $hoadon_spsl = $row['sanpham_soluong'];
            $name = $row['ky_danh'];
            $office = $row['coquan'];
            $address = $row['diachi'];
            $tel = $row['dienthoai'];
            $fax = $row['fax'];
            $email = $row['email'];
            }
$sql->close();
}
 $sp_id = explode(";", $hoadon_spid);
$sp_sl = explode(";", $hoadon_spsl);
$title = array("hoadin" => "Hóa đơn",);

$body_tem = "";

      for($i=0; $i< count($sp_id)-1; $i++){
                                            $tt = $tt + 1;                
                                            $id = $sp_id[$i];
                                            $temp = get_intro_sanpham1($id);
                                            if($temp["km"]==1){
                                                    $gia_tem = $temp['gia_km'];
                                                    $tc=$sp_sl[$i]*$temp['gia_km'];
                                            }  else {
                                                 $gia_tem = $temp['gia'];
                                                $tc=$sp_sl[$i]*$temp['gia'];
                                               
                                            }
                                            $tcl=$tcl+$tc;
                                         $body_tem= $body_tem.' <tr>
                                                <td class="width1"><p class="title">'.$temp["ten"].'</p></td>
                                                <td class="width2">'.$sp_sl[$i].'</td>                                  
                                               <td class="width4">'.number_format($gia_tem,0).' VNĐ</td>
                                                <td class="width3">'.  number_format($tc,0).' VNĐ</td>
                                            </tr>';
      }
      $body_tem = $body_tem.'  <tr class="end">
                                        <td colspan="3">Tổng giá trị đơn hàng của bạn</td>
                                        <td class=" width3 tong">'.  number_format($tcl,0).' VNĐ</td>
                                    </tr>';









   ob_start();
        $mail_content = ob_get_contents();
        require_once 'extsource/phpmailer/class.phpmailer.php';
        $mail  = new PHPMailer();
     
        $body  = '<table border="0" width="100%">
                    <tr>
                        <td width="100">Tên khách hàng:</td>
                        <td>'.$name.'</td>
                    </tr>
                    <tr>
                        <td>Cơ quan:</td>
                        <td>'.$office.'</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ liên hệ:</td>
                        <td>'.$address.'</td>
                    </tr>
                    <tr>
                        <td>Điện thoại:</td>
                        <td>'.$tel.'</td>
                    <tr>
                        <td>Tiêu đề:</td>
                        <td>'.$titlec.'</td>
                    </tr>
                    </table>
                   <br>
                    
    <table style="width:715px; border:1px solid #f0f0f0;">
            <tr>                                      
            <td>Sản phẩm</td>
             <td>Số lượng</td>
             <td>Giá</td>
             <td>Tổng tiền</td>
         </tr>'.$body_tem.'</table>';
        
        $body       = eregi_replace("[\]",'',$body);
        $mail->IsSMTP(); 
        $mail->SMTPAuth   = true;                
        $mail->SMTPSecure = "ssl";                 
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 465;                 
        $mail->Username   = "info@hoanggia.net";  
        $mail->Password   = "info@hoanggia.net";          
        $mail->SetFrom('iwcofms@gmail.com', 'Lê Văn Kiên');
        $mail->AddReplyTo("iwcofms@gmail.com","Hoang Gia Media");
        $mail->Subject    = "Thong tin dat hang tu website ".WEB_DOMAIN."";
        $mail->CharSet = "utf-8";
        $mail->MsgHTML($body);
        $address = "kienlv@hoanggia.biz";
        $mail->AddAddress($address , $name);
        $mail->AddBCC($email, $name);
        $mail->Send();                      













function publish(){ 
	global $mycart,$dir_imgproducts1,$sp_id,$sp_sl,$gia_tem;
      
                echo '<div class="right_midle">
                    <div class="cols_right thongtin_giohang">
                    	<div class="title">HOA ĐƠN</div>                 
                                 
                                    <table style="width:715px;">
                                    <tr class="one">
                            	<td colspan="4"><a href="'.WEB_DOMAIN.'"><img src="'.TPL_LINK.'/images/tieptucmua.png" alt="" /></a></td>
                            </tr>
                                      
                                    <tr class="two">                                      
                                       <td class="width1">Sản phẩm trong giỏ hàng của bạn</td>
                                        <td class="width2">Số lượng</td>
                                        <td class="width4">Giá</td>
                                        <td class="width3">Tổng tiền</td>
                                    </tr>';
                                        for($i=0; $i< count($sp_id)-1; $i++){
                                            $tt = $tt + 1;                
                                            $id = $sp_id[$i];
                                            $temp = get_intro_sanpham1($id);
                                            if($temp["km"]==1){
                                                    $gia_tem = $temp['gia_km'];
                                                    $tc=$sp_sl[$i]*$temp['gia_km'];
                                            }  else {
                                                 $gia_tem = $temp['gia'];
                                                $tc=$sp_sl[$i]*$temp['gia'];
                                               
                                            }
                                            $tcl=$tcl+$tc;
                                         echo '  <tr>
                                                <td class="width1"><a><img src="'.WEB_DOMAIN.$dir_imgproducts1.$temp["anh"].'" alt="" /><p class="title">'.$temp["ten"].'</p></a></td>
                                                <td class="width2">'.$sp_sl[$i].'</td>                                  
                                               <td class="width4">'.number_format($gia_tem,0).' VNĐ</td>
                                                <td class="width3">'.  number_format($tc,0).' VNĐ</td>
                                            </tr>';
                                     }                                  
                           echo '
                                    <tr class="end">
                                        <td colspan="3">Tổng giá trị đơn hàng của bạn</td>
                                        <td class=" width3 tong">'.  number_format($tcl,0).' VNĐ</td>
                                    </tr>
                                    </table>                                
                                <div class="loichao">
                        	<p>Cảm ơn quí khách đã mua hàng tại ThanhChi shop</p>
                            <p>Chúng tôi sẽ liên hệ với quý khách</p>
                        </div><!--Loichao-->
                       
                        </div>
                    </div>';
         
}


?>

