<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
if($_SESSION["loggedinas"] == "Doctor"){
	header("location: doctor_homepage.php");
	exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/welcome.css">
	<link rel="stylesheet" href="css/welcome2.css">
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
			<a class="nav-link" href="welcome.php" style = "text-decoration: underline" >Profile<span class="sr-only">(current)</span></a>
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
		  <li class = "nav-item"><a href="book-appointment.php" class="nav-link">Book Appointment</a></li>
            <li class = "nav-item"><a class="nav-link"  href = "logout.php">Logout</a></li>
		</ul>
	  </div>
	</nav>
	<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["student_id"]); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["email"]); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Date of Birth</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["dob"]); ?></p>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <label>Department</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["department"]); ?></p>
                                            </div>
                                        </div> 
										<div class="row">
                                            <div class="col-md-6">
                                                <label>Batch</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["batch"]); ?></p>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <label>Room No.</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["room"]); ?></p>
                                            </div>
                                        </div> 
										<div class="row">
                                            <div class="col-md-6">
                                                <label>Hostel</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["hostel"]); ?></p>
                                            </div>
                                        </div> 
										<div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo htmlspecialchars($_SESSION["mobile"]); ?></p>
                                            </div>
                                        </div> 
                    </div>
                </div>
            </form>           
        </div>
</body>
</html>