<?php
	session_start();
	
	if(!isset($_SESSION["loggedin"])){
		header("location: ../index.php");
		exit;
	}
	else{
		echo "<p> you are logged in as ".$_SESSION['username']." &bull; <a href='../logout.php'>Logout</a>";
	}
?>
<head>
	<title>Forum</title>
</head>

<body>
	<div id="wrapper">
		<h2>Forum</h2>
		<h3>Categories</h3>
		<?php
			require '../config.php';
			$sql = "SELECT * FROM categories ORDER BY category_title ASC";
			$res = mysqli_query($link, $sql) or die(mysqli_connect_error());
			if(mysqli_num_rows($res)>0){
				while($row = mysqli_fetch_assoc($res)){
					$id = $row['id'];
					$title = $row['category_title'];
					$description = $row['category_description'];
					$categories = "<a href='view_category.php?id=".$id."' class='cat_links'>" .$title." <span>" .$description."</span></a>";
				}
				echo $categories;
			}else{
				echo "<p> no categories available yet.";
			}
		?>
</body>