<?php
$extensionPath = t3lib_extMgm::extPath('tcdirectmail');
return array(
	'tx_tcdirectmail_scheduler' => $extensionPath . 'class.tx_tcdirectmail_scheduler.php',
    'tx_tcdirectmail_click' => $extensionPath . 'eid/class.tx_tcdirectmail_click.php',
    'tx_tcdirectmail_tools' => $extensionPath . 'class.tx_tcdirectmail_tools.php',
);


