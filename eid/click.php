<?php
/**
 * This is the click link script that identifies and registers the user, and provides the correct link
 */

$eidTools = t3lib_div::makeInstance('tslib_eidtools');
$eidTools->connectDB();

$click =  t3lib_div::makeInstance('tx_tcdirectmail_click');
$click->click(t3lib_div::_GP('a'));

