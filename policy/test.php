<?php

    $api_key = "AAAA8BxRyvc:APA91bHNO8IyZtpSnXSlA2E3IXHd4DvzSlXDcFhXdSpSRJzlaC_c8g4z6wQi9Fo1uyFOlOVj_AeO-wOa1_uMAaQaoUpM2qWq0s7LS8nXJwybyqor2A__IbWNPMDw4vYbz9JC1H6FjnyW";
    $token = "d1ZPele8Qbepl-xi6vrVZY:APA91bHhz_pwrogGdGdDCs2PhFVvxiibo3hziHYxhVcrBuAntkEBY1tzdZWX82iWIMIfDBZs2Dh5NkwTo2wfSNMceXTczacVC8qIXaDCR-PHPDq4YiBNdi_u-faTZnvZ7xVo1_YMrAex";

    $url = "https://fcm.googleapis.com/fcm/send";
    $headers = array (
        'Authorization: key=' . $api_key,
        'Content-Type: application/json'
    );


    $msg['to'] = $token;
    $msg['notification']['title'] = "hi how are you";//$message['title'];
    $msg['notification']['body'] = "this is a test message";//$message['msg'];

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($msg) );

    $result = curl_exec ( $ch );

    echo $result;

?>