<?php
  session_start();
  include 'global.php';
  $mysqli = new mysqli($host, $user, $pass, $db);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $loginId = $password = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $loginId = test_input($_POST["loginId"]);
    $password = test_input($_POST["password"]);
  }

  $view_query = "select userId, password, isAdmin from user where ";
  $view_query .= "userId = '" . $loginId . "' and password='";
  $view_query .= $password . "'";
  $view_query_result = $mysqli->query($view_query);
  $found = $view_query_result->num_rows;
  if( $found != 0)
  {
    $row = $view_query_result->fetch_assoc();
    $_SESSION['loginId'] = $row["userId"];
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
  else
  {
    echo "<p>Incorrect user or password</p>";
		echo "<a href='index.php'>Try again</a>";
  }
?>
