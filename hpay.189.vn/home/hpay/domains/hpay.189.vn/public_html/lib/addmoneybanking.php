<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>Trang ch&#7911;</a>");
                }
                session_start();
                if($Auth["memberid"] < 1){
                        header("Location: /login.html");
                        exit;
                }

                if(isset($_GET["Webdesign"]) && $_GET["Webdesign"]=="addmoneybanking")
                    $method_addbank  = $_GET["method"];


                function thongtincanhan(){
                     global $addmoney,$bank,$moneyadd,$method_addbank;    
                    echo '<div class="fLeft sub-right sub-cont-r">
                        <span class="fLeft tl">&nbsp;</span>
                        <span class="fLeft tc tcr">&raquo; Thông tin ngân hàng</span>
                        <span class="fLeft tl tr">&nbsp;</span>
                        <div class="fLeft sub-right s-c-r cont-sub-right">
                            <div class="fLeft contNews">                
                                <div class="cont-tabs-dk fastReg">
                                    <form id="update-form" action="" >
                                               <div>
                                                            <ul class="laylaimk">                                          
                                                                                 <li class="inputName">Chọn ngân hàng</li>
                                                                                <li class="inputName inputText">
                                                                                                <select name="bank_id" id="bank_id">
                                                                                                            <option value="0">-- Chọn ngân hàng --</option>';
                                                                                                            for($i=1;$i<=count($bank);$i++){
                                                                                                                echo '<option value="'.$bank[$i]["id"].'">'.$bank[$i]["title"].'</option>';
                                                                                                            }
                                                                                                echo '</select>
                                                                                </li>

                                                                                <li class="inputName">Số tiền muốn nạp (<span class="red">*</span>)<br />(Chưa trừ phí)</li>
                                                                                <li class="inputName inputText">
                                                                                                    <input name="moneyadd" id="moneyadd" type="text" maxlength="11" value="'.$moneyadd.'" data-target="moneyadd" /><br />
                                                                                                     <p style="width: 382px">(Số tiền nạp phải nằm trong khoảng từ 10.000₫ đến 100.000.000₫)</p>
                                                                                 </li>
                                                                                 <li class="inputName">Phí dịch vụ (<span class="red">*</span>)</li>
                                                                                <li class="inputName inputText">
                                                                                                     (0%)
                                                                                </li>                                 
                                                                                <li class="inputName">Số tiền nhận (<span class="red">*</span>)<br />(Sau khi trừ phí)</li>
                                                                                <li class="inputName inputText">     
                                                                                                <input name="addmoney" id="addmoney" type="text" maxlength="20" value="'.$addmoney.'" disabled="disabled"/><br />
                                                                                 </li>
                                                                                  <li class="inputName">Mã số an toàn(<span class="red">*</span>)</li>
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
                                                        <input type="hidden"  value='.$method_addbank.'  id="method_add_bank" /> 
                                                        <input type="button" class="stbn" value="Xác nhận" onclick="check_add_money_bank()" />
                                                    </p>
                                            </form> 
                                            </div>
                                    </div>
                                    </div>
                               <span class="fLeft bc bc-r">&nbsp;</span>
                    </div>';
                }
?>