<?php
   session_start();
   if(!isset($_SESSION['user_id'])){
	header('location:../index.php');
}
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Forum</title>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Montserrat:wght@500&display=swap" rel="stylesheet">
	</head>
	<body>
		<header>
			<div id="content">
				<?php
					require 'db.inc.php';
					$sql= "SELECT * FROM categories ORDER BY category_title ASC";
					$res = mysqli_query($conn,$sql);
					$categories="";
					echo"<h1 id='Title2'><span style='color:yellow'>CATEG</span>ORIES</h1>";
                    echo"<a style='margin-left:40%;' class='back' href='../index.php'><u>Back to Home</u></a>";
					if(mysqli_num_rows($res)>0){
						$categories = "<table width='50%'>";
						while($row=mysqli_fetch_assoc($res)){
							$id=$row['id'];
							$title=$row['category_title'];
							$description=$row['category_description'];                       
							$categories .= "<tr class='row'><td><a href='view_category.php?cid=".$id."' class='title'>".$title."</a><br> <td class='post_info'>".$description."</td></td></tr>";
							$categories .= "<tr><td colspan='3'></td></tr>";                    
						}
						$categories.="</table>";
						echo $categories;
					}
					else{
						echo"<p style='color: white'>No categories</p>";
					}
				?>
			</div>
		</header>
   </body>
</html>