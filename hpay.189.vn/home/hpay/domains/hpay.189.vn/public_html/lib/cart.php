<?php
            if (!defined("qaz_wsxedc_qazxc0FD_123K")){
                            die("<a href='../index.php'>Home Page</a>!");
            }
            session_start();
            if($_GET[Webdesign]="cart" && $_GET[mode]=="add-ajax"){
                            $pid = isset($_GET["pid"]) && is_numeric($_GET["pid"]) ? $_GET["pid"] : 0;
                            $qty = isset($_GET["qty"]) && is_numeric($_GET["qty"]) ? $_GET["qty"] : 1;          
                            $_SESSION["pid"] = $pid;
                            $_SESSION["pty"] = $qty;
            }
            $title = array("cart" => "Giỏ hàng của bạn | my cart", );
            
            function right_content(){
                global $mycart;
                echo '<div class="fLeft sub-right sub-cont-r">
        <span class="fLeft tl">&nbsp;</span>
        <span class="fLeft tc tcr">» Mua thẻ: Viettel</span>
        <span class="fLeft tl tr">&nbsp;</span>
        <div class="fLeft sub-right s-c-r cont-sub-right">
            <div class="fLeft contNews">

                <form id="buyCard" action="/product/buy.html" method="post" onsubmit="return false;">
                <table cellpadding="0" cellspacing="5" border="0" width="100%">
                    <tbody><tr>
                        <th width="33%" align="left" valign="top">Loại thẻ</th>
                        <th width="33%" align="left" valign="top">Mệnh giá</th>
                        <th width="33%" align="left" valign="top">Số lượng</th>
                    </tr>
                    <tr>
                        <td>Viettel</td>
                        <td>10,000 VNĐ.</td>
                        <td>'.$_SESSION["qty"].'</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" valign="top">
                            Vui lòng chọn hình thức thanh toán: &nbsp;&nbsp;
                            <select name="orderType" class="cardPrice" style="width:180px; margin-right: 30px;">
                                <option value="0">-- Kiểu thanh toán --</option>
                                <option value="1">Trừ trực tiếp vào tài khoản</option>
                                <option value="2">Thông qua Bảo Kim</option>
                                <option value="3">Thông qua Ngân Lượng</option>
                            </select>
                            <br><span id="error_orderType" class="error"></span>
                        </td>
                        <td>
                            <input type="hidden" name="YII_CSRF_TOKEN" value="83f5c5febfc4e4445a86351a76b62ee985a8a48c">
                            <input type="hidden" name="cardType" value="20">
                            <input type="hidden" name="sluong" value="43">
                                                        <input type="button" class="stbn" id="buttonBuyCard" value="Mua" onclick="$.showNeedLogin();"><br><br>
                        </td>
                    </tr>
                    <tr><td colspan="3" style="padding-left: 80px;"><div class="error" id="error_buyStatus">Bạn phải đăng nhập mới có thể sử dụng được chức năng này.</div></td></tr>
                    <tr>
                        <td colspan="3" style="padding-left: 80px;">
                        <div id="error_cardResult"></div>
                        </td>
                    </tr>
                </tbody></table>
                </form>
            </div>
        </div>
        <span class="fLeft bc bc-r">&nbsp;</span>
    </div>';
            }


?>