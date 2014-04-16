<?php
	session_start(); 
    include 'global.php';
    $mysqli = new mysqli($host, $user, $pass,$db);

    /* check connection */
    if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
    }
    // define variables and set to empty values
    $pass1 = $pass2 = $type = "";
    $loginId = $_SESSION['loginId'];
		$method = $_POST["method"];
		$_SESSION['method'] = $method;
    //echo $loginId . ' is user<br>';
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $pass1 = test_input($_POST["pass1"]);
      $pass2 = test_input($_POST["pass2"]);
    }

		if ( $method == 'getCourses' )
		{
				header("Location: studentPage.php?");
				$mysqli->close();
		}
		else if ( $method == 'changePassword' )
		{
		  if( $pass1 == $pass2 && $pass1 != "")
		    changePassword( $mysqli, $pass1, $loginId );
		  else
			{
		    $_SESSION['status'] = 0;
				header("Location: studentPage.php?");
				$mysqli->close();
				die();
			}
		}

    function changePassword( $mysqli, $pass, $loginId )
    {
      $changePasswordQuery ="UPDATE user
                            SET password= '$pass'
                            WHERE userId = '$loginId'";
      $changePasswordResult = $mysqli->query($changePasswordQuery);
      $success = $changePasswordResult->num_rows;
			if( $success == 0 )
      	$_SESSION['status'] = 0;
			else
				$_SESSION['status'] = 1;
      //$_SESSION['changePasswordSuccess'] = $mysqli->affected_rows;
      header("Location: studentPage.php?" . $mysqli->affected_rows);
      $mysqli->close();

     die();
    }

    /* close connection */
    $mysqli->close();
?>
