<?php
require_once "config.php";
$target_dir = "upload/";
$target_file = explode(".", $_FILES["fileToUpload"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($target_file);

if(isset($_POST["submit"])) {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newfilename)) {
        
		echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
		$sql = "INSERT INTO comp (name, email, phone, complaint, file) VALUES (?, ?, ?, ?, ?)";
		if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $desc, $file);
			$name = trim($_POST["name"]);
			$email = trim($_POST["email"]);
			$phone = trim($_POST["phone"]);
			$desc = trim($_POST["desc"]);
			$file = trim($newfilename);
            if(mysqli_stmt_execute($stmt)){
                echo "<script>alert('Your Complaint is Received')
                window.location.href='index.php'</script>";
            } else{
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
//            header("location: index.php");
        }
	} 
	else {
		echo "Sorry, there was an error uploading your file.";
	}
}
?>