<?php
    include 'vars.php';
    $mysqli = new mysqli($host, $user, $pass,$db);

    /* check connection */
    if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
    }
    // define variables and set to empty values
    $loginId = $method = $password = "";
    $isAdmin = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $loginId = test_input($_POST["loginId"]);
      $method = test_input($_POST["method"]);
      $password = test_input($_POST["password"]);
      $isAdmin = test_input($_POST["isAdmin"]);
    }

    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    switch( $method )
    {
      case "viewInfo":
        viewUserInfo( $mysqli, $loginId );
        break;
      case "resetPass":
        resetPassword( $mysqli, $loginId );
        break;
      case "deleteUser";
        deleteUser( $mysqli, $loginId );
        break;
      case "addUser":
        echo "add";
        break;
      case "updateUser":
        updateUser( $mysqli, $loginId, $password, $isAdmin );
        break;
    }

    function viewUserInfo( $mysqli, $loginId )
    {
      $viewUserQuery ="Select userId, password, isAdmin from user
                       WHERE userId='$loginId'";
      $viewUserResult = $mysqli->query($viewUserQuery);
      $found = 0;
      while($row = $viewUserResult->fetch_array())
      {
          $found = 1;
          echo "Information for <b>" . $loginId . "</b><br>";
          echo "Password: " . $row['password'] . "<br>";
          echo "Is Admin: " . $row['isAdmin'] . "<br>";
          include 'adminPage.html';
      }
      if($found == 0 )
        echo "User not found";
    }

    function resetPassword( $mysqli, $loginId )
    {
      $resetPasswordQuery = "UPDATE user
                             SET password = 'default'
                             WHERE userId = '$loginId'";
      $resetPasswordResult = $mysqli->query($resetPasswordQuery);
      echo "Password reset for <b>" . $loginId . "</b></br>";
      include 'adminPage.html';
    }

    function deleteUser( $mysqli, $loginId )
    {
      $deleteUserQuery = "DELETE from user
                          WHERE userId = '$loginId'";
      $deleteUserResult = $mysqli->query($deleteUserQuery);
      echo "User " . $loginId . " deleted.";
      include 'adminPage.html';
    }
    function addUser( $mysqli, $loginId )
    {
    }
    function updateUser( $mysqli, $loginId )
    {
    }
    /* close connection */
    $mysqli->close();
?>
