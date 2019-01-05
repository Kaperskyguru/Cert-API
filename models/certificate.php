<?php 

class Certificate {
    private $db;
    private $con;

    public function __construct(Database $db){
        $this->db = $db ;
        $this->con = $this->db->connect();
    }

    public function read(int $id = 0)
    {
       if ($id == 0) {
           // Read all
           $query = "SELECT * FROM certificates ORDER BY id DESC";
           $stmt = $this->con->prepare($query);
           $stmt->execute();
           return $stmt;

       } else {
           // Read Single
           $query = "SELECT * FROM certificates WHERE certificateno = :id ORDER BY id DESC";
           $stmt = $this->con->prepare($query);
           $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt;
       }
       
    }

    public function create(array $data)
    {
        $data = $this->cleanUpArray($data);
        $query = "INSERT INTO certificates (certificateno,firstname,surname,othernames,course,expirydate,cert_type) VALUES (:certificateno,:firstname,:surname,:othernames,:course,:expirydate,:cert_type)";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':certificateno', $data['certificateno']);
        $stmt->bindParam(':firstname', $data['firstname']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':othernames', $data['othernames']);
        $stmt->bindParam(':course', $data['course']);
        $stmt->bindParam(':expirydate', $data['expirydate']);
        $stmt->bindParam(':cert_type', $data['cert_type']);
        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
        
    }

    public function update(array $data, int $no)
    {
        $data = $this->cleanUpArray($data);
        unset($data['certificateno']);
        
        $paramsArray = [];
        foreach($data as $key => $value) {
            array_push($paramsArray, $key." = :".$key);
        }

        $params = implode(', ', $paramsArray);

        $query = "UPDATE certificates SET {$params} WHERE certificateno = :id";

        $stmt = $this->con->prepare($query);
        foreach($data as $column => $value) {
            $stmt->bindParam(":".$column, $value);
        }

        $stmt->bindParam(":id", $no);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete($id = 0)
    {
        if ($id == 0) {
            $query = "DELETE FROM certificates WHERE 1";
            $stmt = $this->con->prepare($query);
            return $stmt->execute();
        } else {
            $query = "DELETE FROM certificates WHERE certificateno = :id";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

    }

    private function cleanUpArray(array $data)
    {
        return filter_var_array($data, FILTER_SANITIZE_STRING); 
    }

}



