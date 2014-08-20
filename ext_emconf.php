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
	'version' => '3.0.0',
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
	'_md5_values_when_last_written' => 'a:47:{s:17:"bounceaccount.gif";s:4:"4ef5";s:39:"class.tx_tcdirectmail_bouncehandler.php";s:4:"681d";s:32:"class.tx_tcdirectmail_mailer.php";s:4:"2137";s:31:"class.tx_tcdirectmail_plain.php";s:4:"9da2";s:41:"class.tx_tcdirectmail_plain_html2text.php";s:4:"b44c";s:36:"class.tx_tcdirectmail_plain_lynx.php";s:4:"03f7";s:38:"class.tx_tcdirectmail_plain_simple.php";s:4:"ee9b";s:40:"class.tx_tcdirectmail_plain_template.php";s:4:"6b64";s:35:"class.tx_tcdirectmail_scheduler.php";s:4:"dce0";s:32:"class.tx_tcdirectmail_target.php";s:4:"dad9";s:38:"class.tx_tcdirectmail_target_array.php";s:4:"bf8b";s:40:"class.tx_tcdirectmail_target_beusers.php";s:4:"fb0e";s:40:"class.tx_tcdirectmail_target_csvfile.php";s:4:"5fdd";s:40:"class.tx_tcdirectmail_target_csvlist.php";s:4:"1f56";s:39:"class.tx_tcdirectmail_target_csvurl.php";s:4:"190d";s:41:"class.tx_tcdirectmail_target_fegroups.php";s:4:"5084";s:40:"class.tx_tcdirectmail_target_fepages.php";s:4:"1562";s:42:"class.tx_tcdirectmail_target_gentlesql.php";s:4:"06d1";s:37:"class.tx_tcdirectmail_target_html.php";s:4:"c8b9";s:39:"class.tx_tcdirectmail_target_rawsql.php";s:4:"7c09";s:36:"class.tx_tcdirectmail_target_sql.php";s:4:"c018";s:42:"class.tx_tcdirectmail_target_ttaddress.php";s:4:"081a";s:31:"class.tx_tcdirectmail_tools.php";s:4:"0e62";s:16:"ext_autoload.php";s:4:"b1c1";s:21:"ext_conf_template.txt";s:4:"cb96";s:12:"ext_icon.gif";s:4:"593f";s:17:"ext_localconf.php";s:4:"ec57";s:14:"ext_tables.php";s:4:"bce6";s:14:"ext_tables.sql";s:4:"651d";s:16:"locallang_db.xml";s:4:"bde5";s:8:"mail.gif";s:4:"a248";s:15:"mailtargets.gif";s:4:"d59a";s:7:"tca.php";s:4:"0018";s:39:"Classes/Controller/ModuleController.php";s:4:"d69c";s:19:"cli/bounce_mail.php";s:4:"2b81";s:14:"doc/manual.sxw";s:4:"5c16";s:17:"eid/beenthere.php";s:4:"2f70";s:35:"eid/class.tx_tcdirectmail_click.php";s:4:"d8de";s:13:"eid/click.php";s:4:"0e3a";s:15:"eid/preview.php";s:4:"e161";s:14:"eid/tclick.php";s:4:"ae7c";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"fa3e";s:14:"mod1/index.php";s:4:"bbdc";s:18:"mod1/locallang.xml";s:4:"0e9c";s:22:"mod1/locallang_mod.xml";s:4:"cdc9";s:19:"mod1/moduleicon.gif";s:4:"af7d";}',
	'suggests' => array(
	),
);

?>