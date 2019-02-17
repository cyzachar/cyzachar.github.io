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
$update_success = True;

// tag array
$tagArray = [];

// store last AI ID for tag and media updates
$last_auto_inc = 0;

// get post data///////////////////////////////////////////////////////////////////////////////////////////////////
// TODO - may want to validate more fields
if (isset($_POST['poiName'])) {
    if (!isset($_POST['poiDesc']) ||
        !isset($_GET['id'])	
    ) {
    	echo '<font color="red">Please complete all required fields</font><br>';
    }
	else {
		$thisPoi		= $_GET['id'];
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

echo $thisPoi. "</br>";

// update poi tags into tag table //////////////////////////////////////////////////////////////////////
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
// update PoI MySQL
$updatePoi = (
	"
	UPDATE point_of_interest
	SET 
		poiName = ?, 
		poiDescription = ?, 
		visible = ?
	WHERE poiID = ?
	;"
);

// delete Tag MySQL
$deleteTag = (
	"
	DELETE FROM tag
	WHERE poiID = ?
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

// update media filnames MySQL
$updatePoiMedia = (
	"
	UPDATE poi_media
	SET
		poiID = ?, 
		filename = ?, 
		type = ?
	WHERE poiID = ?
	;"
);

// delete coordinates MySQL
$deleteCoords = (
	"
	DELETE FROM poi_coordinate
	WHERE poiID = ?
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

	// update POIS ////////////////////////////////////////////////////////////////////
	// Prepare Statement
	$updatePoiStmt = $db->prepare($updatePoi);

	// Bind Parameters
	$updatePoiStmt->bindParam(1, $poiName, PDO::PARAM_STR);
	$updatePoiStmt->bindParam(2, $poiDescription, PDO::PARAM_STR);
	$updatePoiStmt->bindParam(3, $visible, PDO::PARAM_BOOL);
	$updatePoiStmt->bindParam(4, $thisPoi, PDO::PARAM_INT);

	// Execute PoI update
	$updatePoiStmt->execute();

	// delete TAGS first ////////////////////////////////////////////////////////////////
	$deleteTagStmt = $db->prepare($deleteTag);

	// Bind Parameters
	$deleteTagStmt->bindParam(1, $thisPoi, PDO::PARAM_INT);

	// Execute tag delete
	$deleteTagStmt->execute();

	// then insert new TAGS /////////////////////////////////////////////////////////////////
	if(sizeof($tagArray) > 0) {
		foreach($tagArray as $tag) {
			// Prepare Statement
			$updateTagStmt = $db->prepare($insertTag);

			// Bind Parameters - use the last_auto_inc of PoI update 
			$updateTagStmt->bindParam(1, $thisPoi, PDO::PARAM_INT);
			$updateTagStmt->bindParam(2, $tag, PDO::PARAM_STR);

			$updateTagStmt->execute();
		} // for each tag end
	} // end tag insert

	// // update MEDIA ////////////////////////////////////////////////////////////////////
	// // Prepare Statement
	// if($filename != "") {
	// 	$updatePoiMediaStmt = $db->prepare($updatePoiMedia);

	// 	// Bind Parameters - use the last_auto_inc of PoI update 
	// 	$updatePoiMediaStmt->bindParam(1, $last_auto_inc, PDO::PARAM_INT);
	// 	$updatePoiMediaStmt->bindParam(2, $filename, PDO::PARAM_STR);
	// 	$updatePoiMediaStmt->bindParam(3, $mediaType, PDO::PARAM_STR);

	// 	// Execute update
	// 	$updatePoiMediaStmt->execute();
	// }

	// DELETE COORDS first /////////////////////////////////////////////////////////////////
	$deletePoiCoordStmt = $db->prepare($deleteCoords);

	// Bind Parameters
	$deletePoiCoordStmt->bindParam(1, $thisPoi, PDO::PARAM_INT);

	// Execute tag delete
	$deletePoiCoordStmt->execute();

	// then INSERT new COORDS ////////////////////////////////////////////////////////////////

	for ($order = 0; $order < count($coordsArray); $order++) {
		// Prepare Statement
		$insertPoiCoordStmt = $db->prepare($insertPoiCoord);

		$coord = $coordsArray[$order];

		// Bind Parameters - use the last_auto_inc of PoI insert 
		$insertPoiCoordStmt->bindParam(1, $order, PDO::PARAM_INT);
		$insertPoiCoordStmt->bindValue(2, strval($coord->lat), PDO::PARAM_STR);
		$insertPoiCoordStmt->bindValue(3, strval($coord->lng), PDO::PARAM_STR);
		$insertPoiCoordStmt->bindParam(4, $thisPoi, PDO::PARAM_INT);

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
    $update_success = False;
}



// Send User back to PoI List//////////////////////////////////////////////////////////////////////
if($update_success) {
	// redirect back to poiList.php with success message  
	header('Location: ../poiList.php?update=yes');
	exit;
}
else {
	// redirect back to poiList.php with fail message  
	header('Location: ../poiList.php?update=no');
	exit;
}




?> <!-- // php end -->