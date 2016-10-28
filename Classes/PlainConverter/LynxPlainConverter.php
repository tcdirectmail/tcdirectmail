<?php

namespace Tcdirectmail\Tcdirectmail\PlainConverter;

class LynxPlainConverter extends AbstractPlainConverter {
	var $fetchMethod = 'url';

	function setHtml($url) {
		exec (tx_tcdirectmail_tools::confParam('path_to_lynx').' -dump "'.$url.'"', $output);
		$this->plainText = implode("\n", $output);
	}
}
