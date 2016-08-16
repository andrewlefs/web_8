<?php
// Add lists
require_once('nusaop/nusoap.php');
class ItopupClient {
	var $wsTopupVNPTEPAY = "http://itopup-test.megapay.net.vn:8086/ItopupService1.4/services/TopupInterface?wsdl";
	var $username = "acc_test3";
	var $password = "123!@#$";
	var $keyBirthdayTime = "2013/02/22 11:40:27.057";
	var $key = "c0cf49ebbd1a15ebbcec1ae4";
	
	var $token = ".";
	var $client = null;
	var $errorCode = ".";
	var $errorMessage = ".";
	
	function signIn() {
		if ($this->client == null){
			$this->client = new nusoap_client($this->wsTopupVNPTEPAY, true);			
		}
		$param = array('username'=>$this->username, 'password'=> $this->password); 
		$result = $this->client->call('signInAsPartner', $param);

		if ($result != null){
			$this->errorCode = $result["errorCode"];
			$this->errorMessage = $result["errorMessage"];
			if (($this->errorCode == -3) || ($this->errorCode == 0)){
				$this->token = $result["token"];
			}
			else{
				$this->token = "";
			}
		}else{
			$this->errorCode = -1;
			$this->errorMessage = "Not connect VNPT EPAY WS";
			$this->token = "";
		}
	}
	
	function directTopupMobile($requestID, $targetAccount, $amount){
		echo "__________________________________________________<br>";
		$this->errorCode = -100;
		$this->errorMessage = "Not connect!";
		if ($this->token == null || $this->token == "") {
			$this->signIn();
		}
		if ($this->token == null || $this->token == ""){
			$this->errorCode = -100;
			$this->errorMessage = "Not connect!";
		}
		else{
		$param = array(
						'username' => $this->username, 
						'targetAccount' => $targetAccount,
						'amount' => $amount,
						'requestID' => $requestID,
						'token' => $this->token); 
			
			$result = $this->client->call('partnerDirectTopupMobile', $param);
			print_r($result);
			if ($result != null){
				$this->errorCode = $result["errorCode"];
				$this->errorMessage = $result["errorMessage"];
			}
			echo "<h3>ErrorCode: <font color=\"red\">". $this->errorCode."</font></h3>";
			echo "<h3>Message: <font color=\"red\">". $this->errorMessage."</font></h3>";
			if ($this->errorCode == 0){
				$epayTransID =  $result["epayTransID"];
				$merchantID =  $result["merchantID"];
				$merchantBalance =  $result["merchantBalance"];
				echo "<h3>TransactionID: <font color=\"red\">".$epayTransID."</font></h3>";
				echo "<h3>MerchantID: <font color=\"red\">".$merchantID."</font></h3>";
				echo "<h3>Balance: <font color=\"red\">".$merchantBalance."</font> VNĐ</h3>";
			}
		}
	}
	
	function directTopupGame($requestID, $providerCode, $targetAccount, $amount){
		echo "__________________________________________________<br>";
		$this->errorCode = -100;
		$this->errorMessage = "Not connect!";
		if ($this->token == null || $this->token == "") {
			$this->signIn();
		}
		if ($this->token == null || $this->token == ""){
			$this->errorCode = -100;
			$this->errorMessage = "Not connect!";
		}
		else{
		$param = array(
						'username' => $this->username, 
						'providerCode' => $providerCode,
						'targetAccount' => $targetAccount,
						'amount' => $amount,
						'requestID' => $requestID,						
						'token' => $this->token); 
			
			$result = $this->client->call('partnerDirectTopupGame', $param);
			print_r ($result);
			if ($result != null){
				$this->errorCode = $result["errorCode"];
				$this->errorMessage = $result["errorMessage"];
			}
			echo "<h3>ErrorCode: <font color=\"red\">". $this->errorCode."</font></h3>";
			echo "<h3>Message: <font color=\"red\">". $this->errorMessage."</font></h3>";
			if ($this->errorCode == 0){
				$epayTransID =  $result["epayTransID"];
				$merchantID =  $result["merchantID"];
				$merchantBalance =  $result["merchantBalance"];
				echo "<h3>TransactionID: <font color=\"red\">".$epayTransID."</font></h3>";
				echo "<h3>MerchantID: <font color=\"red\">".$merchantID."</font></h3>";
				echo "<h3>Balacne: <font color=\"red\">".$merchantBalance."</font> VND</h3>";
			}
		}
	}
	
	function queryBalance($requestID) {
		echo "__________________________________________________<br>";
		$this->errorCode = -100;
		$this->errorMessage = "Not connect!";
		if ($this->token == null || $this->token == "") {
			$this->signIn();
		}
		if ($this->token == null || $this->token == ""){
			$this->errorCode = -100;
			$this->errorMessage = "Not connect!";
		}
		else{
			$param = array(
						'username' => $this->username,  
						'requestID' => $requestID,
						'token' => $this->token);
			$result = $this->client->call('queryBalance', $param);
			print_r($result);
			if ($result != null){
				$this->errorCode = $result["errorCode"];
				$this->errorMessage = $result["errorMessage"];
			}
			echo "<h3>ErrorCode: <font color=\"red\">". $this->errorCode."</font></h3>";
			echo "<h3>Message: <font color=\"red\">". $this->errorMessage."</font></h3>";
			if ($this->errorCode == 0){
				$BalanceResult =  $result["dataValue"];
				echo "<h3>Your balance: <font color=\"red\">".$BalanceResult."</font> VND</h3>";
			}
			//return $BalanceResult;
		}
	}
	
	function downloadSoftpin($requestID, $productID, $quantity){
		echo "__________________________________________________<br>";
		$this->errorCode = -100;
		$this->errorMessage = "Not conncect!";
		if ($this->token == null || $this->token == "") {
			$this->signIn();
		}
		if ($this->token == null || $this->token == ""){
			$this->errorCode = -100;
			$this->errorMessage = "Not conncect!";
		}
		else{
			 //Build list Items
			$buyItem = array('productId'=> $productID, 'quantity' => $quantity);
			$listItems = array($buyItem);
			$param = array(
                                                                                                'username' => $this->username, 
                                                                                                'requestID' => $requestID,
                                                                                                'token' => $this->token,
                                                                                                'keyBirthdayTime' => $this->keyBirthdayTime,
                                                                                                'buyItems' => $listItems);
			$result = $this->client->call('partnerDownloadSoftpinV10', $param);				
			print_r($result);
			if ($result != null){
				$this->errorCode = $result["errorCode"];
				$this->errorMessage = $result["errorMessage"];
			}
			echo "<h3>ErrorCode: <font color=\"red\">". $this->errorCode."</font></h3>";
			echo "<h3>Message: <font color=\"red\">". $this->errorMessage."</font></h3>";
			if ($this->errorCode == 0){
				$epayTransID =  $result["epayTransID"];
				$products = $result["products"][0]['softpins'];
				//print_r ($products);
				echo "<h3>TransactionID: <font color=\"red\">".$epayTransID."</font></h3>";
				//
				$i = 0;
				//print_r($products);
				foreach ($products as $product)
				{
					++$i;
					echo "----------------------------".$i."-------------------<br>";
					echo "<h3>SoftPin encript: <font color=\"red\">".$product['softpinPinCode']."</font></h3>";
					echo "<h3>Serial: <font color=\"red\">".$product['softpinSerial']."</font></h3>";
					echo "<h3>expiryDate: <font color=\"red\">".$product['expiryDate']."</font></h3>";
					$PIN = $this->deCrypt($product['softpinPinCode']);
					echo "<h3>SoftPin clear: <font color=\"blue\">".$PIN."</font></h3>";
				}
				echo "<h3>Balance: <font color=\"blue\">".$result["merchantBalance"]." </font>VND</h3>";
			}
			
		}
		return $products;
	}
	
	
	//Redownload Softpin
	function reDownloadSoftpin($requestId){
		echo "__________________________________________________<br>";
		$this->errorCode = -100;
		$this->errorMessage = "Not connect!";
		if ($this->token == null || $this->token == "") {
			$this->signIn();
		}
		if ($this->token == null || $this->token == ""){
			$this->errorCode = -100;
			$this->errorMessage = "Not connect!";
		}
		else{
			$param = array(
							'username' => $this->username, 
							'requestId' => $requestId,
							'keyBirthdayTime' => $this->keyBirthdayTime,
							'token' => $this->token);
			print_r($param);
			$result = $this->client->call('partnerRedownloadSoftpin', $param);				
			print_r($result);
			if ($result != null){
				$this->errorCode = $result["errorCode"];
				$this->errorMessage = $result["errorMessage"];
			}
			echo "<h3>ErrorCode: <font color=\"red\">". $this->errorCode."</font></h3>";
			echo "<h3>Message: <font color=\"red\">". $this->errorMessage."</font></h3>";
			if ($this->errorCode == 0){
				$epayTransID =  $result["epayTransID"];
				$products = $result["products"][0]['softpins'];
				//print_r ($products);
				echo "<h3>TransactionID: <font color=\"red\">".$epayTransID."</font></h3>";
				//
				$i = 0;
				//print_r($products);
				foreach ($products as $product)
				{
					++$i;
					echo "----------------------------".$i."-------------------<br>";
					echo "<h3>SoftPin encript: <font color=\"red\">".$product['softpinPinCode']."</font></h3>";
					echo "<h3>Serial: <font color=\"red\">".$product['softpinSerial']."</font></h3>";
					echo "<h3>expiryDate: <font color=\"red\">".$product['expiryDate']."</font></h3>";
					$PIN = $this->deCrypt($product['softpinPinCode']);
					echo "<h3>SoftPin clear: <font color=\"blue\">".$PIN."</font></h3>";
				}
			}
			
		}
		return $products;
	}
	function getDirectTransDetail($requestID){
		echo "__________________________________________________<br>";
		$this->errorCode = -100;
		$this->errorMessage = "Chưa thực hiện thành công!";
		if ($this->token == null || $this->token == "") {
			$this->signIn();
		}
		if ($this->token == null || $this->token == ""){
			$this->errorCode = -100;
			$this->errorMessage = "Ko login duoc. Chua goi Direct thanh cong. Topup fail.";
		}
		else{
		$param = array(
						'username' => $this->username,
						'requestID' => $requestID,						
						'token' => $this->token); 
			
			$result = $this->client->call('getDirectTransDetail', $param);
			print_r ($result);
			if ($result != null){
				$this->errorCode = $result["errorCode"];
				$this->errorMessage = $result["errorMessage"];
			}
			echo "<h3>Mã lỗi: <font color=\"red\">". $this->errorCode."</font></h3>";
			echo "<h3>Message: <font color=\"red\">". $this->errorMessage."</font></h3>";
			if ($this->errorCode == 0){
				$requestID =  $result["requestID"];
				$targetAccount =  $result["targetAccount"];
				$amount =  $result["amount"];
				echo "<h3>RequestID: <font color=\"red\">".$requestID."</font></h3>";
				echo "<h3>TargetAcc: <font color=\"red\">".$targetAccount."</font></h3>";
				echo "<h3>Amount: <font color=\"red\">".$amount."</font> VND</h3>";
			}
		}
	}
	function generateRandomRequestID(){
		$strFormat = 'YmdHis'; //bo u
		$date = new DateTime();
		$xxxx = "";
		for ($i = 0; $i < 8; $i++){
			$xxxx .= rand(0, 9);
		}
		$requestID = $date->format($strFormat) . $xxxx;
		return $requestID;
	}
	
	function deCrypt($encryptText){
		return $this->decryptText($encryptText, $this->key);
	}
	function decryptText($encryptText, $key) {
		$key = substr($key, 0, 24);
		$iv = substr($key, 0, 8);
		$keyData = "\xA2\x15\x37\x08\xCA\x62\xC1\xD2"
			. "\xF7\xF1\x93\xDF\xD2\x15\x4F\x79\x06"
			. "\x67\x7A\x82\x94\x16\x32\x95";
		$cipherText = base64_decode($encryptText);
		$res = mcrypt_decrypt("tripledes", $key, $cipherText, "cbc", $iv);
		$resUnpadded = $this->pkcs5_unpad($res);
		return $resUnpadded;
	}
	function pkcs5_unpad($text)
	{
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)) return false;
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
		return substr($text, 0, -1 * $pad);
	}
}
?>