<?php
  
  $invalid = False;
  $correct = False;

  $username = "admin";

  // ONLY if username and password are not empty (aka after pushing login button)
  if ( !empty($_POST['sqa1']) && !empty($_POST['sqa2']) && !empty($_POST['sqa3']) ) {

    // Cred variables
    $sqa1_post = $_POST['sqa1'];
    $sqa2_post = $_POST['sqa2'];
    $sqa3_post = $_POST['sqa3'];
    // Get DB connection
    include '../../database.php';

    // instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

    // Prepare Query to get hashed pw from DB. based on username entered in login form
    $securityQuery = $db->prepare('
      SELECT sqa1, sqa2, sqa3 FROM adminUsers WHERE username = "'.$username.'"
      ');

    // execute query
    $securityQuery->execute();

    // set the hashed variable
    $securityAnswers = $securityQuery->fetchAll();

    foreach ($securityAnswers as $row) {
      if( $row["sqa1"] == $sqa1_post && $row["sqa2"] == $sqa2_post && $row["sqa3"] == $sqa3_post ) {
        $correct = True;
      }
      else {
        $invalid = True;
      }
    }
  } // if - security fields end

  // if new passwords are set and they equal eachother
  if( !empty($_POST['newPass1']) && !empty($_POST['newPass2']) && $_POST['newPass1'] == $_POST['newPass2']) {
    $options = [
        'cost' => 12,
    ];

    // hash new pass
    $newpass = password_hash($_POST['newPass1'], PASSWORD_BCRYPT, $options);

    // Get DB connection
    include '../../database.php';

    // instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

    // password update MySQL
    $passUpdate = $db->prepare('UPDATE adminUsers SET password = ? WHERE username = "'.$username.'"');

    // bind new hashed password
    $passUpdate->bindParam(1, $newpass, PDO::PARAM_STR);
    
    // execute query
    $passUpdate->execute();

    // send to inferface page
    header('Location: login.php?reset=yes');
    exit;

  }


?> <!-- php login end -->

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/login.css">
  	<title>Rapids Cemetery Admin</title>
  <body id="the-login-page">
    <!-- Login Header Banner -->
    <?php
      include("includes/adminBanner.php");
    ?>
    <div class="login-page">

      <div class="form">
        <?php if($correct) { ?>

          <p style="color:green;">Please enter new password for user: <span style="font-weight: bold;"><?php echo($username); ?></span></p>

          <p id="nomatch" style="color:red;"></p>

          <form class="login-form" action="" onsubmit="return passValidate()" method="POST" >
            Enter new password
            <input id ="newPass1" type="password" name="newPass1" />

            Re-enter new password
            <input id ="newPass2" type="password" name="newPass2" />

            <button>Reset Password</button>

            <a href="login.php" class="myButton">cancel</a>
          </form>

        <?php }
        else { ?>
          <?php
            if($invalid) {
              echo("<span id='bad_login'>Incorrect</span>");
            }
          ?>
          <form class="login-form" action="" method="POST" >
            What is security question 1 answer?
            <input type="text" name="sqa1" />

            What is security question 2 answer?
            <input type="text" name="sqa2" />

            What is security question 3 answer?
            <input type="text" name="sqa3" />

            <button>Reset Password</button>

            <a href="login.php" class="myButton">cancel</a>
          </form>

        <?php } ?>

      </div>
    </div>

<script>
function passValidate() {
    var pass1 = document.getElementById("newPass1").value;
    var pass2 = document.getElementById("newPass2").value;
    var ok = true;
    if (pass1 != pass2) {
        document.getElementById("nomatch").innerHTML = "Passwords do not match";
        ok = false;
    }
    return ok;
}
</script>

</body>
</html>