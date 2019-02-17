<?php
  $filename = $_FILES["file"]["name"];
  if($filename != ''){
    $location = 'assets/' . $filename;
    move_uploaded_file($_FILES["file"]["tmp_name"], $location);
    echo $location;
  }
?>
