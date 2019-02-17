<!DOCTYPE html>
<html>
<head>
	<title>Rapids Login</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body id="the-login-page">


<?php
	// ONLY if username and password are not empty (aka after pushing login button)
	if ( !empty($_POST['username']) && !empty($_POST['password']) ) {

		// Cred variables
		$user = $_POST['username'];
		$pass = $_POST['password'];

		// Get DB connection
		include '../../database.php';

		// instantiate database and product object
		$database = new Database();
		$db = $database->getConnection();

		// Prepare Query to get hashed pw from DB. based on username entered in login form
		$passQuery = $db->prepare('
			SELECT password FROM adminUsers WHERE username = :user
			');

		// bind username paramter (prevent SQL injection)
		$passQuery->bindParam(':user', $user, PDO::PARAM_STR);

		// execute query
		$passQuery->execute();

		// set the hashed variable
		$hash = $passQuery->fetchColumn();

    	// Use PHP function to verify hashed pasword
		if (password_verify($pass, $hash)) {
		    // print 'Password is valid!';

		    // get user type
		    $typeQuery = $db->prepare('SELECT type FROM adminUsers WHERE username = :user');
		    $typeQuery->bindParam(':user', $user, PDO::PARAM_STR);
		    $typeQuery->execute();
		    $type = $typeQuery->fetchColumn();

	    	// set session vars
	    	//ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
		    session_start();
		    $_SESSION['user'] = $user;
		    $_SESSION['type'] = $type;
        	$_SESSION['time_start_login'] = time();

        	// send to inferface page
			header('Location: poiList.php');
			exit;
		} else {
		    // print 'Invalid password.';

		    // send back to login page
			header('Location: login.php?failed=yes');
			exit;
		}
	}
?> <!-- php login end -->

<!-- Login Header Banner -->
<?php
	include("includes/adminBanner.php");
?>

<!-- login form -->
<div class="login-page">
  <div class="form">
  	<?php
  		if($_GET['failed'] == "yes") {
  			echo("<span id='bad_login'>Bad username or password</span>");
  		}
  		if($_GET['reset'] == "yes") {
  			echo("<span style='color:green;'>Password successfully reset!</span>");
  		}
  	?>
    <form class="login-form" action="login.php" method="POST" >
      <input type="text"     name="username" placeholder="username"/>
      <input type="password" name="password" placeholder="password"/>
      <button>login</button>
      <br/><br/>
      <a href="security.php">Forgot Password?</a>
    </form>
  </div>
</div>



<script type="text/javascript">
	$('.message a').click(function(){
	   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
	});
</script>

</body>
</html>