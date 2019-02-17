<!-- Get Session data -->
<?php
  include "life.php";
?>

<!DOCTYPE html>
<html>
  <head>
  	<title>Rapids Cemetery Admin</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <?php include "includes/resources.php"; ?>
    <script>
      //fill list of POIs on load
			$( window ).on( "load", function() {
				loadHistoric();
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
        $success_type = "Historic Location";

        if(isset($_GET['success'])){
          if($_GET['success'] == "yes") {
            echo("<h4 class='suc_yes'>". $success_type." Successfully added!</h4><br/>");
          }
          elseif ($_GET['success'] == "no") {
            echo("<h4 class='suc_no'>Failed to add ". $success_type."</h4><br/>");
          }

        }
      ?>

      <h2>Historic Locations</h2>
      <a href = "editHistoric.php"><button type = "button">Add New</button></a>
      <div id = "historicList">
        <!--historical location rows will be added here-->
      </div>
    </div>
  </body>
</html>
