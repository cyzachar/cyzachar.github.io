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
        $poiName = "";
        $poiDescript = "";
        $poiTags = "";
        $pgAction = "Add";

        //if id included in url get data for poi w/ particular id
        if(!empty($_GET['id'])){
          //get name & description
          $poiId = $_GET['id'];
          $data = json_decode(file_get_contents("testData.json"), true);
          $pgAction = "Edit";
          foreach ($data["poi"] as $aPoi) {
            if($aPoi["poiID"] == $poiId){
              $poiName = $aPoi["poiName"];
              $poiDescript = $aPoi["poiDescription"];
              break;
            }
          }

          //get tags
          $poiTagsArr = [];
          foreach ($data["poiTags"] as $aPoiTag) {
            if($aPoiTag["poiID"] == $poiId){
              array_push($poiTagsArr,$aPoiTag["tag_name"]);
            }
          }
          $poiTags = implode(",",$poiTagsArr);
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
      <h2><?php echo $pgAction; ?> Point of Interest</h2>

      <!-- Check if This is editing an existing PoI or Adding a New One -->
      <!-- Applies to form action -->
      <?php
        // if id GET is set, this is updating
        if($pgAction == "Edit") { 
          $fileAction = "updates/updatePoi.php?id=".$poiId;
        }
        // if it is not set, this is inserting
        else {
          $fileAction = "inserts/insertPoi.php";
        }
      ?>

      <form id="poiForm" method="POST" action="<?php echo $fileAction; ?>">
        <!--name & description fields-->
        Name: <input type="text" id = "poiName" name = "poiName" value = "<?php echo $poiName; ?>"/>
        Description: <textarea id = "poiDescript" name = "poiDesc" rows="8" cols="50"><?php echo $poiDescript; ?></textarea>

        <!--tags field-->
        Tags: <textarea id="tags" rows="1" name = "poiTags" data-starting-tags=<?php echo $poiTags; ?>></textarea>
        <script type = "text/javascript">
          /*set up textext jquery plugin for tags*/
          $.getJSON('testData.json', function(data) {
            $('#tags').textext({
                plugins : 'autocomplete suggestions tags arrow focus prompt',
                tagsItems : $('#tags').attr('data-starting-tags').split(","),
                prompt : 'Add tag by typing here',
                suggestions: data.tags
            });
          });
        </script>
        <!--images upload section-->
        <h3>Images</h3>
        <div id = "poiImgs"></div>
        <input type = 'file' id = "imgFile" name = "imgFile" accept = "image/png, image/jpeg, image/gif"/>
        <button type = "button" id = "addImg" onclick = 'uploadImg("poiImgs")'>Add image</button>

        <!--location section (placeholder)-->
        <h3>Location</h3>
        <?php include "includes/coordinateInput.php"; ?>
        <input type="hidden" id="poiCoords" name="poiCoords" value="" />

        <!--submit and cancel buttons-->
        <div id = "formControls">
          <input type="submit" value = "<?php echo (($pgAction == "Add") ? "Add" : "Update") . " Point of Interest";?>"/>
          <a href = "poiList.php"><button type = "button">Cancel</button></a>
        </div>

      </form>

      <script type="text/javascript">
        $('#poiForm').submit(function() {
          $('#poiCoords').val(JSON.stringify(coordinateInput.getCoords()));
          console.log($('#poiCoords').val());
        });
      </script>
    </div>  <!--end content div-->
  </body>
</html>
