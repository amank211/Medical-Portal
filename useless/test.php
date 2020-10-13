<?php
session_start();
require_once "config.php";
include 'mail.php';
$date = "";
$time = "";
$problem = "";
$doctor_id = 20033;
$doctor_name = '';
$date_err = $time_err = $problem_err = "";
$dept_id = 1;
$datetime = "";
$student_id = 0;
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


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(empty($_POST["date"])){
		$date_err = "please enter date";
	} else{
		$datetime = $_POST["date"];
	}

	if(empty($_POST["time"])){
		$time_err = "please enter time";
	} else{
			//list($hrs, $min) = explode(':', $_POST["time"]);
			//if(!checktime($hrs, $min)){
				// $time_err = "please write time in correct format";
			//} else{
				$datetime = $datetime." ".$_POST["time"];
			//}
	}
	if(empty($_POST["problem"])){
		$problem_err = "please mention your issue";

	} else{
		$problem = $_POST["problem"];
	}
	if(empty($_POST["doctor"])){
		$doctor_err = "please mention doctor";

	} else{
		$doctor = $_POST["doctor"];
	}

	//check input errors
	if(empty($date_err) && empty($time_err) && empty($problem_err) ){
      
         echo($datetime);
         
        
    }
}


?>

<!DOCTYPE html>
<html>
<head>
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
			<a class="nav-link" href="#"><?php echo htmlspecialchars($_SESSION["username"]); ?><span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="user-appointments.php">Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="past_appointments.php" >Past Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="doctors_info.php">Doctors</a>
		  </li>
		  <li class = "nav-item"><a href="book-appointment.php" class="nav-link" style = "text-decoration: underline" >Book Appointment</a></li>
            <li class = "nav-item"><a class="nav-link"  href = "logout.php">Logout</a></li>
		</ul>
	  </div>
	</nav>
<div id = "cards" >

</div>
<div class = "app_book">
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
		<input type = "date" name = "date" placeholder="dd-mm-yyyy">
		<select name = "time" class = "dropdown">
		<option style="display: none" not selected>HH:MM</option>
		<option value = "10:00">10:00</option>
		<option value = "10:30">10:30</option>
		<option value = "11:00">11:00</option>
		<option value = "11:30">11:30</option>
		<option value = "12:00">12:00</option>
		<option value = "01:00">01:00</option>
		<option value = "01:30">01:30</option>
		</select>
		<select name = "" class = "dropdown" id = "doctor">
		<option style="display: none" not selected>Doctor</option>
		</select>
		<input type = "textarea" name ="problem" placeholder="Mention your issue here...">
		 <button type="submit">Book</button>
	</form>
</div>
<script>
	 var i;
	 var length = "<?php echo count($appointments);?>";
	 var appoints = <?php echo json_encode($appointments);?>;
		for(i=0;i<4;i++){
			var value = appoints[i];
			document.getElementById('doctor').innerHTML += "<option value = \""+ value[0] +"\">" +value[0] + "</option>";
			document.getElementById('cards').innerHTML += "<div class=\"card mb-3\" style=\"width: 27%;\"><div class=\"row no-gutters\"><div class=\"col-md-4\"><img src=\"images/no_image.png\" class=\"card-img\" alt=\"...\"></div><div class=\"col-md-8\"><div class=\"card-body\"><h5 class=\"card-title\">"+ value[0] +"</h5><p class=\"card-text\">"+ value[1] +"</p></div></div></div></div>";
			      }
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>