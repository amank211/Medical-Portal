<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $prm_email = $sec_email = $DOB = $blood_group = $hostel_wing = $department = $perm_address = $mobile_prm = $mobile_sec = "";
$username_err = $password_err = $confirm_password_err = "";
$student_id = $room_no = $batch = NULL;
$student_id_err = $room_no_err = $batch_err = $loginas_err = "";
$loginas = "";

$prm_email_err = $DOB_err = $hostel_wing_err = $department_err = $perm_address_err = $mobile_prm_err = ""; 
// Processing form data when form is submittedmysqli
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT student_id FROM " . $_POST["loginas"]. " WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["student_id"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group <?php echo (!empty($loginas_err)) ? 'has-error' : ''; ?>">
                <label>Login As</label>
                <input type="text" name="loginas" class="form-control" value="<?php echo $loginas; ?>">
                <span class="help-block"><?php echo $loginas_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                 <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($student_id_err)) ? 'has-error' : ''; ?>">
                <label>Roll Number</label>
                <input type="text" name="student_id" class="form-control" value="<?php echo $student_id; ?>">
                <span class="help-block"><?php echo $student_id_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($batch_err)) ? 'has-error' : ''; ?>">
                <label>Batch(YEAR)</label>
                <input type="text" name="batch" class="form-control" value="<?php echo $batch; ?>">
                <span class="help-block"><?php echo $batch_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($mobile_prm_err)) ? 'has-error' : ''; ?>">
                <label>Mobile Number</label>
                <input type="text" name="mobile_prm" class="form-control" value="<?php echo $student_id; ?>">
                <span class="help-block"><?php echo $mobile_prm_err; ?></span>
            </div>
			<div class="form-group <?php echo(!empty($prm_email_err)) ? 'has-error' : ''; ?>">
				<label for="inputEmail4">Email</label>
				 <input type="email" class="form-control" name = "prm_email" value = "<?php echo $prm_email; ?>">
				 <span class="help-block"><?php echo $prm_email_err; ?></span>
			</div> 
			<div class="form-group">
				<label for="inputEmail4">Alternative Email</label>
				 <input type="text" class="form-control" name = "sec_email" value = "<?php echo $sec_email; ?>">
			</div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
			
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>