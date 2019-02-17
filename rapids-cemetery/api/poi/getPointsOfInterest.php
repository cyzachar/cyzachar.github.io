<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../database.php';
include_once '../objects/PointOfInterest.php';
include_once '../objects/PoiMedia.php';
include_once '../objects/PoiCoordinate.php';
include_once '../objects/Tag.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$pointOfInterest = new PointOfInterest($db);
 
// read poi will be here
// query poi
$stmt = $pointOfInterest->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $poi_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $poi_item=array(
            "id" => $poiID,
            "name" => $poiName,
            "description" => html_entity_decode($poiDescription),
            "media" => getMedia($db, $poiID),
            "coordinates" => getCoords($db, $poiID),
            "tags" => getTags($db, $poiID)
        );
 
        array_push($poi_arr, $poi_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($poi_arr);
}
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Points of Interest found.")
    );
}

//////////////////////////////////////////////////////////////////////////////////////
function getMedia($db, $poi){
    $poi_media = new PoiMedia($db);
    
    // read poi will be here
    // query poi
    $stmt = $poi_media->read($poi);
    $num = $stmt->rowCount();
    
    // products array
    $poi_media_arr=array();

    // check if more than 0 record found
    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
    
            $poi_media_item=array(
                "id" => $media_id,
                "filename" => $filename,
                "type" => $type
            );
    
            array_push($poi_media_arr, $poi_media_item);
        }
    }

    return $poi_media_arr;
}

//////////////////////////////////////////////////////////////////////////////////////
function getCoords($db, $poi){
    $poi_coordinate = new PoiCoordinate($db);
    
    // read poi will be here
    // query poi
    $stmt = $poi_coordinate->read($poi);
    $num = $stmt->rowCount();
    
    // products array
    $poi_coord_arr=array();

    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
     
            $poi_coord_item=array(
                "lat" => $lat,
                "lng" => $long,
            );
     
            array_push($poi_coord_arr, $poi_coord_item);
        }
    }

    return $poi_coord_arr;
}

//////////////////////////////////////////////////////////////////////////////////////
function getTags($db, $poi){
    $poi_tag = new Tag($db);
    
    // read tag will be here
    // query tag
    $stmt = $poi_tag->read($poi);
    $num = $stmt->rowCount();
    
    // products array
    $tag_arr=array();

    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);

            array_push($tag_arr, $tag_name);
        }
    }

    return $tag_arr;
}