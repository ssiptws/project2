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
	</head>
	<body>
		<header>
		<h1 id="title">- Topics -</h1>
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
						$topics .="<tr id='titlerow'><td width='65'>Topic Title</td><td width='65' align='center'>Replies</td><td width='65' align='.center'>Views</td></tr>";
						$topic = "<tr><td colspan='3'><hr/></td><tr>";
						while($row=mysqli_fetch_assoc($res2)){
							$tid=$row['id'];
							$title=$row['topic_title'];
							$views=$row['topic_views'];
							$date=$row['topic_date'];
							$creator=$row['topic_creator'];
							$topics .= "<tr id='tablerow'><td><a id='titlerow1'href='view_topic.php?cid=".$cid."&tid=".$tid."'>".$title."</a><br/><br/><span class='post_info'>Posted by: ".$creator." on ".$date."</span></td><td align='center'>0</td><td align='center'>".$views."</td></tr>";
						}
						$topics.="</table>";
						echo $topics;
					}
					else{
						echo"<p id='error'>There are no topics yet</p>";
					}
				}
				else{
					echo"<a href='Forum.php'>Return to Forum Index</a>";
				}
			?>
        </div> 
        <div>
			<h1>
				<?php echo"<br><a id='create' href='create_topic.php?cid=".$cid."'>Click here to create a topic</a>";?></h1></div>
      </header>
   </body>
</html>