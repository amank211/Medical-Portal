<?php

session_start();
require_once "config.php";
include 'mail.php';

// get the q parameter from URL
$q = $_REQUEST["q"];
$data = json_decode($q);
$success = false;


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
$sql = "SELECT name, specilisation, doctor_id FROM doctors;";
$appointments = array();
$available = true;
$count_time = 0;
	


	
		
$sql = "INSERT INTO appointments (student_id, Department, patient_name, Problem, Doctor_id, Appoint_time, Booked_AT) VALUES (?, ?, ?, ?, ?, ?, ?)";
$sql2 = "SELECT name from doctors where doctor_id = ?";

if($stmt2 = mysqli_prepare($link,$sql2)){
	mysqli_stmt_bind_param($stmt2, 'i', $param_id);
	$param_id = $data->doc;
	if(mysqli_stmt_execute($stmt2)){
		mysqli_stmt_store_result($stmt2);
		mysqli_stmt_bind_result($stmt2, $name);
		while(mysqli_stmt_fetch($stmt2)){
			$doctor_name = $name;
		}
	}

}
mysqli_stmt_close($stmt2);
        
$datetime = substr($data->date,0,10);
$datetime = $datetime." ".$data->time;

/*if($stmt = mysqli_prepare($link ,$sql)){
    // Bind variables to the prepared statement as parameters
	
    mysqli_stmt_bind_param($stmt, "iississ", $param_student_id, $param_Department, $param_patient_name, $param_problem, $param_doctor, $param_time, $param_curr_time);
    // Set parameters
	$param_student_id = $data->user_id;
	$param_Department = $dept_id;
    $param_patient_name = $data->username;
    $param_problem = $data->problem;
	$param_doctor = $data->doc;
	$param_time = $datetime;
	date_default_timezone_set('Asia/Kolkata');
	$param_curr_time = date( 'Y-m-d h:i:s A', time () );
            
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
		//mail the confirmation of booking
				
		sendemail($_SESSION["email"], 435453, $datetime, $doctor_name);
		$success = true;
        // Redirect to login page
        //header("location: welcome.php");
    } else{
        echo "Something went wrong. Please try again later.";
    }
}*/
         
// Close statement
mysqli_stmt_close($stmt);
    
// Close connection
mysqli_close($link);




// Output "no suggestion" if no hint was found or output correct values
echo $data->date;
?>