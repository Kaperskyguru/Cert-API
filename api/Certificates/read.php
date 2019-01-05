<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once dirname(dirname(__DIR__)).'/config/database.php';
require_once dirname(dirname(__DIR__)).'/config/config.php';
require_once dirname(dirname(__DIR__)).'/models/certificate.php';

$db = new Database;
$model = new Certificate($db);

if (checkAPIKEY()) {

    if (isset($_GET['certificateno'])) {
        $result = $model->read($_GET['certificateno']);
    } else {
        $result = $model->read();
    }

    if ($result->rowCount() > 0) {
        $cert = array();

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $cert_item = array(
                'id' => $row->Id,
                'certificateno' => $row->certificateno,
                'firstname' => $row->firstname,
                'surname' => $row->surname,
                'othernames' => $row->othernames,
                'course' => $row->course,
                'expirydate' => $row->expirydate,
                'cert_type' => $row->cert_type,
            );

            array_push($cert, $cert_item);
        }
        echo json_encode($cert);

    } else {
        echo json_encode(
        array('message' => 'No Cert Found')
        );
    }

} else {
    echo json_encode(
      array('message' => 'Unauthorized request')
    );
  }


