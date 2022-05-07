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


?>