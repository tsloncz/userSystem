<?php
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

    $dispQuery ="Select userId, password from user";
    $dispResult = $mysqli->query($dispQuery);
    $found = 0;
    while($row = $dispResult->fetch_array())
    {
       $rows[] = $row;
    }
    foreach($rows as $row )
    {
       if( $row['userId'] == $loginId && $row['password']==$password)
       {
         $found = 1;
         echo "Found password " . $password . " for user " . $userId ."<br>";
       }
    }
    if($found == 0)
     echo "nope";

    /* close connection */
    $mysqli->close();
?>

