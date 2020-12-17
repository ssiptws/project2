<?php
   session_start();
   ?>
<!DOCTYPE html>

<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Portofolio</title>
      <link rel="stylesheet" href="style.css">
      <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Montserrat:wght@500&display=swap" rel="stylesheet">
      <style>
          
      </style>
   </head>
   <body>
		<header>
			<h1 id="title">- Post - </h1>
			<div id="content">
				<?php
					require 'db.inc.php';
					$cid=$_GET['cid'];
					$tid=$_GET['tid'];
					$sql="SELECT * FROM topics WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
					$res=mysqli_query($conn,$sql);
					if(mysqli_num_rows($res)==1){
						echo"<table width='40%'>";
						while($row=mysqli_fetch_assoc($res)){
							$sql2="SELECT * FROM posts WHERE category_id='".$cid."'AND topic_id='".$tid."'";
							$res2=mysqli_query($conn,$sql2) or die(mysqli_error());
							while($row2=mysqli_fetch_assoc($res2)){
								echo"<tr><td valign='middle' style='border:1px solid #000000;'><div style='min-height:125px;'><br/>  ".$row2['post_creator']." - ".$row2['post_date']."<hr/>".$row2['post_content']."</div></td></tr></tr><br>";
							}
						$old_views=$row['topic_views'];
						$new_views=$old_views + 1;
						$sql3="UPDATE topic SET topic_views='".$new_views."' WHERE category_id='".$cid."'AND id='".$tid."' LIMIT 1";
						$res3=mysqli_query($conn,$sql3);
						}
						echo"</table>";
					}
					else{
						echo"<p>this topic doesnt exist</p>";
					}
				?>
			</div> 
		<div id="content1">
			<form action="post_reply_parse.php" method="post">
				<p id="title1">- Reply Content -</p>
				<?php
					if(isset($_GET['error'])){
						if($_GET['error']=="emptyspaces"){
							echo '<p class="errors8">Please input your reply!</p>';
						}                     
					}
				?>
				<textarea name="reply_content" rows="5" cols="75"></textarea>
				<br><br>
				<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
				<input type="hidden" name="tid" value="<?php echo $tid; ?>" />
				<input type="submit" name="reply_submit" value="Post Your Reply"/>
			</form>
		</div>
		</header>
	</body>
</html>