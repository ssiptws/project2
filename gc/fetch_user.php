<?php
include('database_connection.php');
session_start();
$query = "
SELECT * FROM login 
WHERE user_id != '".$_SESSION['user_id']."' 
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$output = '
<table width="100%">
	<tr>
		<th width="70%" style="background-color:white; padding:10px">CREWMATE USERNAME</td>
		<th width="20%" style="background-color:white">STATUS</td>
		<th width="10%" style="background-color:white">ACTION</td>
	</tr>
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
	if($user_last_activity > $current_timestamp){
		$status = '<span class="label label-success">Online</span>';
	}
	else{
		$status = '<span class="label label-danger">Offline</span>';
	}
	$output .= '
	<tr>
		<td class:"universal"  style="font-size:18px; padding:15px ; color:white; font-family: "Poppins", sans-serif;" >'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</td>
		<td style="padding:20px" >'.$status.'</td>
		<td style="padding:15px ; font-family: "Poppins", sans-serif;"><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
	</tr>
	';
}

$output .= '</table>';

echo $output;

?>
<link rel="stylesheet" href="msgstyle.css"/>