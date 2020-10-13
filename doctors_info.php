<?php

session_start();

require_once "config.php";
$sql = "SELECT name, specilisation FROM doctors;";
$appointments = array();
if($stmt = mysqli_prepare($link,$sql)){
	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $doctor_name, $specs);
		while(mysqli_stmt_fetch($stmt)){
			array_push($appointments, array($doctor_name, $specs));
		}
	}

}
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Medical Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
			<a class="nav-link" href="past_appointments.php" >Past Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="doctors_info.php" style = "text-decoration: underline;">Doctors</a>
		  </li>
		  <li class = "nav-item"><a href="book-appointment.php" class="nav-link">Book Appointment</a></li>
            <li class = "nav-item"><a class="nav-link"  href = "logout.php">Logout</a></li>
		</ul>
	  </div>
</nav>
<div class="container">
  <h2>Available Doctors</h2>
  <div id = "cards" class = "card-group">

  </div>
	<script>
	 var i;
	 var length = "<?php echo count($appointments);?>";
	 var appoints = <?php echo json_encode($appointments);?>;
		for(i=0;i<length;i++){
			var value = appoints[i];
			document.getElementById('cards').innerHTML += "<div class=\"card\" style=\"max-width: 12rem;\"><img src=\"images/no_image_2.png\" class=\"card-img-top\" alt=\"...\"><div class=\"card-body\"><h5 class=\"card-title\">" + value[0] + "</h5><p class=\"card-text\">" + value[1] + "</p></div></div>";
			//document.getElementById('cards').innerHTML +=  "<div class=\"card text-white bg-secondary mb-3\" style=\"max-width: 20rem; max-height: 20 rem;\"> <div class=\"card-header\">Appointment Number: " + value[0] + "</div><div class=\"card-body\"><h5 class=\"card-title\">Appointed to " + value[1] + "</h5><p class=\"card-text\">Issue: " + value[0] +"</p></div></div>";
      }
    </script>
</div>
      

</body>
</html>