<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['authorize_net_test_mode'] = 'FALSE'; // Set this to FALSE for live processing
// Authorize.net Account Info
$config['api_login_id'] = '3kEYe84s';			//live
$config['api_transaction_key'] = '77UG58a29YNczpXm'; // live
$config['api_url'] = 'https://secure.authorize.net/gateway/transact.dll'; // PRODUCTION URL

/*$config['api_login_id'] = '6Ze6X3zZH';
$config['api_transaction_key'] = '4kwW56XCed8V4b49';
$config['api_url'] = 'https://test.authorize.net/gateway/transact.dll';*/ /// TEST URL

// Lets setup some other values so we dont have to do it everytime
// we process a transaction
$config['authorize_net_x_version'] = '3.1';
$config['authorize_net_x_type'] = 'AUTH_CAPTURE';
$config['authorize_net_x_relay_response'] = 'FALSE';
$config['authorize_net_x_delim_data'] = 'TRUE';
$config['authorize_net_x_delim_char'] = '|';
$config['authorize_net_x_encap_char'] = '';
$config['authorize_net_x_url'] = 'FALSE';

$config['authorize_net_x_method'] = 'CC';


/* EOF */