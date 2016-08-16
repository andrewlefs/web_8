<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>Home</a>");
                }
                global $dmail;

                $sql = new db_sql();
                $sql->db_connect();
                $sql->db_select();
                 $spid = "";
                 $sl = "";
                 if($HTTP_POST_VARS["module"] == "checkout" && isset($HTTP_POST_VARS["mode"]) && $HTTP_POST_VARS["mode"]=="send")
                {
		$name 		= convert_font(trim($_POST["name"]));
		$address	= convert_font(trim($_POST["address"]));
		$email 		= convert_font(trim($_POST["email"]));
		$content	= convert_font(trim($_POST["content"]));
		if($name 	== "") $message1 = $message1."<li/>Bạn chưa nhập họ tên\n";
		if($tel 	== "") $message1 = $message1."<li/>Bạn chưa nhập điện thoại\n";		
		if($email 	== "") $message1 = $message1."<li/>Bạn chưa nhập email\n";
		if($email !='')
                                                    if (!eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $email))
                                                            $message1 = $message1."<li/>Bạn nhập Email chưa hợp lệ\n";		

                                                     if(empty($_SESSION['code'] ) ||
                                                                    strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                                    $message1 = $message1."Mã bảo vệ không đúng";
                                                        }

                    
                                                        for($i=0;$i<count($mycart);$i++){
                                                                $spid = $spid.$mycart[$i]["pid"].";";
                                                                $sl = $sl.$mycart[$i]["qty"].";";
                                                            }
                                                            
                                                  
//	ob_start();
//        $mail_content = ob_get_contents();
//        require_once 'extsource/phpmailer/class.phpmailer.php';
//        $mail  = new PHPMailer();
//        $body  = '<table border="0" width="100%">
//                    <tr>
//                        <td width="100">Tên khách hàng:</td>
//                        <td>'.$name.'</td>
//                    </tr>
//                    <tr>
//                        <td>Địa chỉ liên hệ:</td>
//                        <td>'.$address.'</td>
//                    </tr>
//                    <tr>
//                        <td>Điện thoại:</td>
//                        <td>'.$tel.'</td>
//                    <tr>
//                        <td>Tiêu đề:</td>
//                        <td>'.$titlec.'</td>
//                    </tr>
//                    </table><br>
//                    
//                    <table style="width:715px; border:1px solid #f0f0f0;">
//                            <tr class="two">                                      
//                            <td class="width1">Sản phẩm</td>
//                             <td class="width2">Số lượng</td>
//                             <td class="width4">Giá</td>
//                             <td class="width3">Tổng tiền</td>
//                         </tr>';
//                        $count_cart = count($_SESSION["mycart"]);
//                        for($i=0;$i<$count_cart;$i++){
//                                          $thanhtien = ($mycart[$i]['qty'] * $mycart[$i]["gia"]);
//                                         $tongcong = $tongcong + $thanhtien;
//                                         echo '  <tr>
//                                                <td class="width1"><a><img src="'.WEB_DOMAIN.$dir_imgproducts1.$mycart[$i]["anh"].'" alt="" /><p class="title">'.$mycart[$i]["ten"].'</p></a></td>
//                                                <td class="width2"><p><input  type=text  name="qty_'.$mycart[$i]['pid'].'" value="'.$mycart[$i]['qty'].'" id="soluong_'.$mycart[$i]['pid'].'" /></p><p class="save"><a href="Javascript:UpdateItem('.$mycart[$i]['pid'].');">Lưu lại >></a></p><p class="detele"><a href="Javascript:deleteItem('.$mycart[$i]['pid'].');">Xóa sản phẩm</a></p></td>                                  
//                                               <td class="width4">'.  number_format($mycart[$i]["gia"],0).' VNĐ</td>
//                                                <td class="width3">'.  number_format($thanhtien,0).' VNĐ</td>
//                                            </tr>';
//                                     }
//                            echo '<tr class="end">
//                                        <td colspan="3">Tổng giá trị đơn hàng của bạn</td>
//                                        <td class=" width3 tong">Tổng tiền</td>
//                                    </tr>
//                                </table>';
//        
//        $body       = eregi_replace("[\]",'',$body);
//        $mail->IsSMTP(); 
//        $mail->SMTPAuth   = true;                
//        $mail->SMTPSecure = "ssl";                 
//        $mail->Host       = "smtp.gmail.com";      
//        $mail->Port       = 465;                 
//        $mail->Username   = "info@hoanggia.net";  
//        $mail->Password   = "info@hoanggia.net";          
//        $mail->SetFrom('info@hoanggia.net', 'Hoang Gia Media');
//        $mail->AddReplyTo("contact@hoanggia.net","Hoang Gia Media");
//        $mail->Subject    = "Thong tin dat hang tu website ".WEB_DOMAIN."";
//        $mail->CharSet = "utf-8";
//        $mail->MsgHTML($body);
//        $address = "contact@hoanggia.net";
//        $mail->AddAddress($address , $name);
//        $mail->AddBCC($email, $name);
//        $mail->Send(); 
      
     if($message1==""){
               $insert_query = "insert into hoa_don(sanpham_id,sanpham_soluong,noi_dung,ky_danh,diachi,dienthoai,email) values('$spid','$sl','$content','$name','$address','$tel','$email')";
                $sql->query($insert_query);
                    unset($_SESSION["mycart"]);
                   echo "<script type='text/javascript'>alert('Đặt hàng thành công');         
                       window.location.reload();
                       window.location.replace('".WEB_DOMAIN."/index.html');
                         </script>";
                      }else{  
                           echo "<script type='text/javascript'>alert('Bạn chưa điền đầy đủ thông tin');                                                  
                                                          window.location.reload();
                                                  </script>";
                      }
             
        }

function publish(){ 
	global $mycart,$message,$message1,$dir_imgproducts1 ;
	$count_cart = count($mycart);
	if($count_cart > 0){
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();	
		for($i=0;$i<$count_cart;$i++){	
			$select_query = "SELECT SanphamID, ten, anh, gia FROM sanpham WHERE SanphamID = ".$mycart[$i]['pid'];
			$sql->query($select_query);
			if($rows = $sql->fetch_array()){ 
				$mycart[$i]["ten"] = $rows["ten"];
				$mycart[$i]["gia"] = $rows["gia"];
                                $mycart[$i]["anh"] = $rows["anh"];
                                $mycart[$i]["url"] = WEB_DOMAIN.'/istore/'.$rows["SanphamID"].'-'.huu($rows["ten"]).'.html';
			}
		}
		$sql->close();

                echo '<div class="style1">
                        <div class="tab_content cart">
                        <h3>Thông tin đặt hàng</h3>
               		<div class="cart-page">                       
                                                                    <table cellspacing="0" cellpadding="0" class="show_cart_table">
                                                                         <tbody>
                                                                           <tr class="text_title">
                                                                             <td width="1%">STT</td>
                                                                             <td>Tên sản phẩm</td>                           
                                                                             <td width="20%">Giá (VNĐ)</td>
                                                                             <td width="10%">Số Lượng</td>
                                                                             <td width="20%">Tổng (VNĐ)</td>
                                                                           </tr>';
                                                                         for($i=0;$i<$count_cart;$i++){                      
                                                                             $thanhtien = ($mycart[$i]['qty'] * $mycart[$i]["gia"]);
                                                                             $tongcong = $tongcong + $thanhtien;                
                                                                             echo '<tr>
                                                                             <td class="No" align="center">'.($i+1).'</td>
                                                                             <td><a rel="nofollow" href="'.$mycart[$i]["url"].'" class="text_link"><img src="'.WEB_DOMAIN.$dir_imgproducts1.$mycart[$i]["anh"].'"/>'.$mycart[$i]["ten"].'</a></td>                              
                                                                             <td align="center" class="price">'.gia($mycart[$i]["gia"]).'</td>
                                                                             <td align="center">'.$mycart[$i]['qty'].'</td>
                                                                             <td align="center" class="price">'.gia($thanhtien).'</td>
                                                                       </tr>';
                                                                         }
                            					
                                                                    echo '  </tbody>
                                                                              </table>
                                                                              <div class="khoangcach">Mời bạn nhập đầy đủ thông tin đặt hàng</div>';
                                                                                if($message!='')  echo	"<div class='message'>".$message."</div>\n"; 
                                                                                        if($message1!='') echo 	"<div class='message'>".$message1."</div>\n";
                                                                              echo '<table>
                                                                                 <tbody>
                                                                              <tr>
                                                                                                <form id="form" action="'.WEB_DOMAIN.'/checkout.html" method="post">
                                                                                                                    <div class="contact-form block-right">
                                                                                                                                <div class="row">
                                                                                                                                    <input type="text" name="name"  class="txtcontactName textbox" value="Tên người nhận hàng" onfocus="javascript:if (this.value ==\'Tên người nhận hàng\')  this.value = \'\';"  onblur="if(this.value==\'\')this.value=\'Tên người nhận hàng\';" >
                                                                                                                                </div>
                                                                                                                                <div class="row">
                                                                                                                                    <input type="text" name="email"  class="txtcontactEmail textbox" value="Địa chỉ email" onfocus="javascript:if (this.value ==\'Địa chỉ email\') this.value = \'\';" onblur="if(this.value==\'\')this.value=\'Địa chỉ email\';" >
                                                                                                                                </div>
                                                                                                                                <div class="row">
                                                                                                                                    <input type="text" name="address"  class="txtcontactdiachi textbox" value="Địa chỉ người nhận" onfocus="javascript:if (this.value ==\'Địa chỉ người nhận\') this.value =\'\';"  onblur="if(this.value==\'\')this.value=\'Địa chỉ người nhận\';" >
                                                                                                                                </div>
                                                                                                                                <div class="row">
                                                                                                                                    <input type="text"  name="tel"  class="txtcontactAddress textbox" value="Điện thoại người nhận" onfocus="javascript:if (this.value == \'Điện thoại người nhận\') this.value =\'\';" onblur="if(this.value==\'\')this.value=\'Điện thoại người nhận\';">
                                                                                                                                </div>
                                                                                                                                <div class="row">
                                                                                                                                    <textarea  class="txtcontactMessage textbox textarea" name="content" onfocus="javascript:if (this.value == \'Thông tin khác\') this.value = \'\';" onblur="if(this.value==\'\')this.value=\'Thông tin khác\';">Thông tin khác</textarea>
                                                                                                                                </div>

                                                                                                                               <div class="row">
                                                                                                                                            <input type="text" id="code" name="code"  class="captcha txtcontactCaptcha textbox" value="Captcha" onfocus="javascript:if (this.value ==\'Captcha\') this.value = \'\';"  onblur="if(this.value==\'\')this.value=\'Captcha\';">
                                                                                                                                            <span class="captcha-image">
                                                                                                                                                    <img   id="captcha" class="imgCatcha middle " alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php?>">
                                                                                                                                            </span>
                                                                                                                                                    <a class="refresh new-captcha imgRefreshCaptcha">
                                                                                                                                                            <img id="captcha-refresh"  alt="Refresh captcha" src="'.WEB_DOMAIN.'/extsource/refresh.jpg">
                                                                                                                                                    </a>
                                                                                                                                </div>
                                                                                                                                <div class="row text-right">
                                                                                                                                            <input class="cmdContactReset button" name="reset" type="reset" value="Làm lại" />
                                                                                                                                             <input class="cmdContactSend button buttonspecial" name="mode" type="submit" value="Đặt hàng" />
                                                                                                                                             <input name="module" type="hidden" value="checkout">
                                                                                                                                             <input name="mode"   type="hidden" value="send">
                                                                                                                                </div>
                                                                                                                 </div>
                                                                                                        </form>
                                                                                                 </tr>
                                                                                </tbody>
                                                                              </table>                                                                           
                                                                            </div>  
                                                                    </div>
                                                            </div>';
                                  }
                                else {            
                                          echo '<div class="stt">
                                               <div class="global"><a class="ico" href="#"><img src="'.TPL_LINK.'/images/ico_giohang.png" /></a><span> Bạn có <span class="aactive" >'.$count_cart.' sản phẩm</span>  trong giỏ hàng </span></div>
                                               </div>';
                              }
	
}
?>