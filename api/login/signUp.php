<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=utf-8');

require('../../Controllers/userController.php');
require('../../Helpers/JwtAuth.php');
    //$data = json_decode(file_get_contents('php://input'), true);
    $data = file_get_contents('php://input');
    $data=json_decode($data, true);

    $userNick=$data['userNick'];
    $userPwd=$data['userPwd'];

    if (!empty($userNick) && !empty($userPwd)) {
        $jwt=new JwtAuth();
        //Token
        if (isset($data['getToken'])) {
            $data=$jwt->signUp($userNick, $userPwd, true);
            die();
        } else {
            $data=$jwt->signUp($userNick, $userPwd);
            die();
        }
    } else {
        $data=[
        'code'=> 400,
        'message'=>'Campos vacios o invalidos'
      ];
    }
http_response_code($data['code']);
$response=[];
array_push($response, $data);
echo json_encode($response);
