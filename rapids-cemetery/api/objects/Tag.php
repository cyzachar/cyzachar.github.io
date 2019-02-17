<?php
class Tag{
 
    // database connection and table name
    private $conn;
    private $table_name = "tag";
 
    // object properties\
    public $tag_id;
    public $poiID;
    public $tag_name;
 
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
                      WHERE poiID = ?
                      ORDER BY `tag_name`;";

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
