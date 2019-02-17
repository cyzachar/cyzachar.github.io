<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../database.php';
include_once '../objects/Timeline.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$timeline = new Timeline($db);
 
// read poi will be here
// query poi
$stmt = $timeline->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $tl_arr=array();
    $tl_arr["timeline"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $tl_item=array(
            "timeID" => $timeID,
            "point_name" => $point_name,
            "point_year" => $point_year,
            "point_tooltip" => $point_tooltip
        );
 
        array_push($tl_arr["timeline"], $tl_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($tl_arr);
}
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Timline Points found.")
    );
}