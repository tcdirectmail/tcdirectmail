<?php
/**
 * This is the htmlmail-opened-ping script, that detects if a user has opened the mail
 */
 

$eidTools = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Utility\\EidUtility');
$eidTools->connectDB();

$click =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tcdirectmail\\Tcdirectmail\\Click');
$click->beenthere();

