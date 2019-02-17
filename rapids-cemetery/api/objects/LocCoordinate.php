<?php
class LocCoordinate{
 
    // database connection and table name
    private $conn;
    private $table_name = "loc_coordinate";
 
    // object properties\
    public $loc_point_id;
    public $order;
    public $lat;
    public $long;
    public $hlID;
 
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
