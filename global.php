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
			echo "<table style='text-align:center'
													border=1'>
											<tr><th>Number</th>
											<th>Name</th>
											<th>sequenceId</th>
											<th>Max Seats</th>
											<th>Available Seats</th></tr>";
			foreach( $getCoursesResult as $course )
			{
				echo "<tr><td>" . $course['courseNo'] . "</td>";
				echo	"<td>" . $course['courseName'] . "</td>";
				echo	"<td>" . $course['sequenceId'] . "</td>";
				echo	"<td>" . $course['maxSeats'] . "</td>";
				echo	"<td>" . $course['availableSeats'] . "</td></tr>";
			}
			echo "</table><br>";
		}
}
?>
