<?php
session_start();
require_once "config.php";
include 'mail.php';
//validating time slot
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
if($stmt = mysqli_prepare($link,$sql)){
	if(mysqli_stmt_execute($stmt)){
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $doctor_name, $specs, $d_id);
		while(mysqli_stmt_fetch($stmt)){
			array_push($appointments, array($doctor_name, $specs, $d_id));
		}
	}

}
mysqli_stmt_close($stmt);


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
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
	if(empty($_POST["problem"])){
		$problem_err = "please mention your issue";

	} else{
		$problem = $_POST["problem"];
	}
	if($_POST["doctor"] == "Doctor"){
		$doctor_err = "please mention doctor";

	} else{
		$doctor_id = $_POST["doctor"];
	}
	if(empty($date_err) && empty($time_err) && empty($problem_err) && empty($doctor_err)){
		$sql = "SELECT COUNT(reff_no) FROM appointments where Doctor_id = ? AND appoint_time = ?;";
		if($stmt3 = mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt3, 'is', $param_id, $param_time);
			$param_id = $doctor_id;
			$param_time = $datetime;
			if(mysqli_stmt_execute($stmt3)){
				mysqli_stmt_store_result($stmt3);
				mysqli_stmt_bind_result($stmt3, $count);
				while(mysqli_stmt_fetch($stmt3)){
					 $count_time = $count;
				}
			}
		}
		if($count_time > 0){
			$available = false;
		} 
	}


	//check input errors
	if(empty($date_err) && empty($time_err) && empty($problem_err) && empty($doctor_err) && $available){
        // Prepare an insert statement
		
        $sql = "INSERT INTO appointments (student_id, Department, patient_name, Problem, Doctor_id, Appoint_time, Booked_AT) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$sql2 = "SELECT name from doctors where doctor_id = ?";

		if($stmt2 = mysqli_prepare($link,$sql2)){
			mysqli_stmt_bind_param($stmt2, 'i', $param_id);
			$param_id = $doctor_id;
			if(mysqli_stmt_execute($stmt2)){
				mysqli_stmt_store_result($stmt2);
				mysqli_stmt_bind_result($stmt2, $name);
				while(mysqli_stmt_fetch($stmt2)){
					$doctor_name = $name;
				}
			}

		}
         
        if($stmt = mysqli_prepare($link ,$sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iississ", $param_student_id, $param_Department, $param_patient_name, $param_problem, $param_doctor, $param_time, $param_curr_time);
            // Set parameters
			$param_student_id = $_SESSION["student_id"];
			$param_Department = $dept_id;
            $param_patient_name = $_SESSION["username"];
            $param_problem = $problem;
			$param_doctor = $doctor_id;
			$param_time = $datetime;
			date_default_timezone_set('Asia/Kolkata');
			$param_curr_time = date( 'Y-m-d h:i:s A', time () );
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				//mail the confirmation of booking
				
				sendemail($_SESSION["email"], 435453, $datetime, $doctor_name);
                // Redirect to login page
                header("location: welcome.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
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
			<a class="nav-link" href="welcome.php">Profile<span class="sr-only">(current)</span></a>
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
		<input type = "date" name = "date" id = "pickdate" placeholder="dd-mm-yyyy">
		<select name = "time" class = "dropdown" id = "time_slot" >
		<option style="display: none" not selected>HH:MM</option>
		<option value = "10:00">10:00</option>
		<option value = "10:30">10:30</option>
		<option value = "11:00">11:00</option>
		<option value = "11:30">11:30</option>
		<option value = "12:00">12:00</option>
		<option value = "01:00">01:00</option>
		<option value = "01:30">01:30</option>
		</select>
		<select name = "doctor" class = "dropdown" id = "doctors">
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
</script>

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
.issue{
	height: 40px;
	background: #f4f4f4;
	border-radius: 4px;
	text-align: center;
	
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

		

		function whatisselected(rip){
			if(rip.value == "2") alert("Please select a doctor in upper left corner of this page");
			if(rip.value == "1") alert("Please select a free slot");
			if(rip.value == "4") alert("Can't Book in Past");
			if(rip.value == "0") {Refer(rip);}
			
		}
		
		
		
		
	
		document.getElementById('day').innerHTML =    "<th> <div><input id = \"problem\"class = \"issue\" placeholder=\"Issue....\"></div> <div class=\"btn-group\"><button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id = \"seledoctor\">Dr. </button><div id = \"doctormenu\"class=\"dropdown-menu dropdown-menu-right\"></div></div> <button style = \"margin : 10px; \"id = \"submit\" type=\"button\" class=\"btn btn-primary\">Select a time</button></th>";
		document.getElementById("10:00").innerHTML = "<td class=\"time\">10:00</td>";
		document.getElementById("10:30").innerHTML = "<td class=\"time\">10:30</td>";
		document.getElementById("11:00").innerHTML = "<td class=\"time\">11:00</td>";
		document.getElementById("11:30").innerHTML = "<td class=\"time\">11:30</td>";
		document.getElementById("12:00").innerHTML = "<td class=\"time\">12:00</td>";
		document.getElementById("12:30").innerHTML = "<td class=\"time\">12:30</td>";
		document.getElementById("01:00").innerHTML = "<td class=\"time\">01:00</td>";
		document.getElementById("01:30").innerHTML = "<td class=\"time\">01:30</td>";
		var i;
		var length = "<?php echo count($appointments);?>";
		var appoints = <?php echo json_encode($appointments);?>;

		var seldoc;

		function getdata(elem){
			
			document.getElementById("seledoctor").innerHTML = elem.name;
			seldoc = elem;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				var response = JSON.parse(this.responseText);
						ondocchange(response);
				}
			};
			xmlhttp.open("GET", "getappointments.php?q=" + seldoc.id, true);
			xmlhttp.send();
		}

		for(i=0;i<4;i++){
			var val = appoints[i];
			document.getElementById('doctormenu').innerHTML += "<button onclick = \"getdata(this)\" name = \""+val[0]+"\"class=\"dropdown-item\" type=\"button\" id = \""+ val[2] +"\"> "+ val[0] + "  ("+ val[1]+") " + "</button>";
			//document.getElementById('cards').innerHTML += "<div class=\"card mb-3\" style=\"width: 27%;\"><div class=\"row no-gutters\"><div class=\"col-md-4\"><img src=\"images/no_image_2.png\" class=\"card-img\" alt=\"...\"></div><div class=\"col-md-8\"><div class=\"card-body\"><h5 class=\"card-title\">"+ val[0] +"</h5><p class=\"card-text\">"+ val[1] +"</p></div></div></div></div>";
		}
		
		
		
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
			document.getElementById('day').innerHTML += "<th>" + getdayname(d.getDay()) + "   <br> " +  d.getDate() + "  " + getmonthname(d.getMonth()) + "  " + d.getFullYear().toString().substr(-2) + "</th>" ;	
			if(blue == 0){ 
				document.getElementById("10:00").innerHTML += "<td value = \"2\"  class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";	
				document.getElementById("10:30").innerHTML += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("11:00").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				document.getElementById("11:30").innerHTML  += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("12:00").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				document.getElementById("12:30").innerHTML  += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("01:00").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				document.getElementById("01:30").innerHTML += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				blue = 1;
			}else{
				document.getElementById("10:00").innerHTML += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("10:30").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				document.getElementById("11:00").innerHTML += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("11:30").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				document.getElementById("12:00").innerHTML += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("12:30").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				document.getElementById("01:00").innerHTML += "<td value = \"2\" class=\"md303 navy\" data-tooltip=\"Media &amp; Globalisation\">Free to Book</td>";
				document.getElementById("01:30").innerHTML += "<td value = \"2\" class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
				
				blue = 0;
			}
				
			
		}

		
		var today = new Date();
		
		
			

		
	

		function ondocchange(data){

			var i;
			var j;
			var date_map = {};
			var length2 = data.length;
			var appoints2 = data;
			console.log(data);
			reset();
			
			var k = 0;
			for(k = 0; k < data.length;k++){
				//console.log(getindices(dict_date[key][k]).time);
				document.getElementById("table").rows[getindices(data[k]).time].cells[getindices(data[k]).day].className = "cs426 purple";
				document.getElementById("table").rows[getindices(data[k]).time].cells[getindices(data[k]).day].innerHTML = "BOOKED";
				document.getElementById("table").rows[getindices(data[k]).time].cells[getindices(data[k]).day].value = "1";
				//document.getElementById("table").rows[getindices(dict_date[key][k]).time].cells[getindices(dict_date[key][k]).day].innerHTML = "App No : " + dict_date[key][k][0] + "<br>" + dict_date[key][k][1] + "<br>" + dict_date[key][k][3].slice(11,16);
			
			}
			
		}

		var k;
		var i;
		var weekdate = new Date();
		for(k = 1; k < 9 ;k++){
				for(i = 1; i<6;i++){
					document.getElementById("table").rows[k].cells[i].onclick = function(){whatisselected(this);};
					document.getElementById("table").rows[k].cells[i].id = k +"x"+i;
					if(i < weekdate.getDay() ){
						document.getElementById("table").rows[k].cells[i].value = "4";
						document.getElementById("table").rows[k].cells[i].innerHTML = "Can't book";	
					}else{
						document.getElementById("table").rows[k].cells[i].value = "2";
						document.getElementById("table").rows[k].cells[i].innerHTML = "Free to Book";	
					}
					
				}
			}

		function reset(){
			var k;
			var i;
			var toggle = 0;
			for(k = 1; k < 9 ;k++){
				for(i = 1; i<6;i++){
					//console.log(getindices(dict_date[key][k]).time);
					if(toggle ==0){
						document.getElementById("table").rows[k].cells[i].className = "cs335 blue lab";
						toggle = 1;
					} else{
						document.getElementById("table").rows[k].cells[i].className = "md303 navy";
						toggle = 0;
					}
					if(i < weekdate.getDay() ){
						document.getElementById("table").rows[k].cells[i].value = "4";
						document.getElementById("table").rows[k].cells[i].innerHTML = "Can't book";	
					}else{
						document.getElementById("table").rows[k].cells[i].value = "0";
						document.getElementById("table").rows[k].cells[i].innerHTML = "Free to Book";	
					}
					
				}
			}
		}
		

		function getindices(date){
			var day;
			var time;

			var temp = new Date(date.slice(0,10));
			day = temp.getDay();
		

			switch (date.slice(11,16)) {
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
		var selected;
		var prevcolor;
		function Refer(elem){
			if(selected != null){
				document.getElementById(selected).style.backgroundColor = prevcolor;
			} else{ 
				
			}
			document.getElementById("submit").innerHTML = "Book";
			prevcolor = elem.style.backgroundColor;
			selected = elem.id;
			elem.style.backgroundColor = "#fa744f";
			
			
		}

		function gettimedate(date){
			var time;

			var temp = new Date();
			if(temp.getDay() == 6){
				console.log(temp.getDate());
				var first = temp.getDate() - temp.getDay();
				temp.setDate(temp.getDate() + 7);
		
			}
			temp = getweek(temp);

			temp.setDate(temp.getDate() + parseInt(date[2]));


			switch (date[0]) {
	           case "1":
		            time = "10:00";
		            break;
				case "2":
		            time = "10:30";
		            break;
				case "3":
		            time = "11:00";
		            break;
				case "4":
		            time = "11:30";
		            break;
				case "5":
		            time = "12:00";
		            break;
				case "6":
		            time = "12:30";
		            break;
				case "7":
		            time = "01:00";
		            break;
				case "8":
		            time = "01:30";
		            break;
	           default:
		            
		            break;

	
}

			return {temp,time};
			
		}

		
		

		document.getElementById("submit").onclick = function(){ 
			var problem = document.getElementById("problem").value;
			
			if(problem != 0){
				if(seldoc == null){
					alert("please, select a doctor to book an appointment");
				} else{
					if(selected == null){
							alert("please select a free slot to book appointment.")
					
					}else{
						var obj = JSON.parse('{}');
						obj.time = gettimedate(selected).time;
						obj.date = gettimedate(selected).temp.toLocaleDateString();
						alert(obj.date);
						alert(selected);
						obj.doc = seldoc.id;
						obj.problem = problem;
						obj.username = "<?php echo $_SESSION["username"];?>";
						obj.user_id = <?php echo $_SESSION["student_id"];?>;
						var str = JSON.stringify(obj);
						
					
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								alert(this.responseText);
							}
						};
						xmlhttp.open("GET", "confirm-booking.php?q=" + str, true);
						xmlhttp.send();
					
						//location.href = "replace_with.php" + "?id=" + selected;
					}
				
				}
			}else{
				alert("please mention your issue in text field");
			}
		};
		

		

		


		
    </script>
</body>
</html>