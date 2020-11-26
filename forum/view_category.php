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
<head></head>

<body>
	<?php
		include_once('../config.php');
		$id = $_GET['id'];
		if (isset($_SESSION['id'])){
			$log = " | <a href='create_topic.php?id=".$id.">Click here to create a new topic<a>";
		}
		else{
			$log = "Please login to create a topic";
		}
		$sql = "SELECT id FROM categories WHERE id='".$id."' LIMIT 1";
		$res = mysqli_query($link, $sql);
		if (mysqli_num_rows($res) == 1){
			$sql2 = "SELECT * FROM topics WHERE category_id='".$id."' ORDER BY topic_reply_date DESC";
			$res2 = mysqli_connect($link, $sql2);
			if(mysqli_num_rows($res2) >0) {
				$topic .= "<table width='100%' style='border-collapse:collapse;'>";
				$topic .= "<tr><td colspan='3'><a href='index.php'>Return to Forum Index</a>".$log."<hr></td></tr>";
				$topic .= "<tr style='background-color: #dddddd;'><td>Topic Title</td><td width='65' align='center'>Replies</td><td width='65' align='center'>Views</td></tr>";
				$topic .= "<tr><td colspan='3'><hr></td><tr>";
				while($row = mysqli_fetch_assoc($res2)){
					$tid = $row['id'];
					$title = $row['topic_title'];
					$views = $row['topic_views'];
					$date = $row['topic_date'];
					$creator = $row['topic_creator'];
					$topic .= "<tr><td><a href='view_topic.php?id=".$id."&tid=".$tid."'>".$title."</a><br><span class='post_info'> Posted by:".$creator/" on ".$date."</span></td><td align='center'>".$views."</td></tr>";
					$topic .= "<tr><td colspan='3'><hr></td></tr>";
				}
				$topic .="</table>";
			}
			else{
				echo"<a href='index.php'> Return to Home</a><hr>";
				echo "Topic not found";
			}
		}
		else{
			echo"<a href='index.php'> Return to Home</a><hr>";
			echo "Category not found";
		}
	?>
</body>