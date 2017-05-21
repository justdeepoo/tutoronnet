<?php
/*
	Description - this code for implementing payment gayway authorized.net using eCheck.net 
	Developed by-	deepoo gupta
	Created-	09-07-12
*/

require_once 'config.php';
    $transaction = new AuthorizeNetAIM;
    $transaction->setSandbox(AUTHORIZENET_SANDBOX);
    $transaction->setFields(
        array(
        'amount' => '1', 
        'bank_aba_code' => '021001318', 		//search on net for bank aba code
        'bank_name' =>'BANK OF AMERICA',		// Up to 50 characters
        'bank_acct_type' => 'checking',			//it can be saving, checking,business  
       'bank_acct_num' => '654254323',			// any random number Up to 20 digits
        'echeck_type' => 'PPD',					// it can be PPD,WEB ,CCD,TEL,ARC 
		'bank_check_number'=>'a6989879a'	,	// check number Up to 15 characters
        )
    );
    $response = $transaction->authorizeAndCapture();
    if ($response->approved) {
        // Transaction approved! Do your logic here.
        header('Location: thank_you_page.php?transaction_id=' . $response->transaction_id);
    } else {
        header('Location: error_page.php?response_reason_code='.$response->response_reason_code.'&response_code='.$response->response_code.'&response_reason_text=' .$response->response_reason_text);
    }

?>