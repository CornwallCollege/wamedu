<?php
	$capabilities = array(
		'block/wam_login:addinstance' => array(
			'captype' => 'write',
			'contextlevel' => CONTEXT_BLOCK,
			'archetypes' => array (
				'manager' => CAP_ALLOW
			),
			'clonepermissionsfrom' => 'moodle/site:manageblocks'
		)
		
		
	);
