<?php
            if (!defined("qaz_wsxedc_qazxc0FD_123K")){
                            die("<a href='../index.php'>Home Page</a>!");
            }
            
            $pid = isset($_GET["pid"]) && is_numeric($_GET["pid"]) ? $_GET["pid"] : 0;
            $qty = isset($_GET["qty"]) && is_numeric($_GET["qty"]) ? $_GET["qty"] : 1;           
            
            if($_POST['subIds']){
                $arrIds = explode(',',$_POST['subIds']);
                foreach ($arrIds as $arrId){
                    if(!empty($arrId)){
                        $arrSelect = "cat".$arrId;
                        $comId = $_POST[$arrSelect];
                       if(!empty($comId)){
                           $numberProduct = "config-com".$arrId;
                           $pid= $comId; 
                           $qty = $_POST[$numberProduct];
                           $mycart;
                           addToCart();
                       }
                    }
                }
            }

            if($mode != "" AND $Webdesign == 'cart'){
                    if($mode == "add"){
                            addToCart();
                    }
                    elseif($mode == "add-ajax"){
                            $add = addToCart();
                            if($add)
                                    echo 'ok';
                            else
                                    echo 'add';
                            exit();
                    }elseif($mode == "emptycart"){
                            emptyCart();
                    }elseif($mode == "update"){
                            updateCart();
                    }
                    elseif($mode == "delete"){
                            deleteItem();
                    }
                    elseif($mode == "tai_file"){
                            taiCart();
                    }
            }
            function updateCart(){
                    global $mycart;
                    $totalProducts = $_POST['totalProducts'];
                    for($i=0;$i<$totalProducts;$i++){
                            $qtyTextboxName = "qty_".$mycart[$i]['pid'];
                            $qty = $_POST[$qtyTextboxName];
                            $qty = round($qty);
                            if(!(($qty >= 1)&&($qty < 999)))	$qty = 1;
                            $mycart[$i]['qty'] = $qty;
                    }
                    $_SESSION['mycart'] = $mycart;
            }
            function addToCart(){
                    global $pid, $qty, $mycart;
                    $count_cart = count($mycart);
                    $itemExists = 0;
                    for($i=0;$i<$count_cart;$i++)
                            if($pid == $mycart[$i]['pid']){
                                    $mycart[$i]['qty'] = $mycart[$i]['qty'] + $qty;
                                    $itemExists = 1;
                            }
                    if($itemExists == 0){
                            $mycart[$count_cart]['pid'] = $pid;
                            $mycart[$count_cart]['qty'] = $qty;
                    }
                    $_SESSION['mycart'] = $mycart;
                    return $itemExists;
            }
            $title = array(	"cart" => "Giỏ hàng của bạn | my cart",
                    );
function publish(){ 
	global $mycart, $dir_imgproducts1 ;
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
                        <h3>Giỏ hàng của bạn có '.$count_cart.' Sản phẩm</h3>
               		<div class="cart-page">
                        <form name="cartForm" action="'.WEB_DOMAIN.'/update-cart.html" method="POST">
                        <input type="hidden" name="totalProducts" value="'.$count_cart.'" />
                       <table cellspacing="0" cellpadding="0" class="show_cart_table">
                            <tbody>
                              <tr class="text_title">
                                <td width="1%">STT</td>
                                <td>Tên sản phẩm</td>
                                <td width="1%">Xóa</td>
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
                                <td align="center"><a href="'.WEB_DOMAIN.'/deleteItem/'.$mycart[$i]['pid'].'" class="delete-item-in-cart" ><img src="'.TPL_LINK.'/images/xoa.png" alt=""/></a></td>
                                <td align="center" class="price">'.gia($mycart[$i]["gia"]).'</td>
                                <td align="center"><input type="text" style="text-align:center; width:50px" name="qty_'.$mycart[$i]['pid'].'" value="'.$mycart[$i]['qty'].'" class="pro-qual"></td>
                                <td align="center" class="price">'.gia($thanhtien).'</td>
                          </tr>';
                            }
                            					
echo '<tr>
                <td align="center" colspan="4">
                  <a href="'.WEB_DOMAIN.'/checkout.html" class="form_button">Thanh toán</a>                
                  &nbsp;
                  <input type="button" value="Tiếp tục mua hàng" class="form_button" onclick="javascript: window.history.back();">
                  &nbsp;
                  <a href="'.WEB_DOMAIN.'/emptycart.html" class="form_button del-all-in-shop">Xóa hết</a>
                  <a href="Javascript:UpdateCart();" class="form_button del-all-in-shop">Tính lại</a>
                  <div class="payment_recount_notice">(* Khi bạn đổi số lượng hãy click vào nút <b>Tính lại</b> để hệ thống cập nhật lại giỏ hàng)</div></td>
                <td colspan="3" class="total_money" align="center">Thành tiền: <b class="price">'.gia($tongcong).'</b></td>
              </tr>
            </tbody>
          </table>
	</form>
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
function deleteItem(){
	global $pid,$mycart;
	$itemFound = 0;
	$newcart = array();
	$count_cart = count($mycart);
	for($i=0;$i<$count_cart;$i++){
		if($mycart[$i]['pid'] == $pid){
			$itemFound = 1;
			for($j=$i;$j<$count_cart-1;$j++)
				$mycart[$j] = $mycart[$j+1];
		}
	}
	if($itemFound == 1){
		$count_cart = $count_cart - 1;
		for($i=0;$i<$count_cart;$i++)
			$newcart[$i] = $mycart[$i];
		$_SESSION['mycart'] = $newcart;
		$mycart = $newcart;
	}
}
function emptyCart(){
	global $mycart;
	$mycart = array();
	$_SESSION['mycart'] = $mycart;
}
?>