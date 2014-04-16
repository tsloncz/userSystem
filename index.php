<?php
session_start();
if(array_key_exists("loginId", $_SESSION) &&
   array_key_exists("isAdmin", $_SESSION))
{
  if($_SESSION["isAdmin"] == "yes")
  {
    header("Location: adminPage.php");
    die();
  }
  else if($_SESSION["isAdmin"] == "no")
  {
    header("Location: studentPage.php");
    die();
  }
}
?>
<html>
<head>
    <title>CSE 480 Project 2</title>
</head>
<body>
    <h3>Login Page</h3>
    <form name="loginInfo" action="login.php" method="post">
            <table>
                <tr>
                    <td>
                        login id
                    </td>
                    <td>
                        <input type='text' name="loginId">
                    </td>
                </tr>
                <tr>
                    <td>
                        password: 
                    </td>
                    <td>
                        <input type='text' name="password">
                    </td>
                </tr>
            </table>
            <input type='submit' value="Submit">
        </form>
    </body>
</html>
