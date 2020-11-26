<?php
include('database_connection.php');
session_start();
$message = '';
if(isset($_SESSION['user_id'])){
	header('location:index.php');
}

if(isset($_POST['login'])){
	$query = "
		SELECT * FROM login 
  		WHERE username = :username
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':username' => $_POST["username"]
		)
	);	
	$count = $statement->rowCount();
	if($count > 0){
		$result = $statement->fetchAll();
		foreach($result as $row){
			if(password_verify($_POST["password"], $row["password"])){
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
				$sub_query = "
				INSERT INTO login_details 
	     		(user_id) 
	     		VALUES ('".$row['user_id']."')
				";
				$statement = $connect->prepare($sub_query);
				$statement->execute();
				$_SESSION['login_details_id'] = $connect->lastInsertId();
				header('location:index.php');
			}
			else{
				$message = '<label>Wrong Password</label>';
			}
		}
	}
	else{
		$message = '<label>Wrong Username</labe>';
	}
}
?>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="stylelogin.css" type="text/css">
</head>
<body style="background: url(bg2.png) no-repeat top center / cover;">
    <div style= "margin: 10%">
        <h2>Login</h2> 
        <form method="post">
        <div class="containerlogin">
            <div class="formgroup ">
                <label><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>
            </div>
            
            <div class="formgroup ">
                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
            </div>
            <button type="submit" name="login">Masuk</button>
            <input type="checkbox" checked="checked"><span> Ingat Saya</span>
        </div>
        <div class="containerlogin" style="background-color: #25333D; margin-top: 10px">
            <a href="register.php" class="regisbtn regislink">Registration</a>
            <a href="forgot.php" class="forgot">Lupa Password?</a>
        </div>
        </form>
    </div>
</body>
</html>