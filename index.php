<?php
include('gc/database_connection.php');
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
				header('location:gc/index.php');
				echo"sukses";
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
        <title>Landing Page</title>
        <link rel="stylesheet" href="assets/css/styleindex.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/custom.js"></script>
    </head>
    <body>
        <div class="form-popup" id="myForm">
            <center>
                <form method="post" class="form-container">
                    <div style="float: right; ">
                        <span><a href="#" onclick="closeForm()" style="text-decoration: none;color: white">X</a></span>
                    </div>
                    <center><h1 style="padding: 10px">Login</h1></center><br>
                    <label for="email"><b>Username</b></label><br>
                    <input type="text" placeholder="Enter Username" name="username" required><br>
                    <label for="psw"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter Password" name="password" required> <br>
					<button type="submit" class="btn btn-primary" name="login">Masuk</button>
					<div class="register">
						<a href="register.php">Click Here To Register!</a>
					</div>
                </form>
            </center>
        </div>
        <div class="form-popup" id="myFormSearch" style="color: white">
            <center>
                <br><br><br>
                        
                <big>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Check Username You Want To Use</label><br>
                    <input style="height: 30px; width: 400px" type="email" class="form-control" id="search" autocomplete="off" placeholder="Enter Your Name">
                </div>
                <br><br>
                <h5 align="center" id="results-text">Showing results for: <b id="search-string"> </b></h5>
                <div align="center">
                    <ul id="results" class="text-decoration;none">
                    </ul>
                </div>
                    <br><br>
                    <a href="#" onclick="closeFormSearch()" style="color:white"><span>&#10006;</span></a>
                </big>
            </center>
        </div>
        <div class="container">
		<center>
            <div class="menu">
                <ul>
                    <li class="logo"></li>
					<li class="active"><a href="index.php">Home</a></li>
                    <li><a href="stage.html" style="color: white">Stages</a></li>
                    <li><a href="gc/index.php" onclick="openForm()" style="color: white">Messege</a></li>
                    <li><a href="contactus.html" style="color: white">Customer Care</a></li>
                    <li><a href="forum/Forum.php" style="color: white">Forum</a></li>
                    <li><a href="aboutus.php" style="color: white">About Us</a></li>
                    <li><a href="#" class="signup-btn" onclick="openForm()"><span>Login</span></a></li>
                </ul>
                <a href="#" style="font-size:25px" onclick="openFormSearch()">&#128269;</a>
            </div>
			</center>
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
        function openFormSearch() {
            document.getElementById("myFormSearch").style.display = "block";
        }

        function closeFormSearch() {
            document.getElementById("myFormSearch").style.display = "none";
        }
</script>

</html>