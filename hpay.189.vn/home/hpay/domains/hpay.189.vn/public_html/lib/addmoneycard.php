<?php
                        if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                        die("<a href='../index.php'>Trang ch&#7911;</a>");
                        }
                        if($Auth["memberid"] < 1){
                                header("Location: /login.html");
                                exit;
                        }                       
                    
                        if( isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="addmoneycard"){
                            $method_add_card  = $_GET["method"]; 
                        }                        
               
                    function thongtincanhan(){
                        global $pincode,$cardcode,$method_add_card,$comid;                        
                        echo '<div class="fLeft sub-right sub-cont-r">
                            <span class="fLeft tl">&nbsp;</span>
                            <span class="fLeft tc tcr">&raquo; Thông tin thẻ nạp</span>
                            <span class="fLeft tl tr">&nbsp;</span>
                            <div class="fLeft sub-right s-c-r cont-sub-right">
                                <div class="fLeft contNews">                
                                    <div class="cont-tabs-dk fastReg">
                                        <form id="napthebk" action="" name="napthebk" onSubmit="return validate()">
                                                     <div>
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
                                                                                                    <img src="'.WEB_DOMAIN.'/extsource/get_captcha.php" alt="" id="captcha">
                                                                                                </span>
                                                                                                <span class="captcha_img"><img src="'.WEB_DOMAIN.'/extsource/refresh.jpg" alt="captcha"  id="captcha-refresh"></span>
                                                                                     </li>
                                                                </ul>
                                                        </div>
                                                        <div class="clear margin-top">&nbsp;</div>
                                                        <p align="right">
                                                            <input type="button" class="stbn" value="Xác nhận" id="stbn" />                                       
                                                            <input type="hidden"  value="'.$method_add_card.'" id="method" />     
                                                        </p>
                                                </form> 
                                                </div>
                                        </div>
                                         
                        </div>
                        <span class="fLeft bc bc-r">&nbsp;</span>
                        </div>';
                    }
?>