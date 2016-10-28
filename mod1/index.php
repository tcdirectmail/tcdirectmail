<?php

$SOBE = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tcdirectmail\\Tcdirectmail\\Controller\\ModuleController');
$SOBE->init();

$SOBE->main();
$SOBE->printContent();
