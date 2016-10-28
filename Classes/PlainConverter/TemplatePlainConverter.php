<?php

namespace Tcdirectmail\Tcdirectmail\PlainConverter;

class TemplatePlainConverter extends AbstractPlainConverter {
    var $fetchMethod = 'url';
    
    function setHtml($url) {
		$this->plainText = tx_tcdirectmail_tools::getURL("$url&type=99");
    }
}

