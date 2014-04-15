<?php
session_start();
?>
<html>
    <head>
        <title>CSE 480 Project 2</title>
    </head>
    <body>
          <?php
            echo "<h3>Student Page</h3>";
            echo "<p>Logged in as " . $_SESSION['loginId'] . " ";
            echo "<a href=\"logout.php\">Logout</a></p>";
            echo "<form method='post' action='student.php'>";
            echo "Enter new password: <input type='text' name='pass1'></input><br>";
            echo "Renter new password: <input type='text' name='pass2'></input><br>";
						echo "<input type='hidden' name='changePass' value='1' />";
            echo " <input type='submit' value='Change Password'></input>";
            echo "</form>";
            echo "<form method='post' action='student.php'>";
						echo "<input type='hidden' name='getClasses' value='1' />";
            echo " <input type='submit' value='Find Available Courses'></input>";
            echo "</form>";
        ?>
    </body>
</html>
