<?php

use function GuzzleHttp\Psr7\stream_for;
use Aws\Ses\SesClient;

class Notification {

	private $url = [
						"MSG91_SMS"=>"https://control.msg91.com/api/sendhttp.php"
					];
	
	public function __construct(){
		$this->ci =& get_instance();		
	}
	
	public function notify($p = []){

		$output = ['sms_sent'=>0,'email_sent'=>0, 'resp'=>0, 'msg'=>''];

		if(!is_array($p) || empty($p)){
			$output['msg']= 'Invalid parameters';
			return $output;
		}

		if(!isset($p['CODE']) || $p['CODE'] == ''){
			$output['msg']= 'Invalid parameters - CODE';
			return $output;
		}

		if(!isset($p['TYPE']) || !is_array($p['TYPE'])){
			$output['msg']= 'Invalid parameters - TYPE';
			return $output;
		}

		if(!isset($p['PARAM']) || !is_array($p['PARAM'])){
			$output['msg']= 'Invalid parameters - PARAM';
			return $output;
		}


		

		$db = $this->ci->load->database('default',true);
		$q = $db->get_where('service_alerts',['CODE'=>$p['CODE'],'is_active'=>1]);
		if($q->num_rows() > 0){
			$alert = $q->row();

			if($alert->sms_active == 1 && $p['TYPE']['SMS'] != ''){
				$smsTxt = $alert->sms_text;
				if(isset($p['PARAM'])){
					foreach ($p['PARAM'] as $key => $value) {
						# code...
						$smsTxt = str_replace($key, $value, $smsTxt);
					}
				}
				$smsParam = [
					'authkey'=> getenv('MSG91_KEY'),
					'mobiles'=> $p['TYPE']['SMS'],
					'message'=>	$smsTxt,
					'sender'=> $alert->sms_sender,
					'route'=>4,
					'country'=>91,
					'response'=>'json',
				];

				$res = $this->sendOTP($smsParam);
				if($res['resp'] == 1){
					$output['resp'] = 1;
					$output['sms_sent'] = 1;
				}
			}

			if($alert->email_active == 1){
				
				$emailTxt = $alert->email_text;
				if(isset($p['PARAM'])){
					foreach ($p['PARAM'] as $key => $value) {
						# code...
						$emailTxt = str_replace($key, $value, $emailTxt);
					}
				}

				if(isset($p['TYPE']['EMAIL']['ATTACHMENT'])){

					if(!isset($p['TYPE']['EMAIL']['ATTACHMENT']['PATH'])){
						$output['msg']= 'Invalid parameters - ATTACHMENT PATH';
						return $output;
					}
				}

				$emailParam = [
					'Source'=>$alert->email_from,
					'ToAddresses'=>$p['TYPE']['EMAIL']['TO'],
					'SubjectData'=>$alert->email_subject,
					'htmlData'=>$emailTxt,
				];
				if(isset($p['TYPE']['EMAIL']['ATTACHMENT'])){
					$emailParam['Attachment']=pathinfo($p['TYPE']['EMAIL']['ATTACHMENT']['PATH']);
				}

				$res = $this->sendEmail($emailParam);
				if($res['resp'] == 1){
					$output['resp'] = 1;
					$output['email_sent'] = 1;
				}
			}

			return $output;

		}else{
			$output['msg']= 'No such alert exist';
			return $output;
		}		
	}

	private function sendOTP($smsParam = []){

		try{
			$client = new \GuzzleHttp\Client();
			$res = $client->request('GET', $this->url['MSG91_SMS'] , [
												'query' => $smsParam,
												'debug'=>false
											]);
		}catch(Exception $e){
			return ['resp'=>0,'msg'=>'Technical Error'];
		}

		if($res->getStatusCode() == 200){
			$stream = stream_for($res->getBody());
			$resp = $stream->getContents();
			if($resp == 'Authentication failure'){
				return ['resp'=>0,'Auth Error'];
			}	

			$resp = json_decode($resp, true);
			if($resp['type'] = 'success'){
				return ['resp'=>1,'txnid'=>$resp['message']];
			}else{
				return ['resp'=>0,'txnid'=>$resp['message']];
			}

		}else{

			return ['resp'=>0,'Technical Error'];
		}
	}

	private function sendEmail($emailParam = []){
		
		$client = SesClient::factory(array(
			'version'=> 'latest',     
			'region' => 'us-east-1',
			'credentials' => array(
		        'key'    => getenv('AWS_ACCESS_KEY_ID_SES'),
		        'secret' => getenv('AWS_SECRET_ACCESS_KEY_SES'),
		    )
		));

		$request = array();
		$request['Source'] = $emailParam['Source'];
		if(is_array($emailParam['ToAddresses'])){
			$request['Destination']['ToAddresses'] = $emailParam['ToAddresses'];
		}else{
			$request['Destination']['ToAddresses'] = [$emailParam['ToAddresses']];
		}

		// dd($request);

		$message= "To: ".implode(',',$request['Destination']['ToAddresses'])."\n";
		$message.= "From: ".$request['Source']."\n";
		$message.= "Subject: ".$emailParam['SubjectData']."\n";
		$message.= "MIME-Version: 1.0\n";
		$message.= 'Content-Type: multipart/mixed; boundary="aRandomString_with_signs_or_9879497q8w7r8number"';
		$message.= "\n\n";
		$message.= "--aRandomString_with_signs_or_9879497q8w7r8number\n";
		$message.= 'Content-Type: text/html; charset="utf-8"';
		$message.= "\n";
		$message.= "Content-Transfer-Encoding: 7bit\n";
		$message.= "Content-Disposition: inline\n";
		$message.= "\n";
		$message.= $emailParam['htmlData'];
		$message.= "\n\n";
		$message.= "--aRandomString_with_signs_or_9879497q8w7r8number\n";
		
		if(isset($emailParam['Attachment']) && $emailParam['Attachment'] != ''){
			
			$message.= "Content-ID: \<77987_SOME_WEIRD_TOKEN_BUT_UNIQUE_SO_SOMETIMES_A_@domain.com_IS_ADDED\>\n";
			$message.= 'Content-Type: '.mime_content_type($emailParam['Attachment']['dirname'].'/'.$emailParam['Attachment']['basename']).'; name="'.$emailParam['Attachment']['basename'].'"';
			$message.= "\n";
			$message.= "Content-Transfer-Encoding: base64\n";
			$message.= 'Content-Disposition: attachment; filename="'.$emailParam['Attachment']['basename'].'"';
			$message.= "\n";
			$message.= base64_encode(file_get_contents("/var/www/html/sketch.png"));
			$message.= "\n";
			$message.= "--aRandomString_with_signs_or_9879497q8w7r8number--\n";
			
		}

		
		try {
		     $response = $client->SendRawEmail([
			  				'RawMessage'   => ['Data'=>$message],
			  				'Destinations' => $request['Destination']['ToAddresses'],
							'Source'       => $request['Source']]);
		     $messageId = $response->get('MessageId');
		     return ['resp'=>1,'txnid'=>$messageId ];
		} catch (Exception $e) {

			dd($e->getMessage());
			return ['resp'=>0,'txnid'=>''];
		}
	}

	//Create at  - 20th-March-2017
	//Created By - Deepoo Gupta
	function addEvent($event){

		$this->ci->load->model('Data_model','data');
		$data=[
    		'table'=>'events',
    		'data'=>$event,
    	];

    	return $this->ci->data->set($data);
	}

}