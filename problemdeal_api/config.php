<?php

$hostname = "localhost";
$database   = "ravi_project";
$db_user = 'root';
$password = '';
$portt = '3307';

$base_url = "https://the-metasoft.tk/api/";
$api_key = 'AAADFJ-J9D49F-NDN49H-NVOI49=';


define('DB_HOST',$hostname);
define('DB_DATABASE',$database);
define('DB_USERNAME',$db_user);
define('DB_PASSWORD',$password);
define('DB_PORT',$portt);
define('BASE_URL',$base_url);



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