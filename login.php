<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $loginas_err = "";
$username = "";
$loginas = "";
$DOB = $hostel = $room = $batch = $department = $mobile = ""; 
$spec = $mobile = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
	if($_POST["loginas"] == "Login As"){
		$loginas_err = "please select department";
	} else{
		$loginas = $_POST["loginas"];
	}
    
    // Validate credentials
    if(empty($email_err) && empty($password_err) && empty($loginas_err)){
        // Prepare a select statement
		switch($loginas){
			case  "Student" :
				$sql = "SELECT student_id, prim_email, pswd, name, DOB, hostel_wing, room_no, batch, department, mobile_prim FROM btech_students where prim_email = ?";
				if($stmt = mysqli_prepare($link, $sql)){
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $param_email);
            
					// Set parameters
					$param_email = $email;
            
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						// Store result
						mysqli_stmt_store_result($stmt);
                
						// Check if email exists, if yes then verify password
						if(mysqli_stmt_num_rows($stmt) == 1){                    
							// Bind result variables
							mysqli_stmt_bind_result($stmt, $student_id, $email, $password, $username, $DOB, $hostel, $room, $batch, $department, $mobile);
							if(mysqli_stmt_fetch($stmt)){
								if($password == $_POST["password"]){
									// Password is correct, so start a new session
									session_start();
                            
									// Store data in session variables
									$_SESSION["loggedin"] = true;
									$_SESSION["student_id"] = $student_id;
									$_SESSION["email"] = $email;  
									$_SESSION["username"] = $username;
									$_SESSION["loggedinas"] = $loginas;
									$_SESSION["dob"] = $DOB; 
									$_SESSION["hostel"] = $hostel; 
									$_SESSION["room"] = $room; 
									$_SESSION["batch"] = $batch;
									$_SESSION["department"] = $department; 
									$_SESSION["mobile"] = $mobile; 
                            
									// Redirect user to welcome page
									header("location: welcome.php");
								} else{
									// Display an error message if password is not valstudent_id
									$password_err = "The password you entered was not valid.";
								}
							}
						} else{
							// Display an error message if email doesn't exist
							$email_err = "No account found with that email.";
						}
					} else{
						echo "Oops! Something went wrong. Please try again later.";
					}
				}
				// Close statement
				break;
				mysqli_stmt_close($stmt);
			case "Doctor" :
				$sql = "SELECT doctor_id, prim_email, pswd, name, specilisation, mob_prim FROM doctors where prim_email = ?";
				if($stmt = mysqli_prepare($link, $sql)){
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $param_email);
            
					// Set parameters
					$param_email = $email;
            
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						// Store result
						mysqli_stmt_store_result($stmt);
                
						// Check if email exists, if yes then verify password
						if(mysqli_stmt_num_rows($stmt) == 1){                    
							// Bind result variables
							mysqli_stmt_bind_result($stmt, $doctor_id, $email, $password, $username, $spec, $mobile);
							if(mysqli_stmt_fetch($stmt)){
							if($password == $_POST["password"]){
								// Password is correct, so start a new session
								session_start();
                            
								// Store data in session variables
								$_SESSION["loggedin"] = true;
								$_SESSION["student_id"] = $doctor_id;
								$_SESSION["email"] = $email;  
								$_SESSION["username"] = $username;
								$_SESSION["loggedinas"] = $loginas;
								$_SESSION["mobile"] = $mobile;
								$_SESSION["spec"] = $spec;
                            
								// Redirect user to welcome page
								 header("location: doctor_homepage.php");
							} else{
								// Display an error message if password is not valstudent_id
								$password_err = "The password you entered was not valid.";
							}
						}
						} else{
							// Display an error message if email doesn't exist
							$email_err = "No account found with that email.";
						}
					} else{
						echo "Oops! Something went wrong. Please try again later.";
					}
				}
        
				// Close statement
				mysqli_stmt_close($stmt);
				break;
			case "Faculty" :
				
				break;
			case "Staff" :
				break;
		}
	}
	mysqli_close($link);
}
?>