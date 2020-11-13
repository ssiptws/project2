<?php?
function get_ip(){
	$ipaddress= '';
	//whether ip is from share internet
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	}
	//whether ip is from proxy
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	//whether ip is from remote address
	else{
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	}
	return $ipaddress;
}

function login_alert($username){
	$to_email = $username;
	$ip = get_ip();
	$subject = "New Login Detected";
	$body = "Hello " .$username" We noticed a new sign-in with IP\n IP: " .$ip;
	$headers = "From: Admin";
	
	if(mail($to_email, $subject, $body, $headers)){
		console.log("success");
	}
	else{
		console.log("error");
	}
}
?>