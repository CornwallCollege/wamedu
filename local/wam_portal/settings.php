<?php

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
	$settings = new admin_settingpage('local_wam_portal', 'Wam Portal');
	$ADMIN->add('localplugins', $settings);
	
	$settings->add(new admin_setting_configtext('local_wam_portal/secretkey', get_string('secretkey', 'local_wam_portal'),
		get_string('secretkeydesc', 'local_wam_portal'), '', PARAM_TEXT));
}