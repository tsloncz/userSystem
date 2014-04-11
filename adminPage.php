<?php
session_start();
?>
<html>
    <head>
        <title>CSE 480 Project 2</title>
    </head>
    <body>
<?php
if($_SESSION['type'] != "")
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
  $_SESSION['type'] = "";
  echo "<p>" . $out . "</p>";
}
?>
        <h3>Administrator Page</h3>
        <?php
          echo "<p>Logged in as " . $_SESSION['loginId'] . " ";
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

