<?php
session_start();
?>
<html>
    <head>
        <title>CSE 480 Project 2</title>
    </head>
    <body>
          <?php
<<<<<<< HEAD
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
=======
>>>>>>> c643c0ca0559b042c83a6e81fbb46dbd5e2bb43b
            echo "<h3>Student Page</h3>";
            echo "<p>Logged in as " . $_SESSION['loginId'] . " ";
            echo "<a href=\"logout.php\">Logout</a></p>";
            echo "<form method='post' action='student.php'>";
            echo "Enter new password: <input type='text' name='pass1'></input><br>";
            echo "Renter new password: <input type='text' name='pass2'></input><br>";
            echo " <input type='submit'></input>";
            echo "</form>";
        ?>
    </body>
</html>
