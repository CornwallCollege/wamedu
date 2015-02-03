<?php

// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Web service local plugin template external functions and service definitions.
 *
 * @package    localwstemplate
 * @copyright  2011 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We defined the web service functions to install.
$functions = array(
	'local_wam_auth' => array(
		'classname'   => 'local_wamwebservice_external',
		'methodname'  => 'local_wam_auth',
		'classpath'   => 'local/wam_webservice/externallib.php',
		'description' => 'Authenticates a user',
		'type'        => 'read',
		'capabilities'=> 'moodle/user:viewdetails'
	),
	
	'local_wam_get_user_by_login' => array(
		'classname'		=> 'local_wamwebservice_external',
		'methodname'	=> 'local_wam_get_user_by_login',
		'classpath'		=> 'local/wam_webservice/externallib.php',
		'description'	=> 'Retrieves an individual user\'s details from their username password combination',
		'type'			=> 'read',
		'capabilities'	=> 'moodle/user:viewdetails'
	),
	
	'local_wam_get_user_by_token' => array(
		'classname'		=> 'local_wamwebservice_external',
		'methodname'	=> 'local_wam_get_user_by_token',
		'classpath'		=> 'local/wam_webservice/externallib.php',
		'description'	=> 'Retrieves an individual user\'s details from a remote WAM token',
		'type'			=> 'read',
		'capabilities'	=> 'moodle/user:viewdetails'
	)
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
        'WAM Webservice' => array(
                'functions' => array ('local_wam_auth', 'core_user_get_users_by_field', 'local_wam_get_user_by_login', 'local_wam_get_user_by_token'),
                'restrictedusers' => 1,
                'enabled'=>1,
        )
);