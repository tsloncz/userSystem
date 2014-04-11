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
    $loginId = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $loginId = test_input($_POST["loginId"]);
      $password = test_input($_POST["password"]);
    }

    $dispQuery ="Select userId, password, isAdmin from user";
    $dispResult = $mysqli->query($dispQuery);
    $found = 0;
    while($row = $dispResult->fetch_array())
    {
      if( $row['userId'] == $loginId && $row['password']==$password)
      {
        $_SESSION['loginId'] = $loginId;
        $found = 1;
        if( $row['isAdmin'] == 1 )
        {
          $_SESSION['isAdmin'] = 'yes';
          header("Location: adminPage.php");
          exit();
        }
        else
        {
          $_SESSION['isAdmin'] = 'no';
          header("Location: studentPage.php");
          exit();
        }
      }
       $rows[] = $row;
    }
    if($found == 0)
     echo "Incorrect login id/password";

    /* close connection */
    $mysqli->close();
?>
