<?php
/**
 * This is the htmlmail-opened-ping script, that detects if a user has opened the mail
 */
 
$eidTools = t3lib_div::makeInstance('tslib_eidtools');
$eidTools->connectDB();

$click =  t3lib_div::makeInstance('tx_tcdirectmail_click');
$click->beenthere(t3lib_div::_GP('a'));

