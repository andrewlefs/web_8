<?php
            define("qaz_wsxedc_qazxc0FD_123K",true);
            $msg =  '';
            if($_SERVER['REQUEST_METHOD']=='GET'  && isset($_GET["get_method"])){
                        $get_method = $_GET["get_method"];
                        $type_catalog = $_GET["type_catalog"];
                        switch ($type_catalog){
                            case "mobile":
                                if($get_method==1){
                                    $msg = 'Số điện thoại cần nạp thẻ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="text" name="get_phone" id="get_phone" style="width: 178px;">';
                                }
                                break;
                            case "game":
                                if($get_method==1){
                                             $msg = 'Tên tài khoản game: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="get_account_game" id="get_account_game" style="width: 178px;">';
                                }
                                break;
                             case "both":
                                if($get_method==1){
                                             $msg = 'Số điện thoại cần nạp thẻ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="get_phone" id="get_phone" style="width: 178px;"> <br />';
                                             $msg .= 'Tên tài khoản game: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="get_account_game" id="get_account_game" style="width: 178px;">';
                                }
                                break;
                             case "software":
                                if($get_method==1){
                                              $msg = 'Số điện thoại nhận thẻ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="get_phone" id="get_phone" style="width: 178px;">';
                                }
                                break;                                
                        }
            }
echo $msg;
?>
