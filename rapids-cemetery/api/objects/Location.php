<?php
class Location{
 
    // database connection and table name
    private $conn;
    private $table_name = "location";
 
    // object properties\
    public $hlID;
    public $hl_name;
    public $hl_desc;
    public $hl_url;
    public $is_trail;
 
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
