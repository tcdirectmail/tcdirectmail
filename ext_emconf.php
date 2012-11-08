<?php

########################################################################
# Extension Manager/Repository config file for ext "tcdirectmail".
#
# Auto generated 08-11-2012 11:24
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TC Directmail',
	'description' => 'Directmail extension with simple to setup and use mailer, and a very extensible recipient configuration.',
	'category' => 'module',
	'shy' => 0,
	'version' => '2.0.2',
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
	'author' => 'Daniel Schledermann',
	'author_email' => 'info@tcdirectmail.dk',
	'author_company' => 'Casalogic A/S',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:58:{s:17:"bounceaccount.gif";s:4:"4ef5";s:39:"class.tx_tcdirectmail_bouncehandler.php";s:4:"5a71";s:32:"class.tx_tcdirectmail_mailer.php";s:4:"f619";s:31:"class.tx_tcdirectmail_plain.php";s:4:"0276";s:41:"class.tx_tcdirectmail_plain_html2text.php";s:4:"4f36";s:36:"class.tx_tcdirectmail_plain_lynx.php";s:4:"a562";s:38:"class.tx_tcdirectmail_plain_simple.php";s:4:"a5f6";s:40:"class.tx_tcdirectmail_plain_template.php";s:4:"011f";s:32:"class.tx_tcdirectmail_target.php";s:4:"6cfb";s:38:"class.tx_tcdirectmail_target_array.php";s:4:"d03d";s:40:"class.tx_tcdirectmail_target_beusers.php";s:4:"ebb7";s:40:"class.tx_tcdirectmail_target_csvfile.php";s:4:"5215";s:40:"class.tx_tcdirectmail_target_csvlist.php";s:4:"4be4";s:39:"class.tx_tcdirectmail_target_csvurl.php";s:4:"60ef";s:41:"class.tx_tcdirectmail_target_fegroups.php";s:4:"e6a9";s:40:"class.tx_tcdirectmail_target_fepages.php";s:4:"d129";s:42:"class.tx_tcdirectmail_target_gentlesql.php";s:4:"d5c5";s:37:"class.tx_tcdirectmail_target_html.php";s:4:"21e8";s:39:"class.tx_tcdirectmail_target_rawsql.php";s:4:"4801";s:36:"class.tx_tcdirectmail_target_sql.php";s:4:"88ad";s:42:"class.tx_tcdirectmail_target_ttaddress.php";s:4:"b40a";s:31:"class.tx_tcdirectmail_tools.php";s:4:"ba67";s:21:"ext_conf_template.txt";s:4:"cb96";s:12:"ext_icon.gif";s:4:"593f";s:17:"ext_localconf.php";s:4:"0882";s:14:"ext_tables.php";s:4:"d395";s:14:"ext_tables.sql";s:4:"651d";s:16:"locallang_db.xml";s:4:"bde5";s:8:"mail.gif";s:4:"593f";s:15:"mailtargets.gif";s:4:"d59a";s:11:"preview.php";s:4:"8a48";s:12:"readmail.php";s:4:"e611";s:7:"tca.php";s:4:"f9bc";s:16:"cli/bounce.phpsh";s:4:"1f01";s:14:"cli/clirun.php";s:4:"a34b";s:12:"cli/conf.php";s:4:"577e";s:22:"cli/create_spool.phpsh";s:4:"b9d3";s:16:"cli/mailer.phpsh";s:4:"18a5";s:18:"cli/readmail.phpsh";s:4:"de8b";s:19:"cli/run_spool.phpsh";s:4:"2835";s:18:"cli/run_test.phpsh";s:4:"c649";s:14:"doc/manual.sxw";s:4:"5c16";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"04ce";s:14:"mod1/index.php";s:4:"f7fb";s:18:"mod1/locallang.xml";s:4:"0e9c";s:22:"mod1/locallang_mod.xml";s:4:"cdc9";s:19:"mod1/moduleicon.gif";s:4:"af7d";s:57:"sections/class.tx_tcdirectmail_section_modulefunction.php";s:4:"28d3";s:50:"sections/class.tx_tcdirectmail_section_targets.php";s:4:"d17a";s:17:"web/beenthere.php";s:4:"cba1";s:18:"web/browserrun.php";s:4:"0a21";s:13:"web/click.php";s:4:"803b";s:12:"web/conf.php";s:4:"9c22";s:19:"web/csvdownload.php";s:4:"6a54";s:15:"web/preview.php";s:4:"ebbf";s:14:"web/tclick.php";s:4:"71e5";s:19:"web/xmldownload.php";s:4:"ee63";}',
);

?>