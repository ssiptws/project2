<?php
   session_start();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Categories</title>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Montserrat:wght@500&display=swap" rel="stylesheet">
		<link href="google.com">
	</head>
	<body>
		<header>
			<div id="content">
				<?php
					require 'db.inc.php';
					$sql= "SELECT * FROM categories ORDER BY category_title ASC";
					$res = mysqli_query($conn,$sql);
					$categories="";
					echo"<h1 id='Title2'>Categories</h1>";
					if(mysqli_num_rows($res)>0){
						$categories = "<table width='50%' style='border-collapse:collapse;'>";
						while($row=mysqli_fetch_assoc($res)){
							$id=$row['id'];
							$title=$row['category_title'];
							$description=$row['category_description'];                       
							$categories .= "<tr class='row'><td><a href='view_category.php?cid=".$id."' class='title'>".$title."</a><br><br> <span class='post_info'>".$description."</span></td></tr>";
							$categories .= "<tr><td colspan='3'><hr/></td></tr>";                    
						}
						$categories.="</table>";
						echo $categories;
					}
					else{
						echo"<p>There are no categories</p>";
					}
				?>
			</div>
		</header>
   </body>
</html>