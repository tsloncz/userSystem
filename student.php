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
    $pass1 = $pass2 = $type = $method = "";
    $loginId = $_SESSION['loginId'];
    //echo $loginId . ' is user<br>';
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $method = test_input($_POST["method"]);
      $pass1 = test_input($_POST["pass1"]);
      $pass2 = test_input($_POST["pass2"]);
    }

		if ( $method == 'getCourses' )
		{
				$_SESSION['method'] = $method;
				header("Location: studentPage.php?");
				$mysqli->close();
		}
		else if ( $method == 'changePassword' )
		{
			$_SESSION['method'] = $method;	
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
      if( $mysqli->query($changePasswordQuery) )
		  		$_SESSION['status'] = 1;
			else
					$_SESSION['status'] = 0;
      //$_SESSION['changePasswordSuccess'] = $mysqli->affected_rows;
      header("Location: studentPage.php?" . $mysqli->affected_rows);
      $mysqli->close();

     die();
    }

    /* close connection */
    $mysqli->close();
?>
