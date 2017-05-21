<?php
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
$METHOD_TO_USE = "AIM";
// $METHOD_TO_USE = "DIRECT_POST";         // Uncomment this line to test DPM


define("AUTHORIZENET_API_LOGIN_ID","6Ze6X3zZH");    // Add your API LOGIN ID
define("AUTHORIZENET_TRANSACTION_KEY","4kwW56XCed8V4b49"); // Add your API transaction key
define("AUTHORIZENET_SANDBOX",true);       // Set to false to test against production
define("TEST_REQUEST", "FALSE");           // You may want to set to true if testing against production


// You only need to adjust the two variables below if testing DPM
define("AUTHORIZENET_MD5_SETTING","");                // Add your MD5 Setting.
$site_root = "http://localhost/samples/your_store/"; // Add the URL to your site


if (AUTHORIZENET_API_LOGIN_ID == "") {
    die('Enter your merchant credentials in config.php before running the sample app.');
}

/**
 * Exception class for AuthorizeNet PHP SDK.
 *
 * @package AuthorizeNet
 */
class AuthorizeNetException extends Exception
{
}
class Authorizenet extends AuthorizeNetAIM //AuthorizeNetAIM for using AIM replace with your preferred method
{
}