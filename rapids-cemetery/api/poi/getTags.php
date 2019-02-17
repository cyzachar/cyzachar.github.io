<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../database.php';
include_once '../objects/Tag.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$tag = new Tag($db);
 
// read poi will be here
// query poi
$stmt = $tag->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $tag_arr=array();
    $tag_arr["tags"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $tag_item=array(
            "tag_id" => $tag_id,
            "poiId" => $poiID,
            "tag_name" => $tag_name
        );
 
        array_push($tag_arr["tags"], $tag_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($tag_arr);
}
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Tags found.")
    );
}