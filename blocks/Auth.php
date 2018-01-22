<?php
$auth = ['login' => 'admin', 'pass' => 'x7777', 'token' => "5a4e0a21aae44700023663d29999"];

//helper
function check_auth($token_1, $token_2){ if($token_1 != $token_2){
    throw new \Exception('Не достаточно прав');} }