<div class="main">
                <div class="top_main">
                                    <?top_main()?>
                </div><!--top_main-->
                <div class="clear"></div>
                <div class="midle_main">
                                <div class="box_slide quantri">
                                                 <?publish()?>
                                                   <div class="right_box_slide">
                                                        <div class="cols_right member">
                                                                <div class="title"><h3>Hệ thống quản trị</h3></div>
                                                            <div class="content">
                                                                <ul>
                                                                    <li <?=$_GET["Webdesign"]=="editaccount"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/usercp.html">Thông tin tài khoản</a></li>
                                                                    <li <?=$_GET["Webdesign"]=="changepass"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/change-pass.html">Đổi mật khẩu</a></li>
                                                                    <li <?=$_GET["Webdesign"]=="addmoney"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/giao-dich/nap-tien.html">Nạp tiền trực tuyến</a></li>
                                                                    <li <?=$_GET["Webdesign"]=="request"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/request.html">Nạp tiền tại văn  phòng</a></li>
                                                                 <!--   <li <?=$_GET["Webdesign"]=="bank"?"class='active'":""?><?=$_GET["Webdesign"]=="bankadd"?"class='active'":""?> ><a href="<?=WEB_DOMAIN?>/bank.html">Tài khoản ngân hàng</a></li>-->
                                                                    <li <?=$_GET["Webdesign"]=="tradding"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/tradding.html">Thống kê giao dịch</a></li>
                                                                    <li <?=$_GET["Webdesign"]=="hoadon"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/hoadon.html">Thống kê hóa đơn</a></li>                                                                    
                                                                    <li <?=$_GET["Webdesign"]=="sendTo"?"class='active'":""?>><a href="<?=WEB_DOMAIN?>/sendTo.html">Chuyển khoản</a></li>
                                                                </ul>
                                                            </div>
                                                        </div><!--cols-->
                                                        </div>
                                                        </div><!--box_slide-->
                                </div><!--box_slide-->
                                <div class="clear"></div>                              
                <div class="clear"></div>
                <div class="bottom_main">
                                <?bottom_main()?>
                </div>
        </div><!--main-->
        <div class="clear"></div>