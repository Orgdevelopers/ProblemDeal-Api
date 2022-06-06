<?php

require_once("../model/util.php");
require_once("../config.php");

if(!isset($_GET['token'])){
    echo "<script>alert('broken request')</script>";
    //die;
}

$id = decrypt_password($_GET['token']);

http_request($id);

function http_request($id){
    $api_key = API_KEY;
    $headers = [
        "Accept: application/json",
        "Content-Type: application/json",
        "API-KEY: ".$api_key.""
    ];

    $data = [
        "id"=> $id
    ];

    $url = BASE_URL."api/verifyuser";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$return = curl_exec($ch);

$json = json_decode($return,true);

if($json['code']==200){
    echo "<script>alert('account verified')</script>";
    echo "<script>window.location.assign('".BASE_URL."')</script>";
}else{
    echo "<script>alert('failed code:".$json['code']."')</script>";
    echo "<script>window.location.assign('".BASE_URL."')</script>";
}

}

?>