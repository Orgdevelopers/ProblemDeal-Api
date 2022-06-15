<?php

    $api_key = "AAAA8BxRyvc:APA91bHNO8IyZtpSnXSlA2E3IXHd4DvzSlXDcFhXdSpSRJzlaC_c8g4z6wQi9Fo1uyFOlOVj_AeO-wOa1_uMAaQaoUpM2qWq0s7LS8nXJwybyqor2A__IbWNPMDw4vYbz9JC1H6FjnyW";
    $token = "epOkD43nQ16Ut6hacZiAoc:APA91bGux3duxBYbkB1ShuKbRTXPDp8CP1eTdC6v8077PGwK18kXvOce937n8Vvm5qPMlPMZlkHPoONWbT5Vz2gak9Gymug2TzV_cK7uxtdnKGltcN-6jDDc3UUHosJcRdhgBbY3QHiH";

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

    echo $result;

?>