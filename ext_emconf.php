<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "tcdirectmail".
 *
 * Auto generated 20-08-2014 08:19
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TC Directmail',
	'description' => 'Directmail extension with simple to setup and use mailer, and a very extensible recipient configuration.',
	'category' => 'module',
	'shy' => 0,
	'version' => '3.1.3',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1,cli,web',
	'state' => 'stable',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'pages,tt_address,be_users,fe_users',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Daniel Schledermann, Jose Antonio Guerra',
	'author_email' => 'typo3@ds.schledermann.net',
	'author_company' => 'Linkfactory A/S',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-5.5.99',
			'typo3' => '4.5.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'scheduler' => '0.0.0-',
		),
	),
	'suggests' => array(
	),
);

?>