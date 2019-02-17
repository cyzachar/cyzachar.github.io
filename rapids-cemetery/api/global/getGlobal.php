<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../database.php';
include_once '../objects/GlobalItem.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$global_item = new GlobalItem($db);
 
// read poi will be here
// query poi
$stmt = $global_item->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $global_item_arr=array();
    $global_item_arr["global"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $global_item_item=array(
            "global_id" => $global_item_id,
            "name" => $name,
            "data" => $data
        );
 
        array_push($global_item_arr["global"], $global_item_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($global_item_arr);
}
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Global Vars found.")
    );
}