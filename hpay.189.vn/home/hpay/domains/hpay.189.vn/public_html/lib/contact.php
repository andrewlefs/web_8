<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home</a>");
}

$title = array(	"contact" => "Liên hệ",);
$message1 = "";
if(isset($_POST["mode"]) && $_POST["mode"]=="send"){	
$name 		= $_POST["hoten"];

$address	= $_POST["diachi"];
$tel		= $_POST["dienthoai"];
$email 		= $_POST["email"];

$content 	= $_POST["noidung"];

if($name 	== "") $message1 = $message1."Bạn chưa nhập họ tên<br />";
if($email 	== "") $message1 = $message1."Bạn chưa nhập email<br />";
                                     if($tel    == 0 || !is_numeric($tel)) $message1 = $message1."Hãy nhập phone hoặc dữ liệu nhập chưa đúng kiểu<br />";
if($email !='')
        if (!eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $email))
                $message1 = $message1."Bạn nhập Email chưa hợp lệ<br />";		

if($content == "") $message1 = $message1."Bạn chưa nhập nội dung<br />";
                                    if(empty($_SESSION['code'] ) ||
                                    strcasecmp($_SESSION['code'], $_POST['code']) != 0) {
                                                $message1 = $message1."Mã bảo vệ không đúng<br />";
                                        }
                                if(empty($message1)){
                                                $sql = new db_sql();
                                                $sql->db_connect();
                                                $sql->db_select();		
                                                if($message1 ==""){
                                                        $time = date("Y-m-d");
                                                        $insert_query = "INSERT INTO ".DB_PREFIX."contact(name, address, email, tel, content, senddate) VALUES('$name', '$address', '$email', '$tel', '$content', '$time')";			
                                                        if($sql->query($insert_query)){	
                                                        $message1 = "ok";
                                                        unset($name, $email, $tel, $content, $address);				
                                                        }		
                                                        $sql->close();	
                                                }
                                }
}

function publish(){
       global $message1,$name,$address,$tel,$email,$content;
        echo '<div class="title"><h1>Liên hệ</h1></div>
                        <div class="content">
                            <div class="left">
                            <h2>Thông tin liên hệ</h2>';
                                                        if($message1=="ok"){
                                                            echo '<h2 style="color: blue">Cảm ơn bạn ! Thông tin đã được gửi</h2>';
                                                        }else{
                                                            echo '<h2 style="color: red">'.$message1.'</h2>';
                                                        }
                                                        echo '<form method="post" action="'.WEB_DOMAIN.'/lien-he.html">
                                                                            <p><input type="text" name="hoten" value="'.$name.'" placeholder="Họ tên"></p>
                                                                            <p><input type="text" name="email" value="'.$email.'" placeholder="Email"></p>
                                                                            <p><input type="text" name="diachi" value="'.$address.'" placeholder="Địa chỉ"></p>
                                                                            <p><input type="text" name="dienthoai" value="'.$tel.'" placeholder="Số điện thoại"></p>
                                                                            <p><textarea name="noidung">Nội dung</textarea></p>
                                                                            <p>
                                                                                            <input type="text" class="input" id="code" name="code" style="width: 100px;vertical-align: top;" />
                                                                                                            <a href="javascript:;"><img id="captcha"  alt="captcha" src="'.WEB_DOMAIN.'/extsource/get_captcha.php" width="130" height="38" border="0" class="capcha"></a>
                                                                                                            <a href="javascript:refeshCapcha();">
                                                                                                                        <img id="captcha-refresh"  src="'.WEB_DOMAIN.'/extsource/refresh.jpg" style="width:36px; height:27px; border:0px; padding-top: 2px">
                                                                                                            </a>
                                                                            </p>
                                                                            <p class="submit">
                                                                                            <input type="hidden" name="mode" value="send" >
                                                                                              <input type="hidden" name="module" value="contact" >
                                                                                            <input type="submit" value="Gửi yêu cầu">
                                                                            </p>
                                                        </form>
                        </div>
                        <div class="right">
                        <div class="info1">
                                            <h2>Công ty công nghệ truyền thông Hoàng Gia</h2>
                                            <p><span>Địa chỉ:</span>Số 35 Ngõ 1 Bùi Xương Trạch, Thanh Xuân, Hà Nội</p>
                                            <p><span>Số điện thoại:</span>043 550 1189</p>
                                            <p><span>Emai:</span>hpay@hoanggia.net</p>
                        </div>
                        <div class="viewmap">
                                <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=D%C6%B0%C6%A1ng+N%E1%BB%99i,+Hanoi,+Vietnam&amp;aq=0&amp;oq=d%C6%B0%C6%A1ng+n%E1%BB%99i&amp;sll=11.367148,107.542073&amp;sspn=1.666722,2.705383&amp;ie=UTF8&amp;hq=&amp;hnear=D%C6%B0%C6%A1ng+N%E1%BB%99i,+H%C3%A0+%C4%90%C3%B4ng,+H%C3%A0+N%E1%BB%99i,+Vietnam&amp;ll=20.979868,105.743919&amp;spn=0.049607,0.084543&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small>View <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=D%C6%B0%C6%A1ng+N%E1%BB%99i,+Hanoi,+Vietnam&amp;aq=0&amp;oq=d%C6%B0%C6%A1ng+n%E1%BB%99i&amp;sll=11.367148,107.542073&amp;sspn=1.666722,2.705383&amp;ie=UTF8&amp;hq=&amp;hnear=D%C6%B0%C6%A1ng+N%E1%BB%99i,+H%C3%A0+%C4%90%C3%B4ng,+H%C3%A0+N%E1%BB%99i,+Vietnam&amp;ll=20.979868,105.743919&amp;spn=0.049607,0.084543&amp;t=m&amp;z=14" style="color:#0000FF;text-align:left">Vietnam</a> in a larger map</small>
                      </div>
                    </div>
     </div>';
}


?>