<?php
  class registerSet
  {
    public $userId;
    public $course;
    public $sequencyId;
    // If prereqs are complete then value = 0
    public $prereqsSatisfied = 1;
    public $available;
    public $enrolled = 0;
    // Need array form for assignment to $_SESSION variable
    function getStatus()
    {
      return array('course'=>$this->course,
                    'prereqsSatisfied'=>$this->prereqsSatisfied,
                    'enrolled' => $this->enrolled);
    }
  }
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
          $_SESSION['method'] = $method;
		  $courses = $_POST['RegisterForCourse'];
          //If count(courses) = 0 then no classes were selected
				if( count($courses) > 0 )
				{
					foreach($courses as $course)
					{
                        $a = new registerSet();
                        $a->course = $course ;
                        $a->userId = $loginId;
						$selectCourseQuery ="SELECT * FROM course
                       						 WHERE courseNo = '$course'";
						$result = $mysqli->query($selectCourseQuery);
  						foreach( $result as $row )
						{
                            //Make sure cass is available
							$a->available = $row['availableSeats'];
                            $a->sequenceId = $row['sequenceId'];
                            //Check if student satisfied prereqs
                            $a->prereqsSatisfied = checkPrereqs($mysqli, $a);
                            // Only register if prereqs complete
                            if($a->prereqsSatisfied == 0)
                              $a->enrolled = enrollForCourse($mysqli, $a);
                            // Add array of courses student wanted to register
                            // for and the status of registration
                            // Need as array to assign to SESSION variable
                            $checked[] = $a->getStatus();
						}
					}
                    //unlock row
                    $mysqli->query("commit");
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
      header("Location: studentPage.php?" . $mysqli->affected_rows);
      $mysqli->close();

     die();
    }
    function registerForCourse( $mysqli, $course, $sequenceId, $loginId )
    {
		// Find prereqs student hasn't taken
		$prereqQuery ="SELECT C.courseNo as course FROM course C
                            	WHERE C.sequenceId < '$sequenceId'
								AND C.courseNo NOT IN(
								SELECT T.courseNo from transcript T
					   			WHERE T.userId='$loginId')";
		$result = $mysqli->query($prereqQuery);
		$prereqs = $mysqli->affected_rows;
		return $prereqs;
	}

  function enrollForCourse($mysqli, $a)
  {
    $enrollQuery = "UPDATE course
                    SET availableSeats = (availableSeats - 1)
                    WHERE courseNo = '$a->course' AND availableSeats > 0";
    $result = $mysqli->query($enrollQuery);
    return $mysqli->affected_rows;
  }

	function checkPrereqs( $mysqli, $a )
    {
      // Find prereqs student hasn't taken
      $prereqQuery ="SELECT C.courseNo as course FROM course C
                     WHERE C.sequenceId < '$a->sequenceId'
                     AND C.courseNo NOT IN(
                     SELECT T.courseNo from transcript T
                     WHERE T.userId='$a->userId')";
	  $result = $mysqli->query($prereqQuery);
      return $mysqli->affected_rows;

	}
    /* close connection */
    $mysqli->close();
?>
