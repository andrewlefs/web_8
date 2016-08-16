<?php
                if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
                                die("<a href='../index.php'>home</a>");
                }
                $pro_detail = array();             
                $sql = new db_sql();
                $sql->db_connect();
                $sql->db_select();  
                $msg = "";
                if(isset($_GET["id"]) && $_GET["Webdesign"] == "productdetail"){
                    $id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 0;
                    // tăng lượt xem khi click vào sản phẩm
                    /*$select_query = "SELECT views FROM sanpham WHERE SanphamID=".$id;
                    $sql->query($select_query);
                    $rows = $sql->fetch_array();
                    $views = intval($rows["views"]);
                    $views++; 
                    $update_query = "UPDATE sanpham SET views=$views WHERE SanphamID=$id";
                    if(!$sql->query($update_query))
                    echo 'Loi Update!';	*/
                    $select = "select name,type from ".DB_PREFIX."catalog where id_catalog=$id";
                    $sql->query($select);
                    if($r = $sql->fetch_array()){
                            $title1 = $r["name"];
                            $type_catalog  =  $r["type"];
                    }
                    $select_query = "SELECT `id_product`,`ten`, `gia`,`anh` FROM ".DB_PREFIX."product WHERE id_com_cat in (select id from ".DB_PREFIX."company_catalog where `id_catalog` = $id) ";		
                    $sql->query($select_query);
                    $i = 0;
                    while($row = $sql->fetch_array()){     
                            $i = $i+1;
                            $pro_detail[$i]["id_product"] 	= $row["id_product"];
                            $pro_detail[$i]["ten"] 		= $row["ten"];
                            $pro_detail[$i]["anh"] 		= $row["anh"];                        
                            $pro_detail[$i]["gia"] 		= $row["gia"];                             
                    }
               }
               
               if($_POST["buy"]=="buy"){
                        $qty = $_POST["number"];
                        $cardtype = $_POST["cardtype"];
                        $select_price = "select gia,id_com_cat from ".DB_PREFIX."product  where id_product='".$cardtype."' ";
                        $sql->query($select_price);
                        if($r = $sql->fetch_array()){
                            $price = $r["gia"];
                            $id_com_cat123 = $r['id_com_cat'];
                            $select = "select company_code from ".DB_PREFIX."company where id_company in (select id_company from ".DB_PREFIX."company_catalog where id=$id_com_cat123)";
                            $sql->query($select);
                            if($ro = $sql->fetch_array()){
                                $company_code = $ro["company_code"];
                            }
                        }
                        $msg = "ok";
               }
               
                  $title = array("productdetail" => "$title1", );	
                   $sql->close();

                function right_content(){
                        global $pro_detail,$dir_imgproducts1,$title1,$id,$msg,$qty,$cardtype,$price,$type_catalog,$company_code;    
                        echo '<div class="fLeft sub-right sub-cont-r">
                        <span class="fLeft tl">&nbsp;</span>
                        <span class="fLeft tc tcr">» Mua thẻ: '.$title1.'</span>
                        <span class="fLeft tl tr">&nbsp;</span>
                        <div class="fLeft sub-right s-c-r cont-sub-right">';
                        if($msg ==""){
                                    if(count($pro_detail) > 0){
                                                echo '<div class="fLeft contNews">
                                                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                            <tbody>';
                                                                            for($i=1;$i<=count($pro_detail);$i++){
                                                                                if($i %2!=0){
                                                                                    echo '<tr>';
                                                                                                if(!empty($pro_detail[$i])){
                                                                                                        echo '<td align="center" width="50%">
                                                                                                                    '.$pro_detail[$i]["ten"].'<br />
                                                                                                                    <img src="'.WEB_DOMAIN.$dir_imgproducts1.$pro_detail[$i]["anh"].'" border="0" class="imgType"><br />
                                                                                                                         <div class="dathang abc" style="margin-top: 20px;margin-bottom: 10px;">
                                                                                                                                       <form action="'.WEB_DOMAIN.'/product-'.  huu($title1).'-'.$id.'" method="post">
                                                                                                                                            <input type="text" name="number" id="number" value="1" style="width: 60px; height: 25px;">
                                                                                                                                            <input type="submit" value="Mua hàng">
                                                                                                                                            <input type="hidden" value="'.$pro_detail[$i]["id_product"].'"  name="cardtype">
                                                                                                                                            <input type="hidden" value="buy" name="buy">
                                                                                                                                    </form>
                                                                                                                        </div>
                                                                                                        </td>';
                                                                                                 }
                                                                                                 if(!empty($pro_detail[$i+1])){
                                                                                                        echo '<td align="center"  width="50%">
                                                                                                                    '.$pro_detail[$i+1]["ten"].'<br />
                                                                                                                    <img src="'.WEB_DOMAIN.$dir_imgproducts1.$pro_detail[$i+1]["anh"].'" border="0" class="imgType"><br />
                                                                                                                    <div class="dathang abc" style="margin-top: 20px;margin-bottom: 10px;">
                                                                                                                                  <form action="'.WEB_DOMAIN.'/product-'.  huu($title1).'-'.$id.'" method="post">
                                                                                                                                            <input type="text" name="number" id="number" value="1" style="width: 60px; height: 25px;">
                                                                                                                                            <input type="submit" value="Mua hàng">
                                                                                                                                            <input type="hidden" value="'.$pro_detail[$i+1]["id_product"].'" name="cardtype">
                                                                                                                                            <input type="hidden" value="buy" name="buy">
                                                                                                                                    </form>
                                                                                                                    </div>
                                                                                                        </td>';
                                                                                                        }
                                                                                    echo '</tr>';
                                                                                }
                                                                            }
                                                                            echo '</tbody>
                                                                    </table>
                                                        </div>';
                                        }else{
                                                    echo 'Đang cập nhật dữ liệu';
                                        }
                    }else if($msg="ok"){
                        echo '<div class="fLeft contNews" id="fLeftcontNews">
                                <form id="buyCard" action="" method="post" >
                                        <table cellpadding="0" cellspacing="5" border="0" width="100%">
                                                    <tbody>
                                                                    <tr>
                                                                                <th width="25%" align="left" valign="top">Loại thẻ</th>
                                                                                <th width="30%" align="left" valign="top">Mệnh giá</th>
                                                                                <th width="25%" align="left" valign="top">Số lượng</th>
                                                                                <th width="30%" align="left" valign="top">Thành tiền</th>
                                                                    </tr>
                                                                    <tr>
                                                                                <td>'.$title1.'</td>
                                                                                <td>'.  number_format($price).' VNĐ</td>
                                                                                <td>'.$qty.'</td>
                                                                                <td>'.  number_format($price * $qty).' VNĐ</td>
                                                                    </tr>
                                                                    <tr>
                                                                                <td colspan="4">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                                <td colspan="4" align="left" valign="top">
                                                                                            Vui lòng chọn hình thức thanh toán: &nbsp;&nbsp;
                                                                                            <select name="orderType" class="cardPrice" id="orderType"  style="width:180px; margin-right: 30px;">
                                                                                                        <option value="0">-- Kiểu thanh toán --</option>
                                                                                                        <option value="1">Trừ trực tiếp vào tài khoản</option>
                                                                                                        <option value="2">Thông qua Bảo Kim</option>
                                                                                                        <option value="3">Thông qua Ngân Lượng</option>
                                                                                            </select>                                                                                           
                                                                                </td>                                                                              
                                                                    </tr>             
                                                                    <tr>
                                                                                    <td colspan="4" align="left" valign="top">
                                                                                            Vui lòng chọn hình thức lấy thẻ: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                            <select name="get_method" class="cardPrice" id="get_method"  style="width:180px; margin-right: 30px;" onchange="change_method()">                                                                                                       
                                                                                                        <option value="0">-- Chọn hình thức nhận thẻ --</option>
                                                                                                        <option value="1">Nạp thẻ</option>
                                                                                                        <option value="2">Tải thẻ</option>                                                                                                    
                                                                                            </select>
                                                                                            <br /><div id="changeMethod"></div>
                                                                                </td>           
                                                                                 
                                                                    </tr>
                                                                     <tr>
                                                                                <td colspan="4">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                                  <td colspan="4" align="left" valign="top">                          
                                                                                            <input type="hidden" name="cardType" value="'.$cardtype.'" id="cardType">
                                                                                            <input type="hidden" name="sluong" value="'.$qty.'" id="sluong">
                                                                                            <input type="hidden" name="type_catalog" value="'.$type_catalog.'" id="type_catalog">
                                                                                                <input type="hidden" name="company_code" value="'.$company_code.'" id="company_code">
                                                                                            <input type="button" class="stbn" id="buttonBuyCard" value="Mua" onclick="showNeedLogin()"><br><br>
                                                                                </td>
                                                                    </tr>
                                                </tbody>
                                       </table>
                                </form>
                            </div>';
                    }
                        echo '</div>
                        <span class="fLeft bc bc-r">&nbsp;</span>
                    </div>';

                }

?>