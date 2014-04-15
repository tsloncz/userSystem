<?php
    session_start();
    include 'global.php';
    $mysqli = new mysqli($host, $user, $pass, $db);

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

    $_SESSION['type'] = $method;

    switch( $method )
    {
    case "viewInfo":
        $_SESSION["view_loginId"] = $loginId;
        unset($_SESSION['type']);
        header("Location: adminPage.php");
        die();
        break;
      case "resetPass":
        resetPassword( $mysqli, $loginId );
        break;
      case "deleteUser";
        deleteUser( $mysqli, $loginId );
        break;
      case "addUser":
        addUser( $mysqli, $loginId, $password );
        break;
      case "updateUser":
        updateUser( $mysqli, $loginId, $password, $isAdmin );
        break;
    }

    function resetPassword( $mysqli, $loginId )
    {
      $resetPasswordQuery = "UPDATE user
                             SET password = 'default'
                             WHERE userId = '$loginId'";
      $resetPasswordResult = $mysqli->query($resetPasswordQuery);
      $_SESSION['status'] = 1;
    }

    function deleteUser( $mysqli, $loginId )
    {
      $deleteUserQuery = "DELETE from user
                          WHERE userId = '$loginId'";
      $deleteUserResult = $mysqli->query($deleteUserQuery);
      $_SESSION['status'] = 1;
    }

    function addUser( $mysqli, $loginId, $password )
    {
      $addUserQuery = "INSERT INTO user VALUES ('$loginId', '$password', '$isAdmin')";
      $addUserResult = $mysqli->query($addUserQuery);
      $_SESSION['status'] = 1;
    }

    function updateUser( $mysqli, $loginId, $password, $isAdmin )
    {
			if( $password == '')
			{	
		    $updateUserQuery = "UPDATE user
														SET isAdmin='$isAdmin'
														where userId='$loginId'";
			}	
			else
			{
		    $updateUserQuery = "UPDATE user
														SET password='$password',isAdmin='$idAdmin'
														where userId='$loginId'";
			}
      $updateUserResult = $mysqli->query($updateUserQuery);
			$success = $updateUserResult->num_rows;
			if( $success == 0 )
      	$_SESSION['status'] = 0;
			else
				$_SESSION['status'] = 1;
    }

    $mysqli->close();
    header("Location: adminPage.php");
    die();
?>
