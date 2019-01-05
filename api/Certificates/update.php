<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  require_once dirname(dirname(__DIR__)).'/config/database.php';
  require_once dirname(dirname(__DIR__)).'/config/config.php';
  require_once dirname(dirname(__DIR__)).'/models/certificate.php';
  
  $db = new Database;
  $model = new Certificate($db);

  $data = json_decode(file_get_contents('php://input'));

  if (checkAPIKEY()) {
    if ($model->update((array) $data, $data->certificateno)) {
      echo json_encode(
        array('message' => 'Certificate Updated')
      );
    } else {
      echo json_encode(
        array('message' => 'Certificate Not Updated')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Unauthorized request')
    );
  }

