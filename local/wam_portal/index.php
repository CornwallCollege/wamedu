<!DOCTYPE html>
<html>
	<head>
		<title>Test login</title>
	</head>
	<body>
	<?php
	require_once("../../config.php");
	require_once("$CFG->libdir/moodlelib.php");
	$moodleRoot = $CFG->wwwroot;
	$username = required_param("Username", PARAM_TEXT);
	$expiry = required_param("Expiry", PARAM_TEXT);
	$token = required_param("Token", PARAM_ALPHANUM);
	$returnURL = required_param("ReturnURL", PARAM_SAFEPATH);
	
	$config = get_config('local_wam_portal');
	$key = $config->secretkey;
	
	$returnURL = urldecode($returnURL);
	if (strpos($returnURL, "/") === 0) {
		$returnURL = substr($returnURL, 1);
	}
	function tokenIsValid($username, $expiry, $token, $key) {
		return hash('sha256', $username . $expiry . $key) == $token;
	}
	
	if ($username == null || $expiry == null || $token == null) {
		echo "Missing Parameter";
		var_dump($_POST);
		die();
	}
	if (tokenIsValid($username, $expiry, $token, $key)) {
		
		$user = $DB->get_record('user', array('username'=>$username));
		if ($user) {
			complete_user_login($user);
			$serverName = $_SERVER['SERVER_NAME'];
			$returnURL = "$moodleRoot/$returnURL";
			header("Location: $returnURL");
			die();
		} else {
			echo "Unable to retrieve User Details<br>$username";
			die();
		}
	} else {
		echo "Authentication Unsuccessful";
		die();
	}
	?>
		<form method="post">
			<input type="text" name="username" />
			<input type="submit" value="Login" />
		</form>
	</body>
</html>