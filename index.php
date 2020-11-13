<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: debug.log");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: debug.log");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
        <title>Landing Page</title>
        <link rel="stylesheet" href="assets/css/styleindex.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="form-popup" id="myForm">
            <center>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-container">
                    <div style="float: right; ">
                        <span><a href="#" onclick="closeForm()" style="text-decoration: none;color: white">X</a></span>
                    </div>
                    <center><h1 style="padding: 10px">Login</h1></center><br>
                    <label for="email"><b>Username</b></label><br>
                    <input type="text" placeholder="Enter Username" name="username" required><br>
					<span class="help-block"><?php echo $username_err; ?></span>
                    <label for="psw"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter Password" name="password" required> <br>
					<span class="help-block"><?php echo $password_err; ?></span>
					<input type="submit" class="btn btn-primary" value="Login">
                </form>
            </center>
        </div>
        <div class="container">
            <div class="menu">
                <ul>
                    <li class="logo"></li><li class="active">Home</li>
                   <li><a href="stage.html" style="color: white">Stages</a></li>
                    <li>Messege</li>
                    <li>About Us</li>
                    <li><a href="#" class="signup-btn" onclick="openForm()"><span>Sign Up</span></a></li>
                </ul>
            </div>
            <div class="banner">
                <div class="inner">
                    <h1>DEFQON 1 @ HOME</h1>
                    <p style="color: white"> If you can’t come to Defqon.1, Defqon.1 comes to you! From June 26th till June 28th, we’ll be bringing you the ultimate online Defqon.1 experience, for free. Prepare yourself for three days of madness with more than 30 artists and featuring every key element of Defqon.1!</p>
            </div>
        </div>
    </body>
    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }
</script>

</html>