<?php
   
if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Mailer'])) {
	$TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Mailer'] = 'TYPO3 CMS - TCDirectmail extension';
}

if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Precedence'])) {
	$TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Precedence'] = 'bulk';
}

if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Provided-by'])) {
	$TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Maintained-By'] = 'TCDirectmail team: https://github.com/tcdirectmail/tcdirectmail';
}

/** 
 * Registering class to scheduler
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tcdirectmail\Tcdirectmail\\Scheduler\\MailerTask'] = array(
	'extension' => $_EXTKEY,
	'title' => 'TcDirectMail Mailer Task',
	'description' => 'This task invokes tcdirectmail in order to process queued messages.',
);

/**
 * Registering class to the cliDispatch
 */
$TYPO3_CONF_VARS['SC_OPTIONS']['GLOBAL']['cliKeys']['bounce_mail'] = array(
    'EXT:'.$_EXTKEY.'/cli/bounce_mail.php','_CLI_tcdirectmail',
    'extension' => $_EXTKEY
);

/**
 * Register click eID events
 */
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['click'] = 'EXT:' . $_EXTKEY . '/eid/click.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['tclick'] = 'EXT:' . $_EXTKEY . '/eid/tclick.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['beenthere'] = 'EXT:' . $_EXTKEY . '/eid/beenthere.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['preview'] = 'EXT:' . $_EXTKEY . '/eid/preview.php';

