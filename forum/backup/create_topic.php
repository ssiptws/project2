<?php
	session_start();
	
	if(!isset($_SESSION["uid"])) || ($_GET['cid']){
		header("location: index.php");
		exit;
	}
	$cid = $_GET['cid']
?>
<head>
 <title>
	Create Forum Topic
 </title>
</head>

<body>
<div id="wrapper">
	<?php
		echo "<p> you are logged in as ".$_SESSION['username']." &bull; <a href='../logout.php'>Logout</a>";
	?>
	<hr/>
	<div id="content">
		<form action="create_topic_parse.php" method="post">
		<p>Topic Title</p>
		<input type="text" name="topic_title" maxlength="150"/>
		<p>Topic Content</p>
		<input type="text" name="cid" value="<?php echo $cid;?>"/>
	</div>
	</div>
</body>