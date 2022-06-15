<?php

function encrypt_password($pass){

    $privateKey 	= 'AAF4RSG6YR75JF8GK9LJ0JD53VXC'; 
    $secretKey 		= '1j2gh28i3h9'; 
    $encryptMethod      = "AES-256-CBC";
    $string 		= $pass; 

    $key = hash('sha256', $privateKey);
    $ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
    $result = openssl_encrypt($string, $encryptMethod, $key, 0, $ivalue);
    $output = base64_encode($result);  // output is a encripted value

    return $output;

}

function decrypt_password($pass_hash){

    $privateKey 	= 'AAF4RSG6YR75JF8GK9LJ0JD53VXC'; 
    $secretKey 		= '1j2gh28i3h9'; 
    $encryptMethod      = "AES-256-CBC";
    $stringEncrypt      = $pass_hash; 

    $key    = hash('sha256', $privateKey);
    $ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo

    $output = openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);

    return $output;

}

function die_($conn = null){
    // try {
    //     mysqli_close($conn);
    // } catch (\Throwable $th) {
    //     //throw $th;
    // }
    die;
}

function send_email($data){

    if($data==null){
        return false;
    }

    $to = $data['to'];
    $sub = $data['sub'];
    $msg = $data['msg'];

    $mail_name = MAIL_NAME;
    $mail_from = MAIL_EMAIL;
    $mail_reply = MAIL_REPLYTO;

    $headers  = "From: ".$mail_name." <".$mail_from."> \r\n";
    //$headers .= "Cc: testsite <mail@testsite.com>\n"; 
    $headers .= "X-Sender: ".$mail_name." <".$mail_from."> \r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion()."\r\n";
    $headers .= "X-Priority: 1 \r\n"; // Urgent message!
    $headers .= "Return-Path: ".$mail_reply." \r\n"; // Return path for errors
    $headers .= "MIME-Version: 1.0 \n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1 \n";

    if(mail($to,$sub,$msg)){
        return true;
        
    }else{
        return false;
    }

}

function sendPushNotification($token,$message){
    $api_key = FIREBASE_API_KEY;

    $url = "https://fcm.googleapis.com/fcm/send";
    $headers = array (
        'Authorization: key=' . $api_key,
        'Content-Type: application/json'
    );


    $msg['to'] = $token;
    $msg['notification']['title'] = $message['title'];
    $msg['notification']['body'] = $message['msg'];

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($msg) );

    $result = curl_exec ( $ch );

    return $result;

}

?>