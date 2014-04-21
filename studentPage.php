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
						
            echo "<h3>Student Page</h3>";
            echo "<p>Logged in as<b> " . $_SESSION['loginId'] . "</b> ";
            echo "<a href=\"logout.php\">Logout</a></p>";
            echo "<form method='post' action='student.php'><table><tr>";
            echo "<td>Enter new password:</td><td><input type='text' name='pass1'></input></td></tr>";
            echo "<tr><td>Renter new password:</td><td> <input type='text' name='pass2'></input></td></tr></table>";
						echo "<input type='hidden' name='method' value='changePassword' />";
            echo " <input type='submit' value='Change Password'></input><br>";
            echo "</form><br>";
            
						echo "<form method='post' action='student.php'>";
						echo "<input type='hidden' name='method' value='getCourses' />";
            echo " <input type='submit' value='Find Available Courses'></input>";
            echo "</form><br>";

						if( $_SESSION['method'] == 'getCourses' )
						{
								getCourses( $mysqli );
								$_SESSION['method'] = '';
						}
						else if( $_SESSION['method'] == 'changePassword' )
						{
								if( $_SESSION['status'] == 0 )
									echo "Failed to change password<br>";
								else
									echo "Password change successful<br>";
								$_SESSION['method'] = '';
						}
						else if( $_SESSION['method'] == 'register' )
						{
								if( $_SESSION['status'] == 0 )
										echo "You didn't select any courses!";
								else
								{
									$courseRegStatus = $_SESSION['coursesRegistered'];
									//var_dump($courseRegStatus);
									if( count($courseRegStatus > 0) )
									{
										foreach($courseRegStatus as $course)
										{
											echo "<br>" . $course['course'] . " has prereqs you haven't taken ";
											$prereqs = $course['prereqs'];
											foreach($prereqs as $course)
											{
												echo " " . $course . ", ";;
											}
										}
										$_SESSION['coursesRegistered'] = [];
									}
								}
							
								$_SESSION['method'] = '';
						}
        ?>
    </body>
</html>
