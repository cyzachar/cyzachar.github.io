<!-- Get Session data -->
<?php
  //include "life.php";
?>

<!DOCTYPE html>
<html>
  <head>
  	<title>Rapids Cemetery Admin</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <?php include "includes/resources.php"; ?>
    <script>
			$(document).ready(function(){
        //fill dual list with names of POI and existing tour stops
        getTourData(function(poiNames, tourStops){
          var dualList = $("#dualList").DualSelectList({
            'candidateItems' : poiNames,
            'selectionItems' : tourStops,
    				'colors' : {
    					'itemText' : 'black',
    					'itemBackground' : 'white',
    					'itemHoverBackground' : 'lightgray'
    				}
          });

          //add onclick to save button
          $("button#saveTour").click(function(){
            updateTour(dualList);
          });
        }); //end getTourData callback
      }); //end document ready
    </script>
  </head>
  <body>
    <!-- Login Header Banner -->
    <?php
      include("includes/adminBanner.php");
    ?>

    <?php include "includes/header.php"; ?>
    <div id = "content">
      <h2>Edit Tour</h2>
      <p>Click and drag to add, remove, and reorder points of interest in the tour</p>
      <div id = "listHeaders">
        <h3>Not in Tour</h3>
        <h3>In Tour</h3>
      </div>
      <div id = "dualList">
        <!--Two lists of POI in and out of tour will appear here-->
      </div>
      <button id = "saveTour">Save Changes</button>
    </div>
  </body>
</html>
