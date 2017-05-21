<?php defined('BASEPATH') OR exit('No direct script access allowed');
class AuthorizeNetAIM

{

    const LIVE_URL = 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';

    public $_api_login = "3gg9jYJ7f";
    public $_transaction_key = "6jC8Hak73rQ53JT3";
    public $_post_string; 
    public $VERIFY_PEER = true; // Set to false if getting connection errors.
    public $_sandbox = true;
    public $_log_file = false;
    /**
     * Holds all the x_* name/values that will be posted in the request. 
     * Default values are provided for best practice fields.
     */
    public $_x_post_fields = array(
        "version" => "3.1", 
        "delim_char" => ",",
        "delim_data" => "TRUE",
        "relay_response" => "FALSE",
        "encap_char" => "|",
        );
        
    /**
     * Only used if merchant wants to send multiple line items about the charge.
     */
    public $_additional_line_items = array();
    
    /**
     * Only used if merchant wants to send custom fields.
     */
    public $_custom_fields = array();
    
    /**
     * Checks to make sure a field is actually in the API before setting.
     * Set to false to skip this check.
     */
    public $verify_x_fields = true;
    
    /**
     * A list of all fields in the AIM API.
     * Used to warn user if they try to set a field not offered in the API.
     */
    public $_all_aim_fields = array("address","allow_partial_auth","amount",
        "auth_code","authentication_indicator", "bank_aba_code","bank_acct_name",
        "bank_acct_num","bank_acct_type","bank_check_number","bank_name",
        "card_code","card_num","cardholder_authentication_value","city","company",
        "country","cust_id","customer_ip","delim_char","delim_data","description",
        "duplicate_window","duty","echeck_type","email","email_customer",
        "encap_char","exp_date","fax","first_name","footer_email_receipt",
        "freight","header_email_receipt","invoice_num","last_name","line_item",
        "login","method","phone","po_num","recurring_billing","relay_response",
        "ship_to_address","ship_to_city","ship_to_company","ship_to_country",
        "ship_to_first_name","ship_to_last_name","ship_to_state","ship_to_zip",
        "split_tender_id","state","tax","tax_exempt","test_request","tran_key",
        "trans_id","type","version","zip"
        );
    
    

	
	/**
     * Constructor.
     *
     * @param string $api_login_id       The Merchant's API Login ID.
     * @param string $transaction_key The Merchant's Transaction Key.
     */
    public function __construct($api_login_id = false, $transaction_key = false)
    {
        $this->_api_login = ($api_login_id ? $api_login_id : (defined('AUTHORIZENET_API_LOGIN_ID') ? AUTHORIZENET_API_LOGIN_ID : ""));
        $this->_transaction_key = ($transaction_key ? $transaction_key : (defined('AUTHORIZENET_TRANSACTION_KEY') ? AUTHORIZENET_TRANSACTION_KEY : ""));
        $this->_sandbox = (defined('AUTHORIZENET_SANDBOX') ? AUTHORIZENET_SANDBOX : true);
        $this->_log_file = (defined('AUTHORIZENET_LOG_FILE') ? AUTHORIZENET_LOG_FILE : false);
    }
    
	    /**
     * Set the _post_string
     */
    public function _setPostString();
	    /**
     * Handle the response string
     */
    public function _handleResponse($string);
    
    /**
     * Get the post url. We need this because until 5.3 you
     * you could not access child constants in a parent class.
     */
    public function _getPostUrl();
    
    /**
     * Alter the gateway url.
     *
     * @param bool $bool Use the Sandbox.
     */
    public function setSandbox($bool)
    {
        $this->_sandbox = $bool;
    }
    
    /**
     * Set a log file.
     *
     * @param string $filepath Path to log file.
     */
    public function setLogFile($filepath)
    {
        $this->_log_file = $filepath;
    }
    
    /**
     * Return the post string.
     *
     * @return string
     */
    public function getPostString()
    {
        return $this->_post_string;
    }

     /**
     * Posts the request to AuthorizeNet & returns response.
     *
     * @return AuthorizeNetARB_Response The response.
     */
    public function _sendRequest()
    {
        $this->_setPostString();
        $post_url = $this->_getPostUrl();
        $curl_request = curl_init($post_url);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $this->_post_string);
        curl_setopt($curl_request, CURLOPT_HEADER, 0);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 45);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYHOST, 2);
        if ($this->VERIFY_PEER) {
            curl_setopt($curl_request, CURLOPT_CAINFO, dirname(dirname(__FILE__)) . '/ssl/cert.pem');
        } else {
            curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        }
        
        if (preg_match('/xml/',$post_url)) {
            curl_setopt($curl_request, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        }
        
        $response = curl_exec($curl_request);
        
        if ($this->_log_file) {
        
            if ($curl_error = curl_error($curl_request)) {
                file_put_contents($this->_log_file, "----CURL ERROR----\n$curl_error\n\n", FILE_APPEND);
            }
            // Do not log requests that could contain CC info.
            // file_put_contents($this->_log_file, "----Request----\n{$this->_post_string}\n", FILE_APPEND);
            
            file_put_contents($this->_log_file, "----Response----\n$response\n\n", FILE_APPEND);
        }
        curl_close($curl_request);
        
        return $this->_handleResponse($response);
    }

 
    /**
     * Do an AUTH_CAPTURE transaction. 
     * 
     * Required "x_" fields: card_num, exp_date, amount
     *
     * @param string $amount   The dollar amount to charge
     * @param string $card_num The credit card number
     * @param string $exp_date CC expiration date
     *
     * @return AuthorizeNetAIM_Response
     */
    public function authorizeAndCapture($amount = false, $card_num = false, $exp_date = false)
    {
        ($amount ? $this->amount = $amount : null);
        ($card_num ? $this->card_num = $card_num : null);
        ($exp_date ? $this->exp_date = $exp_date : null);
        $this->type = "AUTH_CAPTURE";
        return $this->_sendRequest();
    }
    
    /**
     * Do a PRIOR_AUTH_CAPTURE transaction.
     *
     * Required "x_" field: trans_id(The transaction id of the prior auth, unless split
     * tender, then set x_split_tender_id manually.)
     * amount (only if lesser than original auth)
     *
     * @param string $trans_id Transaction id to charge
     * @param string $amount   Dollar amount to charge if lesser than auth
     *
     * @return AuthorizeNetAIM_Response
     */
    public function priorAuthCapture($trans_id = false, $amount = false)
    {
        ($trans_id ? $this->trans_id = $trans_id : null);
        ($amount ? $this->amount = $amount : null);
        $this->type = "PRIOR_AUTH_CAPTURE";
        return $this->_sendRequest();
    }

    /**
     * Do an AUTH_ONLY transaction.
     *
     * Required "x_" fields: card_num, exp_date, amount
     *
     * @param string $amount   The dollar amount to charge
     * @param string $card_num The credit card number
     * @param string $exp_date CC expiration date
     *
     * @return AuthorizeNetAIM_Response
     */
    public function authorizeOnly($amount = false, $card_num = false, $exp_date = false)
    {
        ($amount ? $this->amount = $amount : null);
        ($card_num ? $this->card_num = $card_num : null);
        ($exp_date ? $this->exp_date = $exp_date : null);
        $this->type = "AUTH_ONLY";
        return $this->_sendRequest();
    }

    /**
     * Do a VOID transaction.
     *
     * Required "x_" field: trans_id(The transaction id of the prior auth, unless split
     * tender, then set x_split_tender_id manually.)
     *
     * @param string $trans_id Transaction id to void
     *
     * @return AuthorizeNetAIM_Response
     */
    public function void($trans_id = false)
    {
        ($trans_id ? $this->trans_id = $trans_id : null);
        $this->type = "VOID";
        return $this->_sendRequest();
    }
    
    /**
     * Do a CAPTURE_ONLY transaction.
     *
     * Required "x_" fields: auth_code, amount, card_num , exp_date
     *
     * @param string $auth_code The auth code
     * @param string $amount    The dollar amount to charge
     * @param string $card_num  The last 4 of credit card number
     * @param string $exp_date  CC expiration date
     *
     * @return AuthorizeNetAIM_Response
     */
    public function captureOnly($auth_code = false, $amount = false, $card_num = false, $exp_date = false)
    {
        ($auth_code ? $this->auth_code = $auth_code : null);
        ($amount ? $this->amount = $amount : null);
        ($card_num ? $this->card_num = $card_num : null);
        ($exp_date ? $this->exp_date = $exp_date : null);
        $this->type = "CAPTURE_ONLY";
        return $this->_sendRequest();
    }
    
    /**
     * Do a CREDIT transaction.
     *
     * Required "x_" fields: trans_id, amount, card_num (just the last 4)
     *
     * @param string $trans_id Transaction id to credit
     * @param string $amount   The dollar amount to credit
     * @param string $card_num The last 4 of credit card number
     *
     * @return AuthorizeNetAIM_Response
     */
    public function credit($trans_id = false, $amount = false, $card_num = false)
    {
        ($trans_id ? $this->trans_id = $trans_id : null);
        ($amount ? $this->amount = $amount : null);
        ($card_num ? $this->card_num = $card_num : null);
        $this->type = "CREDIT";
        return $this->_sendRequest();
    }
    
    /**
     * Alternative syntax for setting x_ fields.
     *
     * Usage: $sale->method = "echeck";
     *
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) 
    {
        $this->setField($name, $value);
    }
    
    /**
     * Quickly set multiple fields.
     *
     * Note: The prefix x_ will be added to all fields. If you want to set a
     * custom field without the x_ prefix, use setCustomField or setCustomFields.
     *
     * @param array $fields Takes an array or object.
     */
    public function setFields($fields)
    {
        $array = (array)$fields;
        foreach ($array as $key => $value) {
            $this->setField($key, $value);
        }
    }
    
    /**
     * Quickly set multiple custom fields.
     *
     * @param array $fields
     */
    public function setCustomFields($fields)
    {
        $array = (array)$fields;
        foreach ($array as $key => $value) {
            $this->setCustomField($key, $value);
        }
    }
    
    /**
     * Add a line item.
     * 
     * @param string $item_id
     * @param string $item_name
     * @param string $item_description
     * @param string $item_quantity
     * @param string $item_unit_price
     * @param string $item_taxable
     */
    public function addLineItem($item_id, $item_name, $item_description, $item_quantity, $item_unit_price, $item_taxable)
    {
        $line_item = "";
        $delimiter = "";
        foreach (func_get_args() as $key => $value) {
            $line_item .= $delimiter . $value;
            $delimiter = "<|>";
        }
        $this->_additional_line_items[] = $line_item;
    }
    
    /**
     * Use ECHECK as payment type.
     */
    public function setECheck($bank_aba_code, $bank_acct_num, $bank_acct_type, $bank_name, $bank_acct_name, $echeck_type = 'WEB')
    {
        $this->setFields(
            array(
            'method' => 'echeck',
            'bank_aba_code' => $bank_aba_code,
            'bank_acct_num' => $bank_acct_num,
            'bank_acct_type' => $bank_acct_type,
            'bank_name' => $bank_name,
            'bank_acct_name' => $bank_acct_type,
            'echeck_type' => $echeck_type,
            )
        );
    }
    
    /**
     * Set an individual name/value pair. This will append x_ to the name
     * before posting.
     *
     * @param string $name
     * @param string $value
     */
    public function setField($name, $value)
    {
        if ($this->verify_x_fields) {
            if (in_array($name, $this->_all_aim_fields)) {
                $this->_x_post_fields[$name] = $value;
            } else {
                throw new AuthorizeNetException("Error: no field $name exists in the AIM API.
                To set a custom field use setCustomField('field','value') instead.");
            }
        } else {
            $this->_x_post_fields[$name] = $value;
        }
    }
    
    /**
     * Set a custom field. Note: the x_ prefix will not be added to
     * your custom field if you use this method.
     *
     * @param string $name
     * @param string $value
     */
    public function setCustomField($name, $value)
    {
        $this->_custom_fields[$name] = $value;
    }
    
    /**
     * Unset an x_ field.
     *
     * @param string $name Field to unset.
     */
    public function unsetField($name)
    {
        unset($this->_x_post_fields[$name]);
    }
    
    /**
     *
     *
     * @param string $response
     * 
     * @return AuthorizeNetAIM_Response
     */
    public function _handleResponse($response)
    {
        return new AuthorizeNetAIM_Response($response, $this->_x_post_fields['delim_char'], $this->_x_post_fields['encap_char'], $this->_custom_fields);
    }
    
    /**
     * @return string
     */
    public function _getPostUrl()
    {
        return ($this->_sandbox ? self::SANDBOX_URL : self::LIVE_URL);
    }
    
    /**
     * Converts the x_post_fields array into a string suitable for posting.
     */
    public function _setPostString()
    {
        $this->_x_post_fields['login'] = $this->_api_login;
        $this->_x_post_fields['tran_key'] = $this->_transaction_key;
        $this->_post_string = "";
        foreach ($this->_x_post_fields as $key => $value) {
            $this->_post_string .= "x_$key=" . urlencode($value) . "&";
        }
        // Add line items
        foreach ($this->_additional_line_items as $key => $value) {
            $this->_post_string .= "x_line_item=" . urlencode($value) . "&";
        }
        // Add custom fields
        foreach ($this->_custom_fields as $key => $value) {
            $this->_post_string .= "$key=" . urlencode($value) . "&";
        }
        $this->_post_string = rtrim($this->_post_string, "& ");
    }
}
