<?php
session_start();
?>
<html>
    <head>
        <title>CSE 480 Project 2</title>
    </head>
    <body>
          <?php
						include 'global.php';
						$mysqli = new mysqli($host, $user, $pass,$db);

						/* check connection */
						if (mysqli_connect_errno()) {
							 printf("Connect failed: %s\n", mysqli_connect_error());
							 exit();
						}
						if( $_SESSION['method'] == 'getCourses' )
						{
								getCourses( $mysqli );
						}
						else if( $_SESSION['method'] == 'changePassword' )
						{
								if( $_SESSION['status'] == 1 )
									echo "Password change successful<br>";
								else
									echo "Failed to change password<br>";
						}
						
            echo "<h3>Student Page</h3>";
            echo "<p>Logged in as<b> " . $_SESSION['loginId'] . "</b> ";
            echo "<a href=\"logout.php\">Logout</a></p>";
            echo "<form method='post' action='student.php'>";
            echo "Enter new password: <input type='text' name='pass1'></input><br>";
            echo "Renter new password: <input type='text' name='pass2'></input><br>";
						echo "<input type='hidden' name='method' value='changePassword' />";
            echo " <input type='submit' value='Change Password'></input>";
            echo "</form>";
            
						echo "<form method='post' action='student.php'>";
						echo "<input type='hidden' name='method' value='getCourses' />";
            echo " <input type='submit' value='Find Available Courses'></input>";
            echo "</form>";
        ?>
    </body>
</html>
