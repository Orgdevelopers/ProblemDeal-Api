<?php

$json = json_decode(file_get_contents("https://problemdeal.tk/emails.txt"),true);
        if($json!=null && isset($json['id'])){
            if($json['id']=='no'){
                if(isset($json['msg'])){
                    echo $json['msg'];
                }else{
                    echo "error";
                }
            }
        }

        print_r($json);
?>