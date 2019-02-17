<?php
	session_start();

	if(isset($_SESSION['user'])){
		//The lives of session is one hour 60*60=3600 
		if((time() - $_SESSION['time_start_login']) > 3600){
		    // if expired, logout
		    //echo "1 - USERNAME: ", $_SESSION['user'], "<br/>";
		    header("location: logout.php");
		} 
		else {
			// refresh time if less than hour has gone by
		    $_SESSION['time_start_login'] = time();
		    //echo "Valid Session - <br/>";
		    //echo "USERNAME: ", $_SESSION['user'], "<br/>";
		    //echo "TYPE: ",     $_SESSION['type'];
		}
	} 
	else {
		header("location: logout.php");
		//echo "3 - USERNAME: ", $_SESSION['user'], "<br/>";
	}
?>