<?php

$hostname = "localhost";
$database   = "shur_db";
$db_user = 'shur_db';
$password = 'shur_db';
$portt = '3306';

$base_url = "https://shuruaatnow.com/problemdeal_api/";
$api_key = 'AAADFJ-J9D49F-NDN49H-NVOI49=';

$firebase_api_key = "AAAA8BxRyvc:APA91bHNO8IyZtpSnXSlA2E3IXHd4DvzSlXDcFhXdSpSRJzlaC_c8g4z6wQi9Fo1uyFOlOVj_AeO-wOa1_uMAaQaoUpM2qWq0s7LS8nXJwybyqor2A__IbWNPMDw4vYbz9JC1H6FjnyW";

$mail_name = 'Shuruaat Now verification service';
$mail_email = 'support@shuruaatnow.com';
$mail_reply_to = 'no-reply@shuruaatnow.com';

define('APP_NAME','Shuruaat Now');
define('API_KEY',$api_key);
define('DB_HOST',$hostname);
define('DB_DATABASE',$database);
define('DB_USERNAME',$db_user);
define('DB_PASSWORD',$password);
define('DB_PORT',$portt);
define('BASE_URL',$base_url);
define('FIREBASE_API_KEY',$firebase_api_key);

define('MAIL_NAME',$mail_name);
define('MAIL_EMAIL',$mail_email);
define('MAIL_REPLYTO',$mail_reply_to);


// function http_request(){
//     $headers = [
//     "Accept: application/json",
//     "Content-Type: application/json",
//     "API-KEY: ".$api_key." "
// ];

// $data = [
//     "role"=> "admin"
// ];

// $ch = curl_init('the-metasoft.tk/Api');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// $return = curl_exec($ch);
// echo $return;
// // $json_data = json_decode($return, true);
  

// // $curl_error = curl_error($ch);
// // $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// // $data = $json_data['msg'];
// }

?>