<!-- Get Session data -->
<?php
  include "life.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/login.css">
  	<title>Rapids Cemetery Admin</title>
    <?php include "includes/resources.php"; ?>
    <script>
      //fill list of POIs on load
			$( window ).on( "load", function() {
				loadPOI();
      });
    </script>
  </head>
  <body>
    <!-- Login Header Banner -->
    <?php
      include("includes/adminBanner.php");
    ?>

    <?php include "includes/header.php"; ?>
    <div id = "content">

      <!-- Insert Success Message -->
      <style>
        .suc_yes {color: green;}
        .suc_no  {color: red;}
      </style>
      <?php
        $success_type = "Point of Interest";

        if(isset($_GET['success'])){
          if($_GET['success'] == "yes") {
            echo("<h4 class='suc_yes'>". $success_type." Successfully added!</h4><br/>");
          }
          elseif ($_GET['success'] == "no") {
            echo("<h4 class='suc_no'>Failed to add ". $success_type."</h4><br/>");
          }

        }
      ?>


      <h2>Points of Interest</h2>
      <a href = "editPoi.php"><button type = "button">Add New</button></a>
      <div id = "poiList">
        <!--Point of Interest rows will be added here-->
      </div>
    </div>
  </body>
</html>
