<?php
/**
 * User: sht.
 * Date: 22.01.2018
 * Time: 1:01
 */


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
header('Content-Type: application/json');

//--
require_once ('vendor/autoload.php');
require_once('blocks/Auth.php');


if($d = file_get_contents('php://input')){ //в случае если к нам приходит json, а не нормальный post
    $postData = json_decode($d, true);
    if($postData){$_REQUEST = $postData;}
}

//-- check auth
try{
    check_auth($auth['token'], $_COOKIE['token']);
}
catch(Exception $e){
    $res = ['error' => $e->getMessage()];
    echo json_encode($res);
    exit;
}



//METHODS

if($_REQUEST['method_name'] == 'get_screen_by_url')
{
    try{
        $res['response'] = (new \classes\ScreenMaker())->get_screen_by_url($_REQUEST);
    }
    catch(Exception $e){
        $res = ['error' => $e->getMessage()];
    }

    echo json_encode($res);
    exit;
}




