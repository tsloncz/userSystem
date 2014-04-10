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
    $pass1 = $pass2 = "";
    $loginId = $_SESSION['loginId'];
    //echo $loginId . ' is user<br>';
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $pass1 = test_input($_POST["pass1"]);
      $pass2 = test_input($_POST["pass2"]);
    }
    //echo "Thanks for logging in: " . $loginId;
    
    if( $pass1 == $pass2 && $pass1 != "")
      changePassword( $mysqli, $pass1, $loginId );
    else
      echo "Passwords do not match";

    function changePassword( $mysqli, $pass, $loginId )
    {
      $changePasswordQuery ="UPDATE user
                            SET password= '$pass'
                            WHERE userId = '$loginId'";
      $changePasswordResult = $mysqli->query($changePasswordQuery);
      $_SESSION['changePassword'] = $mysqli->affected_rows;
      header("Location: studentPage.php?" . $mysqli->affected_rowa);
      $mysqli->close();

     die();
    }
    /* close connection */
    $mysqli->close();
?>
