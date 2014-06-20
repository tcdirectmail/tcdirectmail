<?php
   
if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Mailer'])) $TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Mailer'] = 'TYPO3 CMS - tcdirectmail extension';
if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Precedence'])) $TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Precedence'] = 'bulk';
if (!isset($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Provided-by'])) $TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['extraMailHeaders']['X-Sponsored-by'] = 'http://www.casalogic.dk/ - Open Source Experts.';

/** * Registering class to scheduler
*/
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_tcdirectmail_scheduler'] = array(
	'extension' => $_EXTKEY,
	'title' => 'TcDirectMail task',
	'description' => 'This task invokes tcdirectmail in order to process queued messages.',
);

/**
 * Register click eID events
 */
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['click'] = 'EXT:' . $_EXTKEY . '/eid/click.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['tclick'] = 'EXT:' . $_EXTKEY . '/eid/tclick.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['beenthere'] = 'EXT:' . $_EXTKEY . '/eid/beenthere.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['preview'] = 'EXT:' . $_EXTKEY . '/eid/preview.php';

