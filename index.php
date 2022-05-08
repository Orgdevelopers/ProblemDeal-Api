<?php

//config dirs
$upload_dir = __DIR__."/uploads";
$models_dir = __DIR__."/model";
$vendor_dir = __DIR__."/vendor";


//
define('UPLOADS_DIR',$upload_dir);
define('MODELS_DIR',$models_dir);
define('VENDOR_DIR',$vendor_dir);



//get both php self and request
$php_self =  $_SERVER['PHP_SELF'];
$request_uri =  $_SERVER['REQUEST_URI'];

$php_self=str_replace("/","",$php_self);
$php_self=str_replace("index.php","/",$php_self);

$request_uri=str_replace($php_self,"",$request_uri);
//$request_uri = substr($request_uri,1);
//$request_uri=str_replace("/","",$request_uri);

//check api key
verfiy_api_key();

//call method
$url = explode('/',$request_uri);

$controller = $url[count($url)-2];
$request = $url[count($url)-1];


//init api
require_once MODELS_DIR."/autoload.php";
require_once __DIR__."/lib/Utility.php";
require_once __DIR__."/db/dbconnecter.php";
require_once __DIR__."/Controller/apiController.php";
require_once __DIR__."/Controller/adminController.php";

if($controller=='admin'){
    $admin = new AdminController();

    try {
        $admin->$request();
    } catch (\Throwable $th) {
        //throw $th;
        no_method($request);
    }

}else if($controller=='api'){
    $api = new ApiController();

    try {
        $api->$request();
    } catch (\Throwable $th) {
        //throw $th;
        no_method($request);
    }


}else{
    invalid_request();
}

function access_denined($error){

    $data['code'] = '403';
    $data['msg'] = 'Access denied :error '.$error;

    echo json_encode($data);
    die;

}

function no_method($name){
    $output['code'] = '553';
    $output['msg'] = "method dosen't exists:- ".$name;

    echo json_encode($output);
    die;

}

function verfiy_api_key(){
    //get headers
    if (!function_exists('apache_request_headers')) {
        $headers = fetch_headr();
    } else {
        $headers = apache_request_headers();
    }

    require_once("config.php");
    if(isset($headers['API-KEY'])){
        if($api_key==$headers['API-KEY']){
            return true;
        }else{
            access_denined("wrong key");
        }


    }else if(isset($headers['api-key'])){
        if($api_key==$headers['api-key']){
            return true;
        }else{
            access_denined("wrong key");
        }
    }else{
        return access_denined("sicurity token key missing");
    }

}


function invalid_request(){
    $output['code'] = '1001';
    $output['msg'] = "Invaild request";

    echo json_encode($output);
    die;

}

function incomplete_data($error){
    $output['code'] = '401';
    $output['msg'] = "incomplete data ";

    if($error!=null){
        $output .= ":- ".$error;
    }

    echo json_encode($output);
    die;

}

//echo json_encode($headers);

function fetch_headr(){
        $arh = array();
    $rx_http = '/\AHTTP_/';
    foreach($_SERVER as $key => $val) {
        if( preg_match($rx_http, $key) ) {
            $arh_key = preg_replace($rx_http, '', $key);
            $rx_matches = array();
            // do some nasty string manipulations to restore the original letter case
            // this should work in most cases
            $rx_matches = explode('_', $arh_key);
            if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);

                $arh_key = implode('-', $rx_matches);

            }

            $arh[$arh_key] = $val;
        }
    }
    return( $arh );
}

// codes = 403=access deny, 553 = no method, 1001 =invalid req,  401=incomplete data
?>