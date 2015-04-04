<?php
   
if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Mailer'])) $TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-TcDirectmail'] = 'TYPO3 CMS - tcdirectmail extension - https://github.com/tcdirectmail';
if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Precedence'])) $TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Precedence'] = 'bulk';

/** 
 * Registering class to scheduler
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_tcdirectmail_scheduler'] = array(
	'extension' => $_EXTKEY,
	'title' => 'TcDirectMail task',
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

