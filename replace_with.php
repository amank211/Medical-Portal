<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "GET")$_SESSION["del_id"] = $_GET["id"];


require_once "config.php";
include 'mail.php';
$date = "";
$time = "";
$problem = "";
$doctor_id = 0;
$doctor_name = '';
$date_err = $time_err = $problem_err = "";
$doctor_err = "";
$dept_id = 1;
$datetime = "";
$student_id = 0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
		$query = "select A.* , B.prim_email from appointments as A INNER join btech_students as B on A.student_id = B.student_id where reff_no = ?";
		if($stmt = mysqli_prepare($link,$query)){
					mysqli_stmt_bind_param($stmt, 'i', $param_app_id);
					$param_app_id = $_SESSION["del_id"];
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_store_result($stmt);
						mysqli_stmt_bind_result($stmt, $reff_no, $st_id, $Department, $name1, $pblm, $dr_id, $appointt_time, $Booked_AT, $pt_email);
						while(mysqli_stmt_fetch($stmt)){
							echo "hello";
							$student_id= $st_id;
							$dept_id = $Department;
							$patient_name = $name1;
							$problem = $pblm;
							$doctor_id = $dr_id;
							$patient_email = $pt_email;

						}
					}
		}
		$query = "DELETE from appointments where reff_no = ?;";
		if($stmt = mysqli_prepare($link,$query)){
					mysqli_stmt_bind_param($stmt, 'i', $param_app_id);
					$param_app_id = $_SESSION["del_id"];
					mysqli_stmt_execute($stmt);
		}


		if(empty($_POST["date"])){
			$date_err = "please enter date";
		} else{
			$datetime = $_POST["date"];
		}

		if($_POST["time"] == "HH:MM"){
			$time_err = "please enter time";
		} else{
				//list($hrs, $min) = explode(':', $_POST["time"]);
				//if(!checktime($hrs, $min)){
					// $time_err = "please write time in correct format";
				//} else{
					$datetime = $datetime." ".$_POST["time"];
				//}
		}

		if(empty($date_err) && empty($time_err)){
        // Prepare an insert statement
		$sql = "INSERT INTO appointments (student_id, Department, patient_name, Problem, Doctor_id, Appoint_time, Booked_AT) VALUES (?, ?, ?, ?, ?, ?, ?)";

		if($stmt = mysqli_prepare($link ,$sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iississ", $param_student_id, $param_Department, $param_patient_name, $param_problem, $param_doctor, $param_time, $param_curr_time);
            // Set parameters
			$param_student_id =$student_id;
			$param_Department = $dept_id;
            $param_patient_name = $patient_name;
            $param_problem = $problem;
			$param_doctor = $doctor_id;
			$param_time = $datetime;
			date_default_timezone_set('Asia/Kolkata');
			$param_curr_time = date( 'Y-m-d h:i:s A', time () );
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				//mail the confirmation of booking
				reschedule_email($patient_email, 435453, $datetime, $_SESSION["username"]);
                // Redirect to login page
                header("location: doctor_homepage.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

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
	  <a class="navbar-brand" href="doctor_homepage.php">Medical Portal</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
		  <li class="nav-item active">
			<a class="nav-link" href="#"><?php echo htmlspecialchars($_SESSION["username"]); ?><span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="one-day_appointment.php">Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="#" >Past Appointments</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="doctorss_info.php">Doctors</a>
		  </li>
		  <li class = "nav-item"><a href="reschedule.php" class="nav-link">Reschedule Appointments</a></li>
            <li class = "nav-item"><a class="nav-link"  href = "logout.php">Logout</a></li>
		</ul>
	  </div>
</nav>
<div id = "cards" >

</div>
<div class = "app_book">
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
		<input type = "date" name = "date" id = "pickdate" placeholder="dd-mm-yyyy">
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
		 <button type="submit">Reschedule</button>
	</form>
</div>
<script>
	 var i;
	 var length = "<?php echo count($appointments);?>";
	 var appoints = <?php echo json_encode($appointments);?>;
		for(i=0;i<4;i++){
			var val = appoints[i];
			document.getElementById('doctors').innerHTML += "<option value = \""+ val[2] +"\">" + val[0] + "</option>";
			document.getElementById('cards').innerHTML += "<div class=\"card mb-3\" style=\"width: 27%;\"><div class=\"row no-gutters\"><div class=\"col-md-4\"><img src=\"images/no_image_2.png\" class=\"card-img\" alt=\"...\"></div><div class=\"col-md-8\"><div class=\"card-body\"><h5 class=\"card-title\">"+ val[0] +"</h5><p class=\"card-text\">"+ val[1] +"</p></div></div></div></div>";
		}
		var today = new Date();
		var end = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; 
		var yyyy = today.getFullYear();
		if(dd<10){
				dd='0'+dd
			} 
		if(mm<10){
			mm='0'+mm
		} 

		today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("pickdate").setAttribute("min", today);
		dd = end.getDate();
		mm = end.getMonth() + 1;                //set end limit to 1 month
		yyyy = end.getFullYear();
		 if(dd<10){
				dd='0'+dd;
			} 
		if(mm<10){
			mm='0'+mm;
		}
		if(mm>11){mm = 01; yyyy += 1;}
		 end = yyyy+'-'+mm+'-'+dd;
		 document.getElementById("pickdate").setAttribute("max", end);
</script>
</body>
</html>