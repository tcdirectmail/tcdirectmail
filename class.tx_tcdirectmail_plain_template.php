<?php

class tx_tcdirectmail_plain_template extends tx_tcdirectmail_plain {
    var $fetchMethod = 'url';
    
    function setHtml($url) {
       $this->plainText = tx_tcdirectmail_tools::getURL("$url&type=99");
    }
}

