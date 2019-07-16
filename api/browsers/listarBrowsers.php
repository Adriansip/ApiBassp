<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/browserController.php');
header('Content-Type: application/json; charset=utf-8');

$db=new Conexion();
$conn=$db->getConnection();
$browserController=new BrowserController($conn);

$stm=$browserController->index();

if ($stm->num_rows > 0) {
    $browsers=[];
    while ($row = $stm->fetch_assoc()) {
        $browser=array(
          'browserId'=>$row['browserId'],
          'browserName'=>utf8_encode($row['browserName']),
          'browserIcon'=>$row['browserIcon']
        );
        array_push($browsers, $browser);
    }
    $data=[
      'status'=>'success',
      'code'=>200,
      'browsers'=>$browsers,
      'message'=>'Peticion exitosa'
    ];
} else {
    $data=[
    'status'=>'warning',
    'code'=>404,
    'message'=>'No hay registros'
  ];
}
  $response=[];
  array_push($response, $data);
  http_response_code($data['code']);
  echo json_encode($response);
