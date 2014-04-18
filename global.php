<?php
include "vars.php";
function test_input($data)                                                  
{                                                                            
  $data = trim($data);                                                       
  $data = stripslashes($data);                                               
  $data = htmlspecialchars($data);                                           
  return $data;                                                              
}

function getCourses( $mysqli )
{
		$getCoursesQuery = "SELECT * FROM course";
		$getCoursesResult = $mysqli->query($getCoursesQuery);
		$success = $getCoursesResult->num_rows;
		if( $success == 0 )
			$_SESSION['status'] = 0;
		else
		{
			$_SESSION['status'] = 1;
			echo "<form method='post' action='student.php'>
											<table style='text-align:center' border=1'>
											<tr><th>Register</th>
											<th>Number</th>
											<th>Name</th>
											<th>sequenceId</th>
											<th>Max Seats</th>
											<th>Available Seats</th></tr>";
			$i=0;
			foreach( $getCoursesResult as $course )
			{
				$name = $course['courseNo'];
				if( $course['availableSeats'] == 0 )
						echo "<tr><td>FULL</td>";
				else
					echo "<tr><td><input type='checkbox' name='RegisterForCourse[$i]' value='$name'>" . "</td>";
				echo  "<td>" . $course['courseNo'] . "</td>";
				echo	"<td>" . $course['courseName'] . "</td>";
				echo	"<td>" . $course['sequenceId'] . "</td>";
				echo	"<td>" . $course['maxSeats'] . "</td>";
				echo	"<td>" . $course['availableSeats'] . "</td></tr>";
				$i++;
			}
			echo "</table>";
			echo "<input type='hidden' name='method' value='register' />";
      echo " <input type='submit' value='Register For Courses'></input></form>";
		}
}
?>
