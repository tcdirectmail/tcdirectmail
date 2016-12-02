<?php
/**
 * This is the click link script that identifies and registers the user, and provides the correct link
 */

$eidTools = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Utility\\EidUtility');
$eidTools->connectDB();

$click =  \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tcdirectmail\\Tcdirectmail\\Click');
$click->click();

