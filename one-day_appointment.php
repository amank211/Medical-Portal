<?php

session_start();

require_once "config.php";
$sql = "Select reff_no, patient_name, Problem, Cast(appoint_time as time) from appointments where Doctor_id = ? AND Cast(appoint_time as date) = CURRENT_DATE order by appoint_time";
$appointments = array();
$upcoming_appointments = array();
if($stmt = mysqli_prepare($link,$sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_doctor_id);

	$param_doctor_id = $_SESSION["student_id"];

	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $reff_no, $patient_name, $problem, $appoint_time);
		while(mysqli_stmt_fetch($stmt)){
			array_push($appointments, array($reff_no, $patient_name, $problem, $appoint_time));
		}
	}

}
mysqli_stmt_close($stmt);
$sql = "Select reff_no, patient_name, Problem, appoint_time from appointments where Doctor_id = ? AND YEARWEEK(DATE(Cast(appoint_time as date)), 1) = YEARWEEK(curdate() ,1) ORDER BY appoint_time;";
if($stmt = mysqli_prepare($link,$sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_doctor_id);

	$param_doctor_id = $_SESSION["student_id"];

	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $reff_no, $patient_name, $problem, $appoint_time);
		while(mysqli_stmt_fetch($stmt)){
			array_push($upcoming_appointments, array($reff_no, $patient_name, $problem, $appoint_time));
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/welcome.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css">
	<link type="text/css" rel="stylesheet" href="css/layout.css"/>
	  <style type="text/css">
			nav, .container { font: 14px sans-serif; text-align: center; }
		</style>
		<script src="js/daypilot/daypilot-all.min.js"></script>
	
		
	 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style = "css/welcome.css">
	  <a class="navbar-brand" href="doctor_homepage.php">Medical Portal</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
		  <li class="nav-item active">
			<a class="nav-link" href="doctor_homepage.php">Profile<span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="one-day_appointment.php"  style = "text-decoration : underline">Appointments</a>
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







<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400);
.blue {
  background: #3498db;
}

.purple {
  background: #9b59b6;
}

.navy {
  background: #34495e;
}

.green {
  background: #2ecc71;
}

.red {
  background: #e74c3c;
}

.orange {
  background: #f39c12;
}

.cs335, .cs426, .md303, .md352, .md313, .cs240 {
  font-weight: 300;
  cursor: pointer;
}



*, *:before, *:after {
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

table {
  font-family: 'Open Sans', Helvetica;
  color: #efefef;
}
table tr:nth-child(2n) {
  background: #eff0f1;
}
table tr:nth-child(2n+3) {
  background: #fff;
}
table th, table td {
  padding: 1em;
  width: 100em;
}

.tab{
	margin: 10px 0%;
}

.days, .time {
  background: #27496d;
  text-transform: uppercase;
  font-size: 1.2em;
  text-align: center;
}
</style>
<script>
  window.console = window.console || function(t) {};
</script>
<script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>

<div class="tab">
<table border="0" cellpadding="0" cellspacing="0" id = "table"><tr class="days" id = "day">

</tr>
<tr id = "10:00">

</tr>
<tr id = "10:30">
<td class="time">11.00</td>
<td></td>
<td class="cs335 blue lab" data-tooltip="Software Engineering &amp; Software Process">CS335 [Lab]</td>
<td class="md352 green" data-tooltip="Multimedia Production &amp; Management">MD352 [Kairos]</td>
<td class="cs240 orange" data-tooltip="Operating Systems">CS240 [CH]</td>
<td>-</td>
</tr>
<tr id = "11:00">
<td class="time">12.00</td>
<td></td>
<td class="md303 navy" data-tooltip="Media &amp; Globalisation">MD303 [CS2]</td>
<td class="md313 red" data-tooltip="Special Topic: Multiculturalism &amp; Nationalism">MD313 [Iontas]</td>
<td></td>
<td>-</td>
</tr>
<tr id = "11:30">
<td class="time">13.00</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>-</td>
</tr>
<tr id = "12:00">
<td class="time">14.00</td>
<td></td>
<td></td>
<td class="cs426 purple" data-tooltip="Computer Graphics">CS426 [CS2]</td>
<td class="cs240 orange" data-tooltip="Operating Systems">CS240 [TH1]</td>
<td>-</td>
</tr>
<tr id = "12:30">
<td class="time">15.00</td>
<td></td>
<td></td>
<td></td>
<td class="cs240 orange lab" data-tooltip="Operating Systems">CS240 [Lab]</td>
<td>-</td>
</tr>
<tr id = "01:00">
<td class="time">16.00</td>
<td></td>
<td></td>
<td></td>
<td class="cs240 orange lab" data-tooltip="Operating Systems">CS240 [Lab]</td>
<td>-</td>
</tr>
<tr id = "01:30">
<td class="time">17.00</td>
<td class="cs335 blue" data-tooltip="Software Engineering &amp; Software Process">CS335 [TH1]</td>
<td></td>
<td></td>
<td></td>
<td>-</td>
</tr></table>
</div>
</body>
<script>
	

		function getweek(date){
			var first = date.getDate() - date.getDay(); // First day is the day of the month - the day of the week
			var startday = new Date(date.setDate(first));
			return startday;  
			
		}

		function getdayname(num){
			var a;
			n = num;
			switch (n) {
	            case 0:
		             a = "Sun"
		             break;
				case 1:
		             a =  "Mon"
		             break;
				case 2:
		             a =  "Tue"
		             break;
				case 3:
		             a =  "Wed"
		             break;
				case 4:
		             a =  "Thu"
		             break;
				case 5:
		             a =  "Fri"
		             break;
				case 6:
		             a =  "Sat"
		             break;
	            default:
		       
		            break;
}			return a;

		}

		function getmonthname(num){
			var a;
			n = num;
			switch (n) {
	            case 0:
		             a = "Jan"
		             break;
				case 1:
		             a =  "Feb"
		             break;
				case 2:
		             a =  "Mar"
		             break;
				case 3:
		             a =  "Apr"
		             break;
				case 4:
		             a =  "May"
		             break;
				case 5:
		             a =  "Jun"
		             break;
				case 6:
		             a =  "Jul"
		             break;
				case 7:
		             a = "Aug"
		             break;
				case 8:
		             a =  "Sep"
		             break;
				case 9:
		             a =  "Oct"
		             break;
				case 10:
		             a =  "Nov"
		             break;
				case 11:
		             a =  "Dec"
		             break;
	            default:
		       
		            break;
}			return a;

		}	
		
		
	
		document.getElementById('day').innerHTML = "<th></th>";
		document.getElementById("10:00").innerHTML = "<td class=\"time\">10:00</td>";
		document.getElementById("10:30").innerHTML = "<td class=\"time\">10:30</td>";
		document.getElementById("11:00").innerHTML = "<td class=\"time\">11:00</td>";
		document.getElementById("11:30").innerHTML = "<td class=\"time\">11:30</td>";
		document.getElementById("12:00").innerHTML = "<td class=\"time\">12:00</td>";
		document.getElementById("12:30").innerHTML = "<td class=\"time\">12:30</td>";
		document.getElementById("01:00").innerHTML = "<td class=\"time\">01:00</td>";
		document.getElementById("01:30").innerHTML = "<td class=\"time\">01:30</td>";

		
		var d = new Date();
		
		//console.log("start", start.getDate());
		var blue = 0;		
		var i = 0;
		if(d.getDay() == 6){
			console.log(d.getDate());
			var first = d.getDate() - d.getDay();
			d.setDate(d.getDate() + 7);
		
		}
		var d = getweek(d);
		for(i = 1; i <6; i++){
		
			d.setDate(d.getDate() + 1);
			document.getElementById('day').innerHTML += "<th>" + getdayname(d.getDay()) + "    " +  d.getDate() + "  " + getmonthname(d.getMonth()) + "  " + d.getFullYear().toString().substr(-2) + "</th>" ;	
			if(blue == 0){ 
				document.getElementById("10:00").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("10:30").innerHTML += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("11:00").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("11:30").innerHTML  += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("12:00").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("12:30").innerHTML  += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("01:00").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("01:30").innerHTML += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				blue = 1;
			}else{
				document.getElementById("10:00").innerHTML += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("10:30").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("11:00").innerHTML += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("11:30").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("12:00").innerHTML += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("12:30").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				document.getElementById("01:00").innerHTML  += "<td class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">No Appointments</td>";
				document.getElementById("01:30").innerHTML += "<td class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">No Appointments</td>";
				blue = 0;
			}
			
		}

		
		var today = new Date();
		
		
			

		var i;
		var j;
		var date_map = {};
		var length2 = "<?php echo count($upcoming_appointments);?>";
		var appoints2 = <?php echo json_encode($upcoming_appointments);?>;
		var dict_date = {};
		for (var j = 0; j<length2;j++){
			var val = appoints2[j];		
			var d = new Date(val[3].slice(0,11));
			dict_date[d] = new Array();
			dict_date[d].push(val)
		}
		for(i=0;i<length2;i++){
			var value2 = appoints2[i];
			
		
			//document.getElementById('cards2').innerHTML +=  "<div class=\"card text-black bg-secondary mb-3\" style=\"max-width: 20rem; max-height: 20 rem; background-color : #d6e5fa ! important;\"> <div class=\"card-header\">Appointment Number: " + value2[0] + "</div><div class=\"card-body\"><h5 class=\"card-title\">Patient: " + value2[1] + "</h5><p class=\"card-text\">Issue: " + value2[2] + "<br>Scheduled at:" + value2[3].slice(10,16) + " " + value2[3].slice(0,11) +"</p></div></div>";
		}
		

		function getindices(date){
			var day;
			var time;

			var temp = new Date(date[3].slice(0,10));
			day = temp.getDay();
		

			switch (date[3].slice(11,16)) {
	           case "10:00":
		            time = 1;
		            break;
				case "10:30":
		            time = 2;
		            break;
				case "11:00":
		            time = 3;
		            break;
				case "11:30":
		            time = 4;
		            break;
				case "12:00":
		            time = 5;
		            break;
				case "12:30":
		            time = 6;
		            break;
				case "01:00":
		            time = 7;
		            break;
				case "01:30":
		            time = 8;
		            break;
	           default:
		            
		            break;
	
}

			return {day,time};
			
		}
		Object.keys(dict_date).forEach(function(key) {
			
			var k = 0;
			for(k = 0; k < dict_date[key].length;k++){
				console.log(getindices(dict_date[key][k]).time);
				document.getElementById("table").rows[getindices(dict_date[key][k]).time].cells[getindices(dict_date[key][k]).day].className = "cs426 purple";
				document.getElementById("table").rows[getindices(dict_date[key][k]).time].cells[getindices(dict_date[key][k]).day].innerHTML = "App No : " + dict_date[key][k][0] + "<br>" + dict_date[key][k][1] + "<br>" + dict_date[key][k][3].slice(11,16);
			
			}
		});

		


		
    </script>



</html>