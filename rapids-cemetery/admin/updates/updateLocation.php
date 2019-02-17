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


// Loc variables///////////////////////////////////////////////////////////////////////////////////////////////////
$locName 		= "name";
$locDesc 		= "desc";
$is_trail 		= "false";
$locUrl			= "url";
$coords  		= ["test"];
$imgFile  		= "filename";
$mediaType		= "image";

// bool to track if transaction was successful
$update_success = True;

// tag array
$tagArray = [];

// store last AI ID for tag and media updatesupdate_success
$last_auto_inc = 0;

// get post data///////////////////////////////////////////////////////////////////////////////////////////////////
// TODO - may want to validate more fields
if (isset($_POST['locName'])) {
    if (!isset($_POST['locDesc']) ||
        !isset($_GET['id'])
    ) {
    	echo '<font color="red">Please complete all required fields</font><br>';
    }
	else {
		$locName		= $_POST['locName'];
		$locUrl			= $_POST['locUrl'];
		$locDesc 		= $_POST['locDesc'];
		if ( isset($_POST['is_trail']) ) {
			$is_trail 		= $_POST['is_trail'];    
		}
		$imgFile     	= $_POST['imgFile'];
		$coords         = $_POST['poiCoords'];
		$thisLoc		= $_GET['id'];

	}
}

// // Make sure we have the POST data - TESTS
echo $locName. "</br>";
echo $locUrl. "</br>";
echo $locDesc. "</br>";
echo $is_trail. "</br>";
echo $coords. "</br>";
echo $thisLoc. "</br>";

$coordsArray = json_decode($coords);

// see if this is a trail location
if ($is_trail == "trail") {
	$is_trail = 1; // MySQL True
}
else {
	$is_trail = 0; // MySQL False
}

// QUERIES //////////////////////////////////////////////////////////////////////
// update Loc MySQL
$updateLoc = (
	"
	UPDATE location
	SET 
		hl_name = ?, 
		hl_desc = ?, 
		hl_url = ?,
		is_trail = ?
	WHERE hlID = ?
	;"
);

// update media filnames MySQL
$updateLocMedia = (
	"
	UPDATE loc_media
	SET
		filename = ?, 
		type = ?
	WHERE hlID = ?
	;"
);

// delete coordinates MySQL
$deleteCoords = (
	"
	DELETE FROM loc_coordinate
	WHERE hlID = ?
	;"
);

// insert coordinates MySQL
$insertLocCoord = (
	"
	INSERT INTO loc_coordinate
	(`order`, lat, `long`, hlID)
	VALUES (?,?,?,?)
	;"
);


// Execute all statements in transaction////////////////////////////////////////////////////////////////////
try {
	/* Begin a transaction, turning off autocommit */
	$db->beginTransaction();

	// update LocS ////////////////////////////////////////////////////////////////////
	// Prepare Statement
	$updateLocStmt = $db->prepare($updateLoc);

	// Bind Parameters
	$updateLocStmt->bindParam(1, $locName, PDO::PARAM_STR);
	$updateLocStmt->bindParam(2, $locDesc, PDO::PARAM_STR);
	$updateLocStmt->bindParam(3, $locUrl, PDO::PARAM_STR);
	$updateLocStmt->bindParam(4, $is_trail, PDO::PARAM_BOOL);
	$updateLocStmt->bindParam(5, $thisLoc, PDO::PARAM_INT);

	// Execute Loc update
	$updateLocStmt->execute();

	// // update MEDIA ////////////////////////////////////////////////////////////////////
	// // Prepare Statement
	// if($filename != "") {
	// 	$updateLocMediaStmt = $db->prepare($updateLocMedia);

	// 	// Bind Parameters - use the last_auto_inc of Loc update 
	// 	$updateLocMediaStmt->bindParam(1, $last_auto_inc, PDO::PARAM_INT);
	// 	$updateLocMediaStmt->bindParam(2, $filename, PDO::PARAM_STR);
	// 	$updateLocMediaStmt->bindParam(3, $mediaType, PDO::PARAM_STR);

	// 	// Execute update
	// 	$updateLocMediaStmt->execute();
	// }

	// DELETE COORDS first /////////////////////////////////////////////////////////////////
	$deleteLocCoordStmt = $db->prepare($deleteCoords);

	// Bind Parameters
	$deleteLocCoordStmt->bindParam(1, $thisLoc, PDO::PARAM_INT);

	// Execute tag delete
	$deleteLocCoordStmt->execute();

	// then INSERT new COORDS ////////////////////////////////////////////////////////////////

	for ($order = 0; $order < count($coordsArray); $order++) {
		// Prepare Statement
		$insertLocCoordStmt = $db->prepare($insertLocCoord);

		$coord = $coordsArray[$order];

		// Bind Parameters - use the last_auto_inc of Loc insert 
		$insertLocCoordStmt->bindParam(1, $order, PDO::PARAM_INT);
		$insertLocCoordStmt->bindValue(2, strval($coord->lat), PDO::PARAM_STR);
		$insertLocCoordStmt->bindValue(3, strval($coord->lng), PDO::PARAM_STR);
		$insertLocCoordStmt->bindParam(4, $thisLoc, PDO::PARAM_INT);

		// Execute insert
		$insertLocCoordStmt->execute();
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



// Send User back to Loc List//////////////////////////////////////////////////////////////////////
if($update_success) {
	// redirect back to LocList.php with success message  
	header('Location: ../historicList.php?success=yes');
	exit;
}
else {
	// redirect back to LocList.php with fail message  
	header('Location: ../historicList.php?success=no');
	exit;
}




?> <!-- // php end -->