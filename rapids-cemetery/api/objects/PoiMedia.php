<?php
class PoiMedia{
 
    // database connection and table name
    private $conn;
    private $table_name = "poi_media";
 
    // object properties\
    public $media_id;
    public $poiID;
    public $filename;
    public $type;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read products
    function read($poiID = null){
        if (isset($poiID)){
            // select by id query
            $query = "SELECT *
                      FROM " . $this->table_name . "
                      WHERE poiID = ?;";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(1, $poiID, PDO::PARAM_INT);
        } else {
            // select all query
            $query = "SELECT *
                      FROM " . $this->table_name . ";";
            
            $stmt = $this->conn->prepare($query);
        }
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}
