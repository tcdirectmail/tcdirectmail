<?php
/**
 * This is the htmlmail-opened-ping script, that detects if a user has opened the mail
 */
 

$eidTools = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_eidtools');
$eidTools->connectDB();

$click =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_tcdirectmail_click');
$click->beenthere();

