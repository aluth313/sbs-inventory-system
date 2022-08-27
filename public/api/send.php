<?php

if($_SERVER["REQUEST_METHOD"]=='POST')
{
		$token = $_POST['token'];
		$message = $_POST['message'];

		function send_notification($token, $message){

				$url = 'https://fcm.googleapis.com/fcm/send';
				$fields = array(
					'registration_ids'=> $token,
					'data'			  => $message

				);

				$headers = array(
					'Authorization:key=AAAAm6IJ8YE:APA91bHZdPLVj0LzH9owjra0VlhTLgzGShIGYJ1Rd267i-NxE8fpaXAtZLAF_K9q1HhU-r0XLIcYCKLuknRX5GIKFRXJ-MM8283tpQyoj8jcVmBZY_dDwfqInP_-U0JgfBgY-PrYoZv8',
					'Content-Type: application/json'

				);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

				$result = curl_exec($ch);

				if($result === FALSE){
					die('Curl Failed :' . curl_error($ch));
				} 

				curl_close($ch);

				return $result;

		}

		send_notification($token, $message);
		

		
	}

?>