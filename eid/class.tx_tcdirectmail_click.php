<?php

/**
 * Implements the click events
 */
class tx_tcdirectmail_click {

	/**
	 * Create a click argument.
	 * The click argument is a collecion of the original url and information
	 * about the origin mail session
	 * @param   string    $orgLink     The original URL.
	 * @param   integer   $sentLogId   Id for the sentlog record
	 * @param   integer   $linkNumber  Order of the link at it appears in the mail
	 * @param   string    $context     What context the link has: html or plain.
	 * @return  string                 Encoded click argument
	 */
	public function createClickArgument($orgLink, $sentLogId, $linkNumber, $context = 'html') {
		$context = $context == 'html'? 'h' : 'p';
		$hashString = t3lib_div::stdAuthCode($sentLogId . '|' . $linkNumber . '|' . $orgLink . '|' . $context);
		return base64_encode(gzcompress(json_encode(array(
			'l' => $orgLink,
			's' => $sentLogId,
			'n' => $linkNumber,
			'c' => $context,
			'h' => $hashString))));
	}

	public function resolveClickArgument($argument) {
		$parts = (array) json_decode(gzuncompress(base64_decode($argument)));
		$hashString = t3lib_div::stdAuthCode($parts['s'] . '|' . $parts['n'] . '|' . $parts['l'] . '|' . $parts['c']);

		if ($hashString == $parts['h']) {
			$result = array();
			$result['orgLink'] = $parts['l'];
			$result['linkNumber'] = intval($parts['n']);
			$result['sentLogId'] = intval($parts['s']);
			if ($parts['c'] == 'h') {
				$result['context'] = 'html';
			}
			else {
				$result['context'] = 'plain';
			}
			return $result;
		}
		else {
			return false;
		}
	}

	/**
	 * Register a common link
	 */
	public function click($argument) {
		global $TYPO3_DB;

		if ($data = $this->resolveClickArgument($argument)) {
			// Register the mail as open
			$TYPO3_DB->exec_UPDATEquery('tx_tcdirectmail_sentlog', 'uid = ' . $data['sentLogId'], array('beenthere' => 1));

			// Now register the link clicked
			$TYPO3_DB->exec_INSERTquery('tx_tcdirectmail_clicklinks', array('sentlog' => $data['sentLogId'],
																																			'linkid' => $data['linkNumber'],
																																			'linktype' => $data['context'],
																																			'url' => $data['orgLink']));

			// Notify the target that the user clicked
			$rs = $TYPO3_DB->exec_SELECTquery('target, user_uid', 'tx_tcdirectmail_sentlog', 'uid = ' . $data['sentLogId']);
			if (list($targetUid, $userUid) = $TYPO3_DB->sql_fetch_row($rs)) {
				$target = tx_tcdirectmail_target::getTarget($targetUid);
				$target->registerClick($userUid);
			}

			// Return the link to the user
			header("HTTP/1.1 302 Found");
			header("Location: " . $data['orgLink']);
		}
		else {
			header("HTTP/1.1 500 Internal server error");
			echo "We are very sorry, but the clicked link was invalid";
		}
	}

	public function createBeenthereArgurment($sentLogId) {
		$hashString = t3lib_div::stdAuthCode($sentLogId);
		return base64_encode(json_encode(array(
			's' => $sentLogId,
			'h' => $hashString)));

	}

	public function resolveBeenthereArgument($argument) {
		$parts = (array) json_decode(base64_decode($argument));
		$hashString = t3lib_div::stdAuthCode($parts['s']);

		if ($hashString == $parts['h']) {
			return $parts['s'];
		}
		else {
			return false;
		}
	}

	/**
	 * Register the mail-open flag
	 */
	public function beenthere($argument) {
		global $TYPO3_DB;

		// So you don't know where you're going and you wanna talk
		if ($sentLogId = $this->resolveBeenthereArgument($argument)) {

			// Register the mail as open
			$TYPO3_DB->exec_UPDATEquery('tx_tcdirectmail_sentlog', 'uid = ' . $sentLogId, array('beenthere' => 1));

			// Tell the target that the mail was opened
			$rs = $TYPO3_DB->exec_SELECTquery('target, user_uid', 'tx_tcdirectmail_sentlog', 'uid = ' . $sentLogId);
			if (list($targetUid, $userUid) = $TYPO3_DB->sql_fetch_row($rs)) {
				$target = tx_tcdirectmail_target::getTarget($targetUid);
				$target->registerOpen($userUid);
			}
		}
        
		header ('Content-type: image/gif');
		echo base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAO2lmDQ==');
	}
}

