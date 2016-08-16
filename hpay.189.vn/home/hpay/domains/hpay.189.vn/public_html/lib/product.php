<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Home</a>");
}
$pro = array();
$sql = new db_sql();
$sql->db_connect();
$sql->db_select();
$option = $HTTP_GET_VARS["Webdesign"];
if(isset($_GET["cat"]) && !isset($_GET["subcat"]) && $_GET["Webdesign"] == "product"){
    
	$catid = isset($_GET["cat"]) && is_numeric($_GET["cat"]) ? $_GET["cat"] : 0;
	$subcatid = 0;
	for($i=1; $i<=count($cat); $i++)
		if($cat[$i]["catid"]==$catid)
			$catname = $cat[$i]["catname"];
	$select_query = "SELECT SanphamID FROM sanpham WHERE catid = $catid";
	$sql->query($select_query);		
	$count_rows = $sql->num_rows();
	$message = "<b>".$catname." có ".$count_rows." sản phẩm</b>";
	$rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;		
	$pages_number = ceil($count_rows/$rows_per_page_of_product);
	$from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
	$select_query = "SELECT SanphamID, catid, subcatid, ten, gia, anh, tinhtrang
							FROM sanpham 
							WHERE catid = $catid 
							ORDER BY gia DESC LIMIT $from, $rows_per_page_of_product";	
			$sql->query($select_query);
			$i=0;
			while($row = $sql->fetch_array()){
				$i=$i+1;
				$pro[$i]["SanphamID"] 	= $row["SanphamID"];
				$pro[$i]["catid"] 	= $row["catid"];
				$pro[$i]["subcatid"] 	= $row["subcatid"];
				$pro[$i]["ten"] 	= $row["ten"];
				$pro[$i]["tinhtrang"] 	= $row["tinhtrang"];
				$pro[$i]["anh"] 	= $row["anh"];
				$pro[$i]["gia"] 	= $row["gia"];
                                $pro[$i]["url"]         = WEB_DOMAIN.'/istore/'.$row["SanphamID"].'-'.huu($row["ten"]).'.html';
			}
}
else
	if(isset($_GET["cat"]) && isset($_GET["subcat"])){
		$catid 		= isset($_GET["cat"]) 		&& is_numeric($_GET["cat"]) 	? $_GET["cat"] 		: 0;
		$subcatid 	= isset($_GET["subcat"]) 	&& is_numeric($_GET["subcat"]) 	? $_GET["subcat"] 	: 0;
		
		for($i=1; $i<=count($subcat); $i++)
                                                    if($subcat[$i]["subcatid"]==$subcatid){
			$cat_id = $subcat[$i]["catid"];
			$catname = $subcat[$i]["subcatname"];
		}
		for($i=1; $i<=count($subcat); $i++)
		if($subcat[$i]["subcatid"]==$subcatid)
			$subcatname = $subcat[$i]["subcatname"];
		$select_query = "SELECT SanphamID FROM sanpham WHERE catid = $catid AND subcatid = $subcatid";
		$sql->query($select_query);		
		$count_rows = $sql->num_rows();
		$message = "".$catname." &gt; ".$subcatname." có ".$count_rows." sản phẩm";
		$rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
		$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
		$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;	
		$pages_number = ceil($count_rows/$rows_per_page_of_product);
		$from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
		
		$select_query = "SELECT SanphamID, catid, subcatid, ten, gia, anh, tinhtrang
						FROM sanpham 
						WHERE catid = $catid AND subcatid = $subcatid 
						ORDER BY gia DESC LIMIT $from, $rows_per_page_of_product";				
		$sql->query($select_query);
		$i=0;
		while($row = $sql->fetch_array()){
			$i=$i+1;
			$pro[$i]["SanphamID"]   = $row["SanphamID"];
			$pro[$i]["catid"]       = $row["catid"];
			$pro[$i]["subcatid"]    = $row["subcatid"];
			$pro[$i]["tinhtrang"]   = $row["tinhtrang"];
			$pro[$i]["ten"]         = $row["ten"];
			$pro[$i]["gia"]         = $row["gia"];
			$pro[$i]["anh"]         = $row["anh"];
                        $pro[$i]["url"]         = WEB_DOMAIN.'/istore/'.$row["SanphamID"].'-'.huu($row["ten"]).'.html';
		}
}
$sql->close();
$title = array(	"product" => $catname ,
	 	);
$sql->close();


function right_content(){
    echo '<div class="fLeft sub-right sub-cont-r">
        <span class="fLeft tl">&nbsp;</span>
        <span class="fLeft tc tcr">» Danh mục thẻ: </span>
        <span class="fLeft tl tr">&nbsp;</span>
        <div class="fLeft sub-right s-c-r cont-sub-right">
            <div class="fLeft contNews">
                <div class="tabbertab"> 
                                        <div class="slide-tabs"><a href="/product/card/mobifone.html"><img src="/data/product/mobifone.jpg" title="Mobifone" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/vinaphone.html"><img src="/data/product/vinaphone.jpg" title="Vinaphone" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/viettel.html"><img src="/data/product/viettel.jpg" title="Viettel" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/megacard.html"><img src="/data/product/megacard.jpg" title="MegaCard" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/vietnamobile.html"><img src="/data/product/vietnamobile.jpg" title="Vietnamobile" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/gmobile.html"><img src="/data/product/gmobile.jpg" title="Gmobile" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/s-fone.html"><img src="/data/product/s-fone.jpg" title="S-fone" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/evn-telecom.html"><img src="/data/product/evn-telecom.jpg" title="EVN Telecom " width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/zing-card.html"><img src="/data/product/zing-card.jpg" title="Zing Card" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/vtc-online.html"><img src="/data/product/vtc-online.jpg" title="VTC Online" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/gate-card.html"><img src="/data/product/gate-card.jpg" title="Gate Card" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/oncash.html"><img src="/data/product/oncash.jpg" title="OnCash" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/dec-card.html"><img src="/data/product/dec-card.jpg" title="DEC Card" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/voice777.html"><img src="/data/product/voice777.jpg" title="Voice777" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/vgold-100.html"><img src="/data/product/vgold-100.jpg" title="Vgold 100" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/mcash.html"><img src="/data/product/mcash.jpg" title="Mcash" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/s-cash.html"><img src="/data/product/s-cash.jpg" title="S-Cash" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/ecash.html"><img src="/data/product/ecash.jpg" title="eCash" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/vgame-card.html"><img src="/data/product/vgame-card.jpg" title="VGame Card" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/deco-card.html"><img src="/data/product/deco-card.jpg" title="DECO Card" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/garena.html"><img src="/data/product/garena.jpg" title="Garena" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/genk-7554.html"><img src="/data/product/genk-7554.jpg" title="Genk 7554" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/kaspersky-internet-security.html"><img src="/data/product/kaspersky-internet-security.jpg" title="Kaspersky internet security" width="78" height="54"></a></div>
                                        <div class="slide-tabs"><a href="/product/card/the-bkv-pro.html"><img src="/data/product/the-bkv-pro.jpg" title="Thẻ BKV Pro" width="78" height="54"></a></div>
                    </div>                
            </div>
        </div>
        <span class="fLeft bc bc-r">&nbsp;</span>
    </div>';
}
        
?>