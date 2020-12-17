<?php
   session_start();
   ?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Forum</title>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="../assets/css/floatingback.css">
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Montserrat:wght@500&display=swap" rel="stylesheet">
	</head>
	<body>
		<header>
			<h1 id="title"><span style="color:yellow">PO</span>ST</h1>
            <a class="back" href="Forum.php"><u>Back to Category</u></a>
			<div id="content">
				<?php
					require 'db.inc.php';
					$cid = $_GET['cid'];
					$tid = $_GET['tid'];
					$sql = "SELECT * FROM topics WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
					$res = mysqli_query($conn,$sql);
					if(mysqli_num_rows($res)==1){
						echo"<table style='margin-left: 30%' width='40%'>";
						while($row=mysqli_fetch_assoc($res)){
							$sql2="SELECT * FROM posts WHERE category_id='".$cid."'AND topic_id='".$tid."'";
							$res2=mysqli_query($conn,$sql2) or die(mysqli_error());
							while($row2=mysqli_fetch_assoc($res2)){
								echo"<tr><td valign='middle'><div><br/> ".$row2['post_creator']." - ".$row2['post_date']."<p id='contenttop'>".$row2['post_content']."</p></div></td></tr>";
							}
						$old_views = $row['topic_views'];
						$new_views = $old_views + 1;
						$sql3 = "UPDATE topics SET topic_views='".$new_views."' WHERE category_id='".$cid."'AND id='".$tid."' LIMIT 1";
						$res3 = mysqli_query($conn,$sql3);
						}
						echo"</table>";
					}
					else{
						echo"<p>this topic doesnt exist</p>";
					}
				?>
			</div>
            <a id="create" href="#" onclick="openForm()">Reply the post</a>
            <a id="return" style="display:none" href="#" class="home-btn" onclick="closeForm()">&larrhk;</a>
        <div id="container-pop-up">
			<form action="post_reply_parse.php" method="post">
				<p id="titlerep">Reply Post</p>
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
				<input type="submit" name="reply_submit" value="Submit"/>
			</form>
		</div>
		</header>
	</body>
    <script>
        function openForm() {
            document.getElementById("container-pop-up").style.display = "block";
            document.getElementById("create").style.display = "none";
            document.getElementById("return").style.display = "block";
        }
        function closeForm() {
            document.getElementById("container-pop-up").style.display = "none";
            document.getElementById("create").style.display = "block";
            document.getElementById("return").style.display = "none";
        }
    </script>
</html>