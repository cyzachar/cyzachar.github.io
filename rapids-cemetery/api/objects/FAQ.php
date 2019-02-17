<?php
class FAQ{
 
    // database connection and table name
    private $conn;
    private $table_name = "faq";
 
    // object properties\
    public $faq_id;
    public $question;
    public $answer;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read products
    function read(){
     
        // select all query
        $query = "SELECT *
                  FROM " . $this->table_name . ";";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}
