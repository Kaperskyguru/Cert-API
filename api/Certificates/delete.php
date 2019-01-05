<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once dirname(dirname(__DIR__)).'/config/database.php';
require_once dirname(dirname(__DIR__)).'/config/config.php';
require_once dirname(dirname(__DIR__)).'/models/certificate.php';

$db = new Database;
$model = new Certificate($db);

  if (checkAPIKEY()) {
    isset($_GET['certificateno'])? deleteSingle($_GET['certificateno']): deleteAll();
  } else {
    echo json_encode(
      array('message' => 'Unauthorized request')
    );
  }

  function deleteAll()
  {
    global $model;
    if($model->delete()) {
      echo json_encode(
        array('message' => 'All Certificate Deleted')
      );
    } else {
      echo json_encode(
        array('message' => 'Post Not Deleted')
      );
    }
  }


  function deleteSingle($certno)
  {
    global $model;
    if($model->delete($certno)) {
      echo json_encode(
        array('message' => 'Certificate Deleted')
      );
    } else {
      echo json_encode(
        array('message' => 'Post Not Deleted')
      );
    }
  }
  
    