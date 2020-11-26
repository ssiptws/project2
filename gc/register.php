<?php
include('database_connection.php');
session_start();
$message = '';
if(isset($_SESSION['user_id'])){
	header('location:index.php');
}

if(isset($_POST["register"])){
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	$check_query = "
	SELECT * FROM login 
	WHERE username = :username
	";
	$statement = $connect->prepare($check_query);
	$check_data = array(
		':username'		=>	$username
	);
	if($statement->execute($check_data)){
		if($statement->rowCount() > 0){
			$message .= '<p><label>Username already taken</label></p>';
		}
		else{
			if(empty($username)){
				$message .= '<p><label>Username is required</label></p>';
			}
			if(empty($password)){
				$message .= '<p><label>Password is required</label></p>';
			}
			else{
				if($password != $_POST['confirm_password']){
					$message .= '<p><label>Password not match</label></p>';
				}
			}
			if($message == ''){
				$data = array(
					':username'		=>	$username,
					':password'		=>	password_hash($password, PASSWORD_DEFAULT)
				);

				$query = "
				INSERT INTO login 
				(username, password) 
				VALUES (:username, :password)
				";
				$statement = $connect->prepare($query);
				if($statement->execute($data)){
					$message = "<label>Registration Completed</label>";
				}
			}
		}
	}
}

?>

<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="stylelogin.css" type="text/css">
    <link rel="stylesheet" href="regismenu.css" type="text/css">
    <style>
        .home{
            position: absolute;
            top: 11%;
            float: right;
            left: 70%;
            max-width: 30px;
            width: 100%;
            background-color: white;
            padding: .5px;
            border-radius: 4px;
        }
        .home img{
            width: 30px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="home"><a href="../index.php"><img src="../images/home.png"> </a></div>
    	<h2 style="margin-top: 5%;">Signup</h2> 
        <form method="post"  >	
            <div class="containerlogin">		
                <label><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>
			
				<label><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="password" required> 
			
				<label><b>Confirm Password</b></label>
				<input type="password" placeholder="Enter Password" name="confirm_password" required> 
			
                <button type="submit" name="register">Register</button>
                <span class="help-block"><?php echo $message; ?></span>
            </div>
            <div class="containerlogin" style="background-color: #25333D; margin-top: 10px;">
                <p style="color : WHITE"> Sudah punya akun? <a href="login.php" style="color: white">Login disini</a>.</p>
            </div>		
        </form>
    </div>
    <script src="app.js"></script>
</body>  
</html>