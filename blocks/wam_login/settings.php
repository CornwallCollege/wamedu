<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_wam_login/tokenvalidity', get_string('tokenvalidity', 'block_wam_login'),
        get_string('tokenvaliditydesc', 'block_wam_login'), 60, PARAM_INT));
	$settings->add(new admin_setting_configtext('block_wam_login/wamroot', get_string('wamroot', 'block_wam_login'),
		get_string('wamrootdesc', 'block_wam_login'), '', PARAM_TEXT));
	$settings->add(new admin_setting_configtext('block_wam_login/wamsubdomain', get_string('wamsubdomain', 'block_wam_login'),
		get_string('wamsubdomaindesc', 'block_wam_login'), '', PARAM_TEXT));
	$settings->add(new admin_setting_configtext('block_wam_login/stylesheeturl', get_string('stylesheeturl', 'block_wam_login'),
		get_string('stylesheeturldesc', 'block_wam_login'), '', PARAM_TEXT));
}