<?php
/**
 * This is the click link script that identifies and registers the user, and provides the correct link
 */

$eidTools = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_eidtools');
$eidTools->connectDB();

$click =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_tcdirectmail_click');
$click->click();

