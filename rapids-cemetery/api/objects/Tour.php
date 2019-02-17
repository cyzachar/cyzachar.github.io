<?php
class Tour{
 
    // database connection and table name
    private $conn;
    private $table_name = "tour";
 
    // object properties\
    public $poiID;
    public $tour_order;
    public $tour_id;
 
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
