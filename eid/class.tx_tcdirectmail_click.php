<?php

/**
 * Implements the click events
 */
class tx_tcdirectmail_click {
    /**
     * Read the common link params from _GET and place the escaped values on the object
     */
    protected function readParams() {
        global $TYPO3_DB;
        $this->authCode = $TYPO3_DB->quoteStr(t3lib_div::_GET('c'));
        $this->linkType = $TYPO3_DB->quoteStr(t3lib_div::_GET('t'));
        $this->linkId = intval(t3lib_div::_GET('l'));
        $this->sendId = intval(t3lib_div::_GET('s'));
    }

    /**
     * Register a common link
     */
    public function click() {
        $this->readParams();
        global $TYPO3_DB;

        $where_clause = "WHERE authcode = '$this->authCode' AND linkid = $this->linkId AND uid = $this->sendId AND linktype = '$this->linkType'";

        // Register this link 
        $TYPO3_DB->sql_query("UPDATE tx_tcdirectmail_clicklinks 
                       INNER JOIN tx_tcdirectmail_sentlog ON tx_tcdirectmail_clicklinks.sentlog = tx_tcdirectmail_sentlog.uid
                       SET opened = 1 $where_clause"); 
        
        // Register the user
        $TYPO3_DB->sql_query("UPDATE tx_tcdirectmail_sentlog SET beenthere = 1 WHERE authcode = '$this->authCode' AND uid = $this->sendId");


        $rs = $TYPO3_DB->sql_query("SELECT target, user_uid FROM tx_tcdirectmail_sentlog WHERE authcode = '$this->authCode' AND uid = $this->sendId");
        if (list($targetUid, $userUid) = $TYPO3_DB->sql_fetch_row($rs)) {
            $target = tx_tcdirectmail_target::getTarget($targetUid);
            $target->registerClick($userUid);
        }
        
        // Deliver the real url
        $rs = $TYPO3_DB->sql_query(
            "SELECT url FROM tx_tcdirectmail_clicklinks 
                            INNER JOIN tx_tcdirectmail_sentlog ON tx_tcdirectmail_clicklinks.sentlog = tx_tcdirectmail_sentlog.uid
                            $where_clause");
                              
        list($url) = $TYPO3_DB->sql_fetch_row($rs);
        header ("Location: $url");
    }

    /**
     * Register the mail-open flag
     */
    public function beenthere() {
        $this->readParams();
        global $TYPO3_DB;

        // Talk talk talk :)
        $TYPO3_DB->sql_query("UPDATE tx_tcdirectmail_sentlog SET beenthere = 1 WHERE authcode = '$this->authCode' AND uid = $this->sendId");
        
        $rs = $TYPO3_DB->sql_query("SELECT target, user_uid FROM tx_tcdirectmail_sentlog WHERE authcode = '$this->authCode' AND uid = $this->sendId");
        if (list($targetUid, $userUid) = $TYPO3_DB->sql_fetch_row($rs)) {
            $target = tx_tcdirectmail_target::getTarget($targetUid);
            $target->registerOpen($userUid);
        }
        
        header ('Content-type: image/gif');
        echo base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAO2lmDQ==');
    }
}

