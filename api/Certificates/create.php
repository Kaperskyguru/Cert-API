<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  require_once dirname(dirname(__DIR__)).'/config/database.php';
  require_once dirname(dirname(__DIR__)).'/config/config.php';
  require_once dirname(dirname(__DIR__)).'/models/certificate.php';
  
  $db = new Database;
  $model = new Certificate($db);

  $data = json_decode(file_get_contents('php://input'));


  $data = [
    'certificateno' => $data->certificateno,
    'firstname' => $data->firstname,
    'surname' => $data->surname,
    'othernames' => $data->othernames,
    'course' => $data->course,
    'expirydate' => $data->expirydate,
    'cert_type' => $data->cert_type,
  ];

  if (checkAPIKEY()) {
    if ($model->create($data)) {
      echo json_encode(
        array('message' => 'Certificate Created')
      );
    } else {
      echo json_encode(
        array('message' => 'Certificate Not Created')
      );
    }

  } else {
    echo json_encode(
        array('message' => 'Unauthorized request')
      );
  }

  