<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
          <?php
            switch($_SESSION['changePasswordSuccess'])
            {
              case 0:
                  echo "Failed to change password.<br>";
                  break;
              case 1:
                  echo "Password changed successfully<br>";
                  break;
            }           
            echo "Session " . $_SESSION['loginId'] . "<br>";
            echo "<h3>Student Page</h3>";
            echo "<form method='post' action='student.php'>";
              echo "Enter new password: <input type='text' name='pass1'></input><br>";
              echo "Renter new password: <input type='text' name='pass2'></input><br>";
              echo " <input type='submit'></input>";
            echo "</form>";
        ?>
    </body>
</html>
