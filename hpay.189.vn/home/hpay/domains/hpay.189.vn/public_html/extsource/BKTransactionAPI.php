<?php

if (!class_exists("TransferTransactionRequest")) {
/**
 * TransferTransactionRequest
 */
class TransferTransactionRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $merchant_id;
	/**
	 * @access public
	 * @var string
	 */
	public $api_username;
	/**
	 * @access public
	 * @var string
	 */
	public $api_password;
	/**
	 * @access public
	 * @var string
	 */
	public $to_email;
	/**
	 * @access public
	 * @var string
	 */
	public $transaction_mode_id;
	/**
	 * @access public
	 * @var string
	 */
	public $escrow_timeout;
	/**
	 * @access public
	 * @var string
	 */
	public $fee_payer;
	/**
	 * @access public
	 * @var string
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $description;
	/**
	 * @access public
	 * @var string
	 */
	public $currency_code;
}}

if (!class_exists("TransferTransactionResponse")) {
/**
 * TransferTransactionResponse
 */
class TransferTransactionResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $error_code;
	/**
	 * @access public
	 * @var string
	 */
	public $error_message;
	/**
	 * @access public
	 * @var string
	 */
	public $transaction_id;
}}

if (!class_exists("ChargeAccountRequest")) {
/**
 * ChargeAccountRequest
 */
class ChargeAccountRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $merchant_id;
	/**
	 * @access public
	 * @var string
	 */
	public $api_username;
	/**
	 * @access public
	 * @var string
	 */
	public $api_password;
	/**
	 * @access public
	 * @var string
	 */
	public $to_email;
	/**
	 * @access public
	 * @var string
	 */
	public $transaction_id;
	/**
	 * @access public
	 * @var string
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $description;
	/**
	 * @access public
	 * @var string
	 */
	public $data_sign;
}}

if (!class_exists("ChargeAccountResponse")) {
/**
 * ChargeAccountResponse
 */
class ChargeAccountResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $error_code;
	/**
	 * @access public
	 * @var string
	 */
	public $error_message;
}}

if (!class_exists("TopupToMerchantRequest")) {
/**
 * TopupToMerchantRequest
 */
class TopupToMerchantRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $merchant_id;
	/**
	 * @access public
	 * @var string
	 */
	public $api_username;
	/**
	 * @access public
	 * @var string
	 */
	public $api_password;
	/**
	 * @access public
	 * @var string
	 */
	public $binding_field;
	/**
	 * @access public
	 * @var string
	 */
	public $transaction_id;
	/**
	 * @access public
	 * @var string
	 */
	public $card_id;
	/**
	 * @access public
	 * @var string
	 */
	public $pin_field;
	/**
	 * @access public
	 * @var string
	 */
	public $seri_field;
	/**
	 * @access public
	 * @var string
	 */
	public $data_sign;
}}

if (!class_exists("TopupToMerchantResponse")) {
/**
 * TopupToMerchantResponse
 */
class TopupToMerchantResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $error_code;
	/**
	 * @access public
	 * @var string
	 */
	public $error_message;
	/**
	 * @access public
	 * @var string
	 */
	public $transaction_id;
	/**
	 * @access public
	 * @var string
	 */
	public $info_card;
	/**
	 * @access public
	 * @var string
	 */
	public $data_sign;
}}

if (!class_exists("CheckTransRequest")) {
/**
 * CheckTransRequest
 */
class CheckTransRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $merchant_id;
	/**
	 * @access public
	 * @var string
	 */
	public $api_username;
	/**
	 * @access public
	 * @var string
	 */
	public $api_password;
	/**
	 * @access public
	 * @var string
	 */
	public $transaction_id;
	/**
	 * @access public
	 * @var string
	 */
	public $data_sign;
}}

if (!class_exists("CheckTransResponse")) {
/**
 * CheckTransResponse
 */
class CheckTransResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $error_code;
	/**
	 * @access public
	 * @var string
	 */
	public $error_message;
	/**
	 * @access public
	 * @var string
	 */
	public $status;
}}

if (!class_exists("BKTransactionAPI")) {
/**
 * BKTransactionAPI
 * @author WSDLInterpreter
 */
class BKTransactionAPI extends SoapClient {
	/**
	 * Default class map for wsdl=>php
	 * @access private
	 * @var array
	 */
	private static $classmap = array(
		"TransferTransactionRequest" => "TransferTransactionRequest",
		"TransferTransactionResponse" => "TransferTransactionResponse",
		"ChargeAccountRequest" => "ChargeAccountRequest",
		"ChargeAccountResponse" => "ChargeAccountResponse",
		"TopupToMerchantRequest" => "TopupToMerchantRequest",
		"TopupToMerchantResponse" => "TopupToMerchantResponse",
		"CheckTransRequest" => "CheckTransRequest",
		"CheckTransResponse" => "CheckTransResponse",
	);

	/**
	 * Constructor using wsdl location and options array
	 * @param string $wsdl WSDL location for this service
	 * @param array $options Options for the SoapClient
	 */
	public function __construct($wsdl="http://localhost:8888/services/transaction_api/init?wsdl", $options=array()) {
		foreach(self::$classmap as $wsdlClassName => $phpClassName) {
		    if(!isset($options['classmap'][$wsdlClassName])) {
		        $options['classmap'][$wsdlClassName] = $phpClassName;
		    }
		}
		parent::__construct($wsdl, $options);
	}

	/**
	 * Checks if an argument list matches against a valid argument type list
	 * @param array $arguments The argument list to check
	 * @param array $validParameters A list of valid argument types
	 * @return boolean true if arguments match against validParameters
	 * @throws Exception invalid function signature message
	 */
	public function _checkArguments($arguments, $validParameters) {
		$variables = "";
		foreach ($arguments as $arg) {
		    $type = gettype($arg);
		    if ($type == "object") {
		        $type = get_class($arg);
		    }
		    $variables .= "(".$type.")";
		}
		if (!in_array($variables, $validParameters)) {
		    throw new Exception("Invalid parameter types: ".str_replace(")(", ", ", $variables));
		}
		return true;
	}

	/**
	 * Service Call: DoTopupToMerchant
	 * Parameter options:
	 * (TopupToMerchantRequest) Topup_To_Merchant_Request
	 * @param mixed,... See function description for parameter options
	 * @return TopupToMerchantResponse
	 * @throws Exception invalid function signature message
	 */
	public function DoTopupToMerchant($mixed = null) {
		$validParameters = array(
			"(TopupToMerchantRequest)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("DoTopupToMerchant", $args);
	}


	/**
	 * Service Call: DoTransferTransaction
	 * Parameter options:
	 * (TransferTransactionRequest) transfer_transaction_request
	 * @param mixed,... See function description for parameter options
	 * @return TransferTransactionResponse
	 * @throws Exception invalid function signature message
	 */
	public function DoTransferTransaction($mixed = null) {
		$validParameters = array(
			"(TransferTransactionRequest)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("DoTransferTransaction", $args);
	}


	/**
	 * Service Call: DoChargeAccount
	 * Parameter options:
	 * (ChargeAccountRequest) charge_account_request
	 * @param mixed,... See function description for parameter options
	 * @return ChargeAccountResponse
	 * @throws Exception invalid function signature message
	 */
	public function DoChargeAccount($mixed = null) {
		$validParameters = array(
			"(ChargeAccountRequest)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("DoChargeAccount", $args);
	}


	/**
	 * Service Call: DoCheckTrans
	 * Parameter options:
	 * (CheckTransRequest) check_trans_request
	 * @param mixed,... See function description for parameter options
	 * @return CheckTransResponse
	 * @throws Exception invalid function signature message
	 */
	public function DoCheckTrans($mixed = null) {
		$validParameters = array(
			"(CheckTransRequest)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("DoCheckTrans", $args);
	}


}}

?>