<?php
function sendEmail($email,$name,$subject,$html){
   $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,  '{"personalizations": [{"to": [{"email": "'.$email.'"}]}],"from": {"email": "registeredemail@sendgrid.com","name": "'.$name.'"},"subject":"'.$subject.'","content": [{"type": "text/html","value": "'.$html.'"}]}');

	$headers = array();
	$headers[] = 'Authorization: Bearer [token_will_go_here]';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
   return $result;
}

$email = "your@email.com";
$name = "Company Name";
$subject = "Subject";

$html_file = './email-template.min.html';
$html_template = file_get_contents(__DIR__ . $html_file);
$html_template = str_replace('%title%',$subject,$html_template);
$html_template = str_replace('%descriptions%',$subject,$html_template);

$result = sendEmail($email,$name,$subject,$html_template);
