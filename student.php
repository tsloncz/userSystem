<?php
	session_start(); 
    include 'global.php';
    $mysqli = new mysqli($host, $user, $pass,$db);

    /* check connection */
    if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
    }
    // define variables and set to empty values
    $pass1 = $pass2 = $type = $method = $checked = "";
    $loginId = $_SESSION['loginId'];
    //echo $loginId . ' is user<br>';
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $method = test_input($_POST["method"]);
      $pass1 = test_input($_POST["pass1"]);
      $pass2 = test_input($_POST["pass2"]);
    }

		if ( $method == 'getCourses' )
		{
				$_SESSION['method'] = $method;
				header("Location: studentPage.php?$method");
				$mysqli->close();
		}
		else if ( $method == 'changePassword' )
		{
				$_SESSION['method'] = $method;	
		  	if( $pass1 == $pass2 && $pass1 != "")
		    changePassword( $mysqli, $pass1, $loginId );
		  else
			{
		    $_SESSION['status'] = 0;
				header("Location: studentPage.php?changepassfail");
				$mysqli->close();
				die();
			}
		}
		else if ( $method == 'register' )
		{
				$courses = $_POST['RegisterForCourse'];
				if( count($courses) > 0 )
				{
					foreach($courses as $course)
					{
						$a = new registerSet();
						$a->setClasses( $courses );
						$selectCourseQuery ="SELECT * FROM course
                       						 WHERE courseNo = '$course'";
						$result = $mysqli->query($selectCourseQuery);
  						foreach( $result as $a )
						{	
							$course = $a['courseNo'];
							$sequenceId = $a['sequenceId'];
							$available = $a['availableSeats'];
							if( $available == 0 )
								$checked[] = array('course'=>$course,'fail'=>"FULL");
							else
								$checked[] = array('course'=>$course, 'prereqs'=>registerForCourse($mysqli, $course, $sequenceId,  $loginId));
						}
					}
					$_SESSION['method'] = $method;
					$_SESSION['coursesRegistered'] = $checked;
					header("Location: studentPage.php?");
				}
				else
				{
					$_SESSION['status'] = 0;
					header("Location: studentPage.php?checkedNull");
				}
		}
				

    function changePassword( $mysqli, $pass, $loginId )
    {
      $changePasswordQuery ="UPDATE user
                            SET password= '$pass'
                            WHERE userId = '$loginId'";
      if( $mysqli->query($changePasswordQuery) )
		  		$_SESSION['status'] = 1;
			else
				$_SESSION['status'] = 0;
      //$_SESSION['changePasswordSuccess'] = $mysqli->affected_rows;
      header("Location: studentPage.php?" . $mysqli->affected_rows);
      $mysqli->close();

     die();
    }

    function registerForCourse( $mysqli, $course, $sequenceId, $loginId )
    {
		$prereqs = array();
		$prereqQuery ="SELECT * FROM course
                            WHERE sequenceId < '$sequenceId'";
		$result = $mysqli->query($prereqQuery);
		foreach( $result as $a )
		{
			$prereqs[] = $a['courseNo'];
		}
		return $prereqs;
	}

	function checkPrereqs( $mysqli, $prereqs, $loginId )
    {
		//check students transcript to see if all prereqs are staisfied

	}
    /* close connection */
    $mysqli->close();
?>
