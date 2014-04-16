<?php
session_start();
?>
<html>
    <head>
        <title>CSE 480 Project 2</title>
    </head>
    <body>
<?php
if(isset($_SESSION["view_loginId"]))
{
  include "global.php";
  $mysqli = new mysqli($host, $user, $pass,$db);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  $view_query = "select userId, password, isAdmin from user where ";
  $view_query .= "userId = '" . $_SESSION["view_loginId"] . "'";
  $view_query_result = $mysqli->query($view_query);
	$found = $view_query_result->num_rows;
  if($found != 0)
  {
    $row =  $view_query_result->fetch_assoc();
    echo "<p>Information for user<b> " . $row["userId"] . "</b></p>";
    echo "<p>Password: " . $row["password"] . "<br/>";
    echo "Is admin: ";
    if($row["isAdmin"])
    {
      echo "true";
    }
    else
    {
      echo "false";
    }
    echo "</p>";
  }
  else
  {
    echo "<p>User not found</p>";
  }
  unset($_SESSION["view_loginId"]);
}
else if(isset($_SESSION['type']))
{
  switch($_SESSION['type'])
  {
    case "resetPass":
      $out = "Password reset ";
      break;
    case "deleteUser":
      $out = "User deletion ";
      break;
    case "addUser":
      $out = "User creation ";
      break;
    case "updateUser":
      $out = "User update ";
      break;
  }
  $out .= $_SESSION['status'] ? "successful!" : "unsuccessful!";
  unset($_SESSION['type']);
  echo "<p>" . $out . "</p>";
}
?>
        <h3>Administrator Page</h3>
        <?php
          echo "<p>Logged in as<b> " . $_SESSION['loginId'] . "</b> ";
          echo "<a href=\"logout.php\">Logout</a></p>";
        ?>

        Password and Administrator only required for update and add.<br>
        <form method='post' action='admin.php'>
          User id: <input type='text' name='loginId'></input><br>
          Password: <input type='text' name='password'></input><br>
          Administrator: <select name='isAdmin'>
                          <option value='yes'>Yes</option>
                          <option value='no'>No</option>
                        </select>
          <br>
          <select name='method'>
            <option value='viewInfo'>View user's information</option>
            <option value='resetPass'>Reset password</option>
            <option value='deleteUser'>Delete User</option>
            <option value='addUser'>Add User</option>
            <option value='updateUser'>Update User Information</option> 
          </select> 
          <input type='submit'></input>
        </form>
      </body>
</html>

