<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../database.php';
include_once '../objects/PoiCoordinate.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$poiCoordinate = new PoiCoordinate($db);
 
// read poi will be here
// query poi
$stmt = $poiCoordinate->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $poi_coord_arr=array();
    $poi_coord_arr["coords"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $poi_coord_item=array(
            "point_id" => $point_id,
            "order" => $order,
            "lat" => $lat,
            "long" => $long,
            "poiID" => $poiID
        );
 
        array_push($poi_coord_arr["coords"], $poi_coord_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($poi_coord_arr);
}
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Point of Interest Coords found.")
    );
}