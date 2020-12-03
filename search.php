<?php

$dbhost = "localhost";
$dbname = "ssipnew";
$dbuser = "root";
$dbpass = "";

global $tutorial_db;

$tutorial_db = new mysqli();
$tutorial_db->connect($dbhost, $dbuser, $dbpass, $dbname);
$tutorial_db->set_charset("utf8");

if ($tutorial_db->connect_errno) {
	printf("Connect failed: %s\n", $tutorial_db->connect_error);
	exit();
}


$html = '';
$html .= '<div class="result">';
$html .= '<h5>Username Found:</h5>';
$html .= '<h5>nameString</h5>';
$html .= '<br>';
$html .= '</div>';

$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $tutorial_db->real_escape_string($search_string);

if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$query = 'SELECT * FROM login WHERE username LIKE "%'.$search_string.'%"';

	$result = $tutorial_db->query($query);
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}

	if (isset($result_array)) {
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
//			$display_description = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['timestamp']);
			$display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['username']);
//            $display_timestamp = $result['timestamp'];
			// Insert Name
			$output = str_replace('nameString', $display_name, $html);

			// Insert Function
//			$output = str_replace('descriptionString', $display_description, $output);
//			$output = str_replace('TimeStamp', $display_timestamp, $output);

			// Output
			echo($output);
		}
	}else{

		$output = str_replace('nameString', '<b>No Results Found.</b><br> :(', $html);
		$output = str_replace('Username Found:', '<br>Sorry', $output);

		echo($output);
	}
}



?>