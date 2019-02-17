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
$is_trail 		= "";
$locUrl			= "url";
$coords  		= ["test"];
$imgFile  		= "filename";
$mediaType		= "image";

// bool to track if transaction was successful
$insert_success = True;

// tag array
$tagArray = [];

// store last AI ID for tag and media inserts
$last_auto_inc = 0;

// get post data///////////////////////////////////////////////////////////////////////////////////////////////////
// TODO - may want to validate more fields
if (isset($_POST['locName'])) {
    if (!isset($_POST['locDesc'])
    ) {
    	echo '<font color="red">Please complete all required fields</font><br>';
    }
	else {
		$locName		= $_POST['locName'];
		$locUrl			= $_POST['locUrl'];
		$locDesc 		= $_POST['locDesc'];
		$is_trail 		= $_POST['is_trail'];    
		$imgFile     	= $_POST['imgFile'];
		$coords         = $_POST['poiCoords'];

	}
}

// // Make sure we have the POST data - TESTS
echo $locName . "</br>";
echo $locUrl  . "</br>";
echo $locDesc . "</br>";
echo $is_trail . "</br>";
echo $imgFile . "</br>";
echo $coords  . "</br>";

$coordsArray = json_decode($coords);

// see if this is a trail location
if ($is_trail == "trail") {
	$is_trail = 1; // MySQL True
}
else {
	$is_trail = 0; // MySQL False
}


// QUERIES //////////////////////////////////////////////////////////////////////
// insert Loc MySQL
$insertLoc = (
	"
	INSERT INTO location
	(hl_name, hl_desc, hl_url, is_trail)
	VALUES (?,?,?,?)
	;"
);

// insert media filnames MySQL
$insertLocMedia = (
	"
	INSERT INTO loc_media
	(hlID, filename, type)
	VALUES (?,?,?)
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

	// INSERT LOCATION ////////////////////////////////////////////////////////////////////
	// Prepare Statement
	$insertLocStmt = $db->prepare($insertLoc);

	// Bind Parameters
	$insertLocStmt->bindParam(1, $locName, PDO::PARAM_STR);
	$insertLocStmt->bindParam(2, $locDesc, PDO::PARAM_STR); 
	$insertLocStmt->bindParam(3, $locUrl,  PDO::PARAM_STR);
	$insertLocStmt->bindParam(4, $is_trail, PDO::PARAM_BOOL);

	// Execute Loc insert
	$insertLocStmt->execute();

	// Get Last AI ID
	$last_auto_inc = $db->lastInsertId();

	// INSERT LOCATION MEDIA ////////////////////////////////////////////////////////////////////
	// Prepare Statement
	if($imgFile != "") {
		$insertLocMediaStmt = $db->prepare($insertLocMedia);

		// Bind Parameters - use the last_auto_inc of Loc insert 
		$insertLocMediaStmt->bindParam(1, $last_auto_inc, PDO::PARAM_INT);
		$insertLocMediaStmt->bindParam(2, $imgFile, PDO::PARAM_STR);
		$insertLocMediaStmt->bindParam(3, $mediaType, PDO::PARAM_STR);

		// Execute insert
		$insertLocMediaStmt->execute();
	}

	// INSERT LOCATION COORDS //////////////////////////////////////////////////////////////////////

	for ($order = 0; $order < count($coordsArray); $order++) {
		// Prepare Statement
		$insertLocCoordStmt = $db->prepare($insertLocCoord);

		$coord = $coordsArray[$order];

		// Bind Parameters - use the last_auto_inc of Loc insert 
		$insertLocCoordStmt->bindParam(1, $order, PDO::PARAM_INT);
		$insertLocCoordStmt->bindValue(2, strval($coord->lat), PDO::PARAM_STR);
		$insertLocCoordStmt->bindValue(3, strval($coord->lng), PDO::PARAM_STR);
		$insertLocCoordStmt->bindParam(4, $last_auto_inc, PDO::PARAM_INT);

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
    $insert_success = False;
}



// Send User back to Loc List//////////////////////////////////////////////////////////////////////
if($insert_success) {
	// redirect back to LocList.php with success message  
	echo("GOOD");
	header('Location: ../historicList.php?success=yes');
	exit;
}
else {
	// redirect back to LocList.php with fail message  
	echo("FAIL");
	header('Location: ../historicList.php?success=no');
	exit;
}




?> <!-- // php end -->