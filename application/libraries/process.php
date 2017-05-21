<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
require_once 'config.php';
 $transaction = new AuthorizeNetAIM;
    $transaction->setSandbox(AUTHORIZENET_SANDBOX);
    $transaction->setFields(
        array(
        'amount' =>  $_REQUEST['amount'], 
        'card_num' => $_POST['x_card_num'], 
        'exp_date' => $_POST['x_exp_date'],
        'first_name' => $_POST['x_first_name'],
        'last_name' => $_POST['x_last_name'],
        'address' => $_POST['x_address'],
        'city' => $_POST['x_city'],
        'state' => $_POST['x_state'],
        'country' => $_POST['x_country'],
        'zip' => $_POST['x_zip'],
        'email' => $_POST['x_email'],
        'card_code' => $_POST['x_card_code'],
		
        )
    );
    $response = $transaction->authorizeAndCapture();
    if ($response->approved) 
	{
        // Transaction approved! Do your logic here.
        header('Location: thank_you_page.php?transaction_id=' . $response->transaction_id);
    } 
	else 
	{
        header('Location: error_page.php?response_reason_code='.$response->response_reason_code.'&response_code='.$response->response_code.'&response_reason_text=' .$response->response_reason_text);
    }
	?>
</body>
</html>