<?php
	// <!-- Get Session data -->
	include "./life.php";

	// Check for valid Admin session
	if ($_SESSION['type'] != "A") {
	    // if not send to login page
		header('Location: ../login.php');
		exit;
	}

	include '../../database.php';

	$database = new Database();
	$db = $database->getConnection();

	$apiKeyQuery = $db->prepare("SELECT data FROM global WHERE name = 'map_api_key';");

	$apiKeyQuery->execute();

	$apiKey = $apiKeyQuery->fetchColumn();
?>

<link rel="stylesheet" href="js/leaflet/leaflet.css" type="text/css" />
<script src="js/leaflet/leaflet.js" type="text/javascript"></script>

<link rel="stylesheet" href="js/leaflet/leaflet.pm.css" type="text/css" />
<script src="js/leaflet/leaflet.pm.min.js" type="text/javascript"></script>

<script src="js/coordinateInput.js" type="text/javascript"></script>

<div id="poiCoordsMap">

</div>

<script type="text/javascript">
	var coordinateInput = new coordinateInput(
		"poiCoordsMap",
		43.129490778815814,
		-77.63922348618507,
		12,
		12,
		false,
		'<?php echo $apiKey; ?>'
	);
</script>