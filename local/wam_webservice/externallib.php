<?php

/**
 * External Web Service Template
 *
 * @package    wamwebservice
 * @copyright  2014 WAM Education
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");
require_once($CFG->libdir ."/moodlelib.php");
require_once("../../config.php");

class local_wamwebservice_external extends external_api {

	/**
     * Returns description of method parameters
     * @return external_function_parameters
     */
	 public static function local_wam_auth_parameters() {
		return new external_function_parameters(
			array
			(
				'username' => new external_value(PARAM_TEXT, 'The username to check'),
				'password' => new external_value(PARAM_TEXT, 'The password to check')
			)
		);
	 }
	 
	 /**
     * Returns description of method result value
     * @return external_description
     */
	 public static function local_wam_auth_returns() {
		return new external_value(PARAM_BOOL, 'A boolean value indicating whether login was successful');
	 }
	 
	 public static function local_wam_auth($username, $password) {
		
		$user = authenticate_user_login($username, $password);
		if ($user) {
			return true;
		} else {
			return false;
		}
	 }
	 
	 public static function local_wam_get_user_by_login_parameters() {
		return new external_function_parameters(
			array
			(
				'username' => new external_value(PARAM_TEXT, 'The username to check'),
				'password' => new external_value(PARAM_TEXT, 'The password to check')
			)
		);
	 }
	 
	 public static function local_wam_get_user_by_login_returns() {
		return new external_single_structure(
			array(
				'firstname' => new external_value(PARAM_TEXT, 'User\'s first name', VALUE_OPTIONAL),
				'lastname' => new external_value(PARAM_TEXT, 'User\'s last name', VALUE_OPTIONAL),
				'username' => new external_value(PARAM_TEXT, 'User\'s username', VALUE_OPTIONAL),
				'fullname' => new external_value(PARAM_TEXT, 'User\'s full name', VALUE_OPTIONAL),
				'email' => new external_value(PARAM_EMAIL, 'User\'s email address', VALUE_OPTIONAL),
				'description' => new external_value(PARAM_TEXT, 'User\'s description', VALUE_OPTIONAL)
			)
		);
	 }
	 
	public static function local_wam_get_user_by_login($username, $password) {
		$user = authenticate_user_login($username, $password);
		return $user;
	}
	
	public static function local_wam_get_user_by_token_parameters() {
		return new external_function_parameters(
			array
			(
				'username' => new external_value(PARAM_TEXT, 'The username to check', VALUE_REQUIRED),
				'token' => new external_value(PARAM_ALPHANUM, 'The token to check', VALUE_REQUIRED),
				'expiry' => new external_value(PARAM_TEXT, 'The token expiry date', VALUE_REQUIRED)
			)
		);
	 }
	 
	 public static function local_wam_get_user_by_token_returns() {
		return new external_single_structure(
			array(
				'firstname' => new external_value(PARAM_TEXT, 'User\'s first name', VALUE_OPTIONAL),
				'lastname' => new external_value(PARAM_TEXT, 'User\'s last name', VALUE_OPTIONAL),
				'username' => new external_value(PARAM_TEXT, 'User\'s username', VALUE_OPTIONAL),
				'fullname' => new external_value(PARAM_TEXT, 'User\'s full name', VALUE_OPTIONAL),
				'email' => new external_value(PARAM_EMAIL, 'User\'s email address', VALUE_OPTIONAL),
				'description' => new external_value(PARAM_TEXT, 'User\'s description', VALUE_OPTIONAL)
			)
		);
	 }
	 
	public static function local_wam_get_user_by_token($username, $token, $expiry) {
		$user = null;
		global $DB;
		
		$config = get_config('local_wam_portal');
		$key = $config->secretkey;
		
		if (hash('sha256', $username . $expiry . $key) == $token) {
			$user = $DB->get_record('user', array('username'=>$username));
			if ($user) {
				return $user;
			} else {
				throw new invalid_parameter_exception("Unable to retrieve user details for $username");
			}
		} else {
			throw new invalid_parameter_exception("Authentication Unsuccessful");
		}
	}
}