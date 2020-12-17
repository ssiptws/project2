<?php
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM login WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
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

            // Close statement
            mysqli_stmt_close($stmt);
        }
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
        $sql = "INSERT INTO login (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/register.css">
	</head>
	<body>
		<div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-container">
			<center>
                    <h1 style="padding: 10px">Register</h1><br>
					
					<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label for="email"><b>Username</b></label><br>
                    <input type="text" placeholder="Enter Username" name="username" required><br>
					<span class="help-block"><?php echo $username_err; ?></span>
					</div>
					
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label for="psw"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter Password" name="password" required> <br>
					<span class="help-block"><?php echo $password_err; ?></span>
					<div>
					
					<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<label>Confirm Password</label>
					<input type="password" name="confirm_password" placeholder="Re-enter the Password" class="form-control" value="<?php echo $confirm_password; ?>">
					<span class="help-block"><?php echo $confirm_password_err; ?></span>
					</div>
					
					<input type="submit" class="btn btn-primary" value="Register">
					<input type="reset" class="btn btn-default" value="Reset">
					<p>Already have an account? <a href="index.php">Login here</a>.</p>
                </form>
			</center>
		</div>
	</body>
</html>