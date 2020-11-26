<?php
include('database_connection.php');
session_start();
if($_POST["action"] == "insert_data"){
	$data = array(
		':to_user_id'		=>	'0',
		':from_user_id'		=>	$_SESSION["user_id"],
		':chat_message'		=>	$_POST['chat_message'],
		':status'			=>	'1'
	);

	$query = "
	INSERT INTO chat_message 
	(to_user_id, from_user_id, chat_message, status) 
	VALUES (:to_user_id, :from_user_id, :chat_message, :status)
	";

	$statement = $connect->prepare($query);

	if($statement->execute($data)){
		echo fetch_group_chat_history($connect);
	}
}

if($_POST["action"] == "fetch_data"){
	echo fetch_group_chat_history($connect);
}

?>