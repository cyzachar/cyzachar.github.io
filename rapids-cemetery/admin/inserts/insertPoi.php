<?php
// <!-- Get Session data -->
include "../life.php";

// Check for valid Admin session
if ($_SESSION['type'] != "A") {
    // if not send to login page
	header('Location: ../login.php');
	exit;
}


// include database file
include '../../../database.php';
// instantiate database object and get connection
$database = new Database();
$db = $database->getConnection();


// PoI variables///////////////////////////////////////////////////////////////////////////////////////////////////
$poiName 		= "";
$poiDescription = "";
$visible 		= 0;
$tags 			= [];
$coords  		= [];
$filename  		= "";
$mediaType		= "image";

// bool to track if transaction was successful
$insert_success = True;

// tag array
$tagArray = [];

// store last AI ID for tag and media inserts
$last_auto_inc = 0;

// get post data///////////////////////////////////////////////////////////////////////////////////////////////////
// TODO - may want to validate more fields
if (isset($_POST['poiName'])) {
    if (!isset($_POST['poiDesc'])
    ) {
    	echo '<font color="red">Please complete all required fields</font><br>';
    }
	else {
		$poiName		= $_POST['poiName'];
		$poiDescription = $_POST['poiDesc'];
		$visible 		= 1;
		$tags 			= $_POST['poiTags'];
		$coords 		= $_POST['poiCoords'];
		$filename       = $_POST['imgFile'];

	}
}

// // Make sure we have the POST data - TESTS
// echo $poiName. "</br>";
// echo $poiDescription. "</br>";
// echo $visible. "</br>";
// echo $tags. "</br>";
// echo $filenames. "</br>";

// insert poi tags into tag table //////////////////////////////////////////////////////////////////////
// Format Tags - $_POST['poiTags'] is returned as a string like: ["Garden","Burial"]
if($tags != "[]") {
	$tf1 = str_replace("[", "", $tags); // get rid of leading [
	$tf2 = str_replace("]", "", $tf1);  // get rid of ending [
	$tf3 = str_replace('"', "", $tf2);  // get rid of quotes
	$tagArray = explode(",", $tf3);     // split by comma(s)
}

//$tagArray = json_decode($tags);

$coordsArray = json_decode($coords);

// QUERIES //////////////////////////////////////////////////////////////////////
// insert PoI MySQL
$insertPoi = (
	"
	INSERT INTO point_of_interest
	(poiName, poiDescription, visible)
	VALUES (?,?,?)
	;"
);

// insert Tag MySQL
$insertTag = (
	"
	INSERT INTO tag
	(poiID, tag_name)
	VALUES (?,?)
	;"
);

// insert media filnames MySQL
$insertPoiMedia = (
	"
	INSERT INTO poi_media
	(poiID, filename, type)
	VALUES (?,?,?)
	;"
);

// insert coordinates MySQL
$insertPoiCoord = (
	"
	INSERT INTO poi_coordinate
	(`order`, lat, `long`, poiID)
	VALUES (?,?,?,?)
	;"
);


// Execute all statements in transaction////////////////////////////////////////////////////////////////////
try {
	/* Begin a transaction, turning off autocommit */
	$db->beginTransaction();

	// INSERT POIS ////////////////////////////////////////////////////////////////////
	// Prepare Statement
	$insertPoiStmt = $db->prepare($insertPoi);

	// Bind Parameters
	$insertPoiStmt->bindParam(1, $poiName, PDO::PARAM_STR);
	$insertPoiStmt->bindParam(2, $poiDescription, PDO::PARAM_STR);
	$insertPoiStmt->bindParam(3, $visible, PDO::PARAM_BOOL);

	// Execute PoI insert
	$insertPoiStmt->execute();

	// Get Last AI ID
	$last_auto_inc = $db->lastInsertId();

	// INSERT TAGS ////////////////////////////////////////////////////////////////////
	if(sizeof($tagArray) > 0) {
		foreach($tagArray as $tag) {
			// Prepare Statement
			$insertTagStmt = $db->prepare($insertTag);

			// Bind Parameters - use the last_auto_inc of PoI insert 
			$insertTagStmt->bindParam(1, $last_auto_inc, PDO::PARAM_INT);
			$insertTagStmt->bindParam(2, $tag, PDO::PARAM_STR);

			$insertTagStmt->execute();
		} // for each tag end
	}

	// INSERT MEDIA ////////////////////////////////////////////////////////////////////
	// Prepare Statement
	if($filename != "") {
		$insertPoiMediaStmt = $db->prepare($insertPoiMedia);

		// Bind Parameters - use the last_auto_inc of PoI insert 
		$insertPoiMediaStmt->bindParam(1, $last_auto_inc, PDO::PARAM_INT);
		$insertPoiMediaStmt->bindParam(2, $filename, PDO::PARAM_STR);
		$insertPoiMediaStmt->bindParam(3, $mediaType, PDO::PARAM_STR);

		// Execute insert
		$insertPoiMediaStmt->execute();
	}

	// INSERT COORDS //////////////////////////////////////////////////////////////////////

	for ($order = 0; $order < count($coordsArray); $order++) {
		// Prepare Statement
		$insertPoiCoordStmt = $db->prepare($insertPoiCoord);

		$coord = $coordsArray[$order];

		// Bind Parameters - use the last_auto_inc of PoI insert 
		$insertPoiCoordStmt->bindParam(1, $order, PDO::PARAM_INT);
		$insertPoiCoordStmt->bindValue(2, strval($coord->lat), PDO::PARAM_STR);
		$insertPoiCoordStmt->bindValue(3, strval($coord->lng), PDO::PARAM_STR);
		$insertPoiCoordStmt->bindParam(4, $last_auto_inc, PDO::PARAM_INT);

		// Execute insert
		$insertPoiCoordStmt->execute();
	}

	/////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////
    //We've got this far without an exception, so commit the changes.
    $db->commit();
} 
//Our catch block will handle any exceptions that are thrown.
catch(Exception $e){
    //An exception has occured, which means that one of our database queries
    //failed.
    //Print out the error message.
    echo $e->getMessage();
    //Rollback the transaction.
    $db->rollBack();

    // transaction failed - set boolean
    $insert_success = False;
}



// Send User back to PoI List//////////////////////////////////////////////////////////////////////
if($insert_success) {
	// redirect back to poiList.php with success message  
	header('Location: ../poiList.php?success=yes');
	exit;
}
else {
	// redirect back to poiList.php with fail message  
	header('Location: ../poiList.php?success=no');
	exit;
}




?> <!-- // php end -->