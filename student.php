<?php
	session_start(); 
    include 'vars.php';
    $mysqli = new mysqli($host, $user, $pass,$db);

    /* check connection */
    if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
    }
    // define variables and set to empty values
    $pass1 = $pass2 = "";
    $loginId = $_SESSION['loginId'];
    echo $loginId . ' is user<br>';
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $pass1 = test_input($_POST["pass1"]);
      $pass2 = test_input($_POST["pass2"]);
    }
    //echo "Thanks for logging in: " . $loginId;
    
    if( $pass1 == $pass2 )
      changePassword( $mysqli, $pass1, $loginId );
    else
      echo "Passwords do not match";

    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    function changePassword( $mysqli, $pass, $loginId )
    {
      $changePasswordQuery ="UPDATE user
                   SET password= '$pass'
                   WHERE userId = '$loginId'";
      $changePasswordResult = $mysqli->query($changePasswordQuery);
      $found = 0;
      echo "Updated " . $loginId . "'s password to " . $pass;
      /*while($row = $dispResult->fetch_array())
      {
        if( $row['userId'] == $loginId && $row['password']==$password)
        {
          $found = 1;
          if( $row['isAdmin'] == 1 )
          {
            include 'adminPage.html';
          }
          else
          {
            include 'studentPage.php';
          }
        }
        $rows[] = $row;
      }*/
    }
    /* close connection */
    $mysqli->close();
?>
