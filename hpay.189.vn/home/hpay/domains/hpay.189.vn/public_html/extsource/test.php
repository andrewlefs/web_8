<?php
	require_once('ItopupClient.php');
	echo "VNPT EPAY Itopup Client Sample <br>";
	echo "__________________________________________________<br>";
	
	$itopupClient = new ItopupClient();
	// 1. Login
	echo "SignIn Result: <br>";
	$result = $itopupClient->signIn();
	print_r("ErrorCode: <font color=\"red\">". $itopupClient->errorCode. "</font><br>");
	print_r("ErrorMessage: <font color=\"red\">". $itopupClient->errorMessage. "</font><br>");
	print_r("Token: <b>". $itopupClient->token. "</b><br>");
	
	
	// 2. Directopup
	//directTopupMobile($itopupClient);
	//Test Topup Game
	//directTopupGame($itopupClient);
	
	// 3. Download Softpin (mua ma the)
	//downloadSoftpin($itopupClient);
	
	// 3,5. Redownload Softpin 
	//reDownloadSoftpin($itopupClient);
	
	// 4. QueryBalance
	queryBalance($itopupClient);
	
	//13. Get transaction status
	//getDirectTransDetail($itopupClient);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	// DIRECT TOPUP
	function directTopupMobile($itopupClient){
		echo "__________________________________________________<br>";
		$requestID = $itopupClient->generateRandomRequestID();
		$targetAccount = "0911111111";
		$amount = 10000;
		echo "RequestID:<b> ". $requestID. "</b><br>";
		echo "TargetAccount: <b>". $targetAccount. "</b><br>";
		echo "Amount: <b>". $amount. "</b> VND<br>";
		$itopupClient->directTopupMobile($requestID, $targetAccount, $amount);
	}
	function directTopupGame($itopupClient){
		echo "__________________________________________________<br>";
		$requestID = $itopupClient->generateRandomRequestID();	
		$amount = 10000;	
		$providerCode = 'FPT';
		$targetAccount = 'epay_test';
		
		echo "RequestID". $requestID. "</b><br>";
		echo "ServiceProvider:<b> ". $providerCode. "</b><br>";
		echo "TargetAccount: <b>". $targetAccount. "</b><br>";
		echo "Amount: <b>". $amount. "</b> VND<br>";
		$itopupClient->directTopupGame($requestID, $providerCode, $targetAccount, $amount);
	}
	// DOWNLOAD SOFTPIN
	function downloadSoftpin($itopupClient){
		echo "__________________________________________________<br>";
		$requestID = $itopupClient->generateRandomRequestID();	
		$productID = 1;
		$quantity = 1;
		$itopupClient->downloadSoftpin($requestID, $productID, $quantity);
	}
	//Redownload Softpin
	function reDownloadSoftpin($itopupClient){
		echo "__________________________________________________<br>";
		$requestId = "2012092408390811307116";
		echo "requestID : ".$requestId."<br>";
		$itopupClient->reDownloadSoftpin($requestId);
	}
	//Query balance
	function queryBalance($itopupClient){
		$requestID = $itopupClient->generateRandomRequestID();
		$itopupClient->queryBalance($requestID);
	}
	function getDirectTransDetail($itopupClient){
	echo "__________________________________________________<br>";
		echo "<br><b>getDirectTransDetail. Cac tham so dau vao: </b><br>";
		$requestID = "2013022502501138065941";		//Bat buoc phai sinh ra	
		echo "requestID: ".$requestID."<br>";
		$itopupClient->getDirectTransDetail($requestID);
	}
?>