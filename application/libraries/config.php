<?php
/**
 * This file contains config info for the sample app.
 */

// Adjust this to point to the Authorize.Net PHP SDK
/**
 * The AuthorizeNet PHP SDK. Include this file in your project.
 *
 * @package AuthorizeNet
 */
require dirname(__FILE__) . '/lib/shared/AuthorizeNetRequest.php';
require dirname(__FILE__) . '/lib/shared/AuthorizeNetTypes.php';
require dirname(__FILE__) . '/lib/shared/AuthorizeNetXMLResponse.php';
require dirname(__FILE__) . '/lib/shared/AuthorizeNetResponse.php';
require dirname(__FILE__) . '/lib/AuthorizeNetAIM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetARB.php';
require dirname(__FILE__) . '/lib/AuthorizeNetCIM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetSIM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetDPM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetTD.php';
require dirname(__FILE__) . '/lib/AuthorizeNetCP.php';

if (class_exists("SoapClient")) {
    require dirname(__FILE__) . '/lib/AuthorizeNetSOAP.php';
}
/**
 * Exception class for AuthorizeNet PHP SDK.
 *
 * @package AuthorizeNet
 */
class AuthorizeNetException extends Exception
{
}
// $METHOD_TO_USE = "DIRECT_POST";         // Uncomment this line to test DPM
define("AUTHORIZENET_API_LOGIN_ID","3gg9jYJ7f");    // Add your API LOGIN ID
define("AUTHORIZENET_TRANSACTION_KEY","6jC8Hak73rQ53JT3"); // Add your API transaction key
define("AUTHORIZENET_SANDBOX",true);       // Set to false to test against production
define("TEST_REQUEST", "TRUE");           // You may want to set to true if testing against production
if (AUTHORIZENET_API_LOGIN_ID == "") {
    die('Enter your merchant credentials in config.php before running the sample app.');
}
