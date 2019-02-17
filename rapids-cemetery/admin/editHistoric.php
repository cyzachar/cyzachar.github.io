<!-- Get Session data -->
<?php
  include "life.php";
?>

<!DOCTYPE html>
<html>
  <head>
  	<title>Rapids Cemetery Admin</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <?php include "includes/resources.php" ?>
    <?php
        $locName = "";
        $locDesc = "";
        $locUrl = "";
        $pgAction = "Add";

        //if id included in url get data for location w/ particular id
        if(!empty($_GET['id'])){
          //get name & description
          $locId = $_GET['id'];
          $data = json_decode(file_get_contents("testData.json"), true);
          $pgAction = "Edit";
          foreach ($data["locations"] as $aLoc) {
            if($aLoc["hlID"] == $locId){
              $locName = $aLoc["hl_name"];
              $locDesc = $aLoc["hl_desc"];
              $locUrl = $aLoc["hl_url"];
              break;
            }
          }
        }
    ?>
  </head>
  <body>
    <!-- Login Header Banner -->
    <?php
      include("includes/adminBanner.php");
    ?>
    <?php include "includes/header.php"; ?>
    <div id = "content">
      <h2><?php echo $pgAction; ?> Historic Location</h2>

      <!-- Check if This is editing an existing PoI or Adding a New One -->
      <!-- Applies to form action -->
      <?php
        // if id GET is set, this is updating
        if($pgAction == "Edit") { 
          $fileAction = "updates/updateLocation.php?id=".$locId;
        }
        // if it is not set, this is inserting
        else {
          $fileAction = "inserts/insertLocation.php";
        }
      ?>

      <form id= "locForm" method="POST" action="<?php echo $fileAction; ?>">
        <!--name, desc, url fields-->
        Name: <input type="text" id = "locName" name = "locName" value = "<?php echo $locName; ?>"/>
        Web Address: <input type="text" id = "locUrl" name = "locUrl" value = "<?php echo $locUrl; ?>"/>
        Description: <textarea id = "locDesc" name = "locDesc" rows="8" cols="50"><?php echo $locDesc; ?></textarea>

        <!--images upload section-->
        <h3>Images</h3>
        <div id = "historicImgs"></div>
        <input type = 'file' id = "imgFile" name = "imgFile" accept = "image/png, image/jpeg, image/gif"/>
        <button type = "button" id = "addImg" onclick = 'uploadImg("historicImgs")'>Add image</button>

        
        <!--location section (placeholder)-->
        <h3>Location</h3>
        
        <!-- is trail checkbox -->
        <style>
          #is_trail {
            position: relative;
            left: -418px;
          }
          #is_trail_text {
            position: relative;
            top: -23px;
            left: 20px;
            font-weight: bold;
          }
        </style>
        <input type="checkbox" id="is_trail" name="is_trail" value="trail">
        <span id="is_trail_text">Check if this location is a Trail</span><br>

        <?php include "includes/coordinateInputLoc.php"; ?>
        <input type="hidden" id="poiCoords" name="poiCoords" value="" />

        <!--submit and cancel buttons-->
        <div id = "formControls">
          <input type="submit" value = "<?php echo (($pgAction == "Add") ? "Add" : "Update") . " Historic Location";?>"/>
          <a href = "historicList.php"><button type = "button">Cancel</button></a>
        </div>

      </form>
      <script type="text/javascript">
        $('#locForm').submit(function() {
          $('#poiCoords').val(JSON.stringify(coordinateInput.getCoords()));
          console.log($('#poiCoords').val());
        });
      </script>

    </div>  <!--end content div-->
  </body>
</html>
