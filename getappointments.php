<?php


// get the q parameter from URL
$q = $_REQUEST["q"];


require_once "config.php";
$upcoming_appointments = array();
$sql = "Select appoint_time from appointments where Doctor_id = ? AND YEARWEEK(DATE(Cast(appoint_time as date)), 1) = YEARWEEK(curdate() ,1) ORDER BY appoint_time;";
if($stmt = mysqli_prepare($link,$sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_doctor_id);

	$param_doctor_id = $q;

	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $appoint_time);
		while(mysqli_stmt_fetch($stmt)){
			array_push($upcoming_appointments, $appoint_time);
		}
	}

}
mysqli_stmt_close($stmt);
mysqli_close($link);




// Output "no suggestion" if no hint was found or output correct values
echo json_encode($upcoming_appointments);
?>