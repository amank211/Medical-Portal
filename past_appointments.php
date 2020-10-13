<?php

session_start();

require_once "config.php";
$sql = "SELECT reff_no, patient_name, Problem, doctors.name, appoint_time, Booked_at FROM appointments inner join doctors on appointments.Doctor_id = doctors.doctor_id WHERE appoint_time < current_timestamp AND student_id = ? order by appoint_time";
$appointments = array();
if($stmt = mysqli_prepare($link,$sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_student_id);

	$param_student_id = $_SESSION["student_id"];

	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $reff_no, $patient_name, $problem, $BOOKED_AT, $Doctor_id, $appoint_time);
		while(mysqli_stmt_fetch($stmt)){
			array_push($appointments, array($reff_no, $patient_name, $problem, $Doctor_id, $appoint_time, $BOOKED_AT));
		}
	}

}
mysqli_stmt_close($stmt);
mysqli_close($link);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Past_appointments</title>
  <meta charset="utf-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/welcome.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
	 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="welcome.php">Medical Portal</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
		  <li class="nav-item active">
			<a class="nav-link" href="welcome.php">Profile<span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="user-appointments.php">Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="past_appointments.php" style = "text-decoration: underline" >Past Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="doctors_info.php">Doctors</a>
		  </li>
		  <li class = "nav-item"><a href="book-appointment.php" class="nav-link">Book Appointment</a></li>
            <li class = "nav-item"><a class="nav-link"  href = "logout.php">Logout</a></li>
		</ul>
	  </div>
	</nav>
<div class="container">
  <h2>Medical History</h2>
  <div id = "cards" class = "card-columns">

  </div>
	<script>
	 var i;
	 var length = "<?php echo count($appointments);?>";
	 var appoints = <?php echo json_encode($appointments);?>;
	 
	 

		for(i=0;i<length;i++){
			var value = appoints[i];
			document.getElementById('cards').innerHTML += "<div class=\"card\" style=\"max-width: 20rem; max-height: 20 rem;  background-color : #d6e5fa;\"> <div class=\"card-header\">Appointment Number: " + value[0] + "</div><div class=\"card-body\"><h5 class=\"card-title\">Appointed to " + value[5] + "</h5><p class=\"card-text\">Issue: " + value[2] + "<br>Scheduled at:" + value[3].slice(10,16) + " " + value[3].slice(0,11) +"</p></div></div>";
			//document.getElementById('rows').innerHTML += "<tr><td>" + value[0] + "</td> <td>" + value[1] + "</td><td>" + value[2] + "</td><td>" + value[5] + "</td><td>" + value[3] +"</td> <td>" + value[4] + "</td></tr>\n";
      }
    </script>
</div>
</body>
</html>




















