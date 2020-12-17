<?php
   session_start();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Topics</title>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Montserrat:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/floatingback.css"/>
	</head>
	<body>
		<header>
		<h1 id="title"><span style="color:yellow">TOP</span>ICS</h1>
            <a style="margin-left:40%;" class="back" href="Forum.php"><u>Back to Category</u></a>
            <br>
        <div id="content">
            <?php
				require 'db.inc.php';
				$cid=$_GET['cid'];
				$sql="SELECT id FROM categories WHERE id='".$cid."'LIMIT 1";
				$res=mysqli_query($conn,$sql);
				if(mysqli_num_rows($res)==1){
					$sql2="SELECT * FROM topics WHERE category_id='".$cid."'ORDER BY topic_reply_date DESC";
					$res2 = mysqli_query($conn,$sql2);
					if(mysqli_num_rows($res2)>0){
						$topics = "<table width='50%' style='border-collapse:collapse;'>";
						$topics .="<tr id='titlerow'><td width='65'>Title</td><td width='65' align='center'>Replies</td><td width='65' align='.center'>Views</td></tr>";
						$topic = "<tr><td colspan='3'><hr/></td><tr>";
						while($row = mysqli_fetch_assoc($res2)){
							$tid = $row['id'];
							$title = $row['topic_title'];
							$views = $row['topic_views'];
							$res3 = mysqli_query($conn, "SELECT COUNT(topic_id) AS B FROM posts WHERE topic_id = '".$tid."'");
							while ($replies = mysqli_fetch_assoc($res3)){
								$reply = $replies['B'];
							}
							$date=$row['topic_date'];
							$creator=$row['topic_creator'];
							$topics .= "<tr id='tablerow'><td><a id='titlerow1'href='view_topic.php?cid=".$cid."&tid=".$tid."'><b>".$title."</b></a><br/><br/><span class='post_info'>Posted by: ".$creator."<br>".$date."</span></td><td align='center'>".$reply."<span> reply(ies)</span></td><td align='center'>".$views."<span> viewer(s)</span></td></tr>";
						}
						$topics.="</table>";
						echo $topics;
					}
					else{
						echo"<p style='color:white' id='error'>There are no topics yet</p>";
					}
				}
				else{
					echo"<a style='color:white' href='Forum.php'>Return to Forum Index</a>";
				}
			?>
        </div>
            <?php
				$cid=$_GET['cid'];
			?>
            <div id="container-pop-up">
			<div id="contentctop">
				<h1 id="title1">Create Topic</h1>
				<?php
					if(isset($_GET['error'])){
						if($_GET['error']=="emptyspaces"){
							echo '<p class="errors8">Please input your reply!</p>';
						}
					}
				?>
				<form action="create_topic_parse.php" method="post">
					<p class="p1">Title</p>
					<input type="text" name="topic_title" size="98" maxlength="150">
					<p class="p1">Content</p>
					<textarea name="topic_content" rows="5" cols="75"></textarea>
					<br/><br/>
					<input type="hidden" name="cid" value="<?php echo $cid; ?>"/>
					<input type="submit" name="topic_submit" value="Submit"/>
				</form>
			</div>
            </div>
        <div>
			<h1>
				<?php echo"<br><a id='create' href='#?cid=".$cid."' onclick='openForm()'>Create a new topic</a>";?></h1></div>
            <a id="return" style="display:none" href="#" class="home-btn" onclick="closeForm()">&larrhk;</a>
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