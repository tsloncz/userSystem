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
    $loginId = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $loginId = test_input($_POST["loginId"]);
      $password = test_input($_POST["password"]);
    }
    //echo "Thanks for logging in: " . $loginId;

    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
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
          $_SESSION['isAdmin'] == 'yes';
          include 'adminPage.html';
        }
        else
        {
          $_SESSION['isAdmin'] == 'no';
          include 'studentPage.php';
        }
      }
       $rows[] = $row;
    }
    if($found == 0)
     echo "Incorrect login id/password";

    /* close connection */
    $mysqli->close();
?>
