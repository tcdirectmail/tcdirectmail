<?php

$SOBE = t3lib_div::makeInstance('Tx_Tcdirectmail_Controller_ModuleController');
$SOBE->init();

$SOBE->main();
$SOBE->printContent();
?>