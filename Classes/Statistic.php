<?php

class Tx_Tcdirectmail_Statistic {
	protected $pid = 0;
	protected $begintime = 0;
	protected $sword = '';
	protected $context = 'any';
	
	public function setPage($pid) {
		$this->pid = intval($pid);
		$this->begintime = intval($begintime);
	}

	public function setBegintime($begintime) {
		$this->begintime = intval($begintime);
	}

	public function setMustBeOpened($opened) {
		$this->opened = $opened;
	}

	public function setContext($context) {
		if ($context == 'html' || $context == 'plain' || $context == 'any') {
			$this->context = $context;
		}
		else {
			throw new Exception("Illegal context type $context");
		}
	}

	public function listSessions() {
		global $TYPO3_DB;

		$rs = $TYPO3_DB->exec_SELECTquery('lck.begintime AS begintime, lck.stoptime AS stoptime, COUNT(lg.receiver) AS num_receivers',
																			'tx_tcdirectmail_lock AS lck, tx_tcdirectmail_sentlog AS lg',
																			'lck.begintime = lg.begintime AND lck.pid = lg.pid AND lg.pid = ' . $this->pid,
																			'1,2');
	}

	public function calculateOverview() {
		global $TYPO3_DB;
		$rs = $TYPO3_DB->exec_SELECTquery("SUM(beenthere) AS opened, COUNT(uid) AS total",
																			'tx_tcdirectmail_sentlog',
																			"pid = $this->pid AND begintime = $this->begintime" . $this->getSwordConstraint());

		return $TYPO3_DB->sql_fetch_assoc($ts);
	}

	public function calculateLinkusage() {
		global $TYPO3_DB;

		// Start be figuring out what links are in use
		$rs = $TYPO3_DB->exec_SELECTquery("linkid, MIN(url) AS url, COUNT(sentlog) AS num_usage",
																			"tx_tcdirectmail_sentlog, tx_tcdirectmail_clicklinks",
																			"     uid = sentlog " .
																			" AND begintime = $this->begintime " .
																			" AND pid = $this->pid" .
																			$this->getSwordConstraint() .
																			$this->getContextConstraint(),
																			"1");

		$overall_usage = array();
		while($row = $TYPO3_DB->sql_fetch_assoc($rs)) {
			$overall_usage[$row['linkid']] = $row;
		}

		// Foreach of these links, process the usage profile
		$link_usage = array();
		foreach (array_keys($overall_usage) as $linkid) {
			$rs = $TYPO3_DB->exec_SELECTquery("otherclick.linkid AS linkid, otherclick.linktype AS linktype, MIN(otherclick.url) AS url, COUNT(sentlog) AS num_usage",
																				"tx_tcdirectmail_sentlog, tx_tcdirectmail_clicklinks, tx_tcdirectmail_clicklinks AS otherclick"
																				"     uid = tx_tcdirectmail_clicklinks.sentlog " .
																				" AND uid = otherclick.sentlog " .
																				" AND tx_tcdirectmail_clicklinks.linkid = $linkid " .
																				" AND begintime = $this->begintime " .
																				" AND pid = $this->pid " .
																				$this->getSwordConstraint() .
																				$this->getContextConstraint(),
																				"1, 2");

			$row = $TYPO3_DB->sql_fetch_assoc($rs);
			$link_usage[$row['linkid']] = $row;
		}

		return array('overall_usage' => $usage,
								 'link_usage' => $link_usage);
	}

	protected function getSwordConstraint() {
		if ($this->sword) {
			$sword = $GLOBALS['TYPO3_DB']->escapeStrForLike('tx_tcdirectmail_sentlog', $this->sword);
			return " AND tx_tcdirectmail_sentlog.receiver LIKE '%$sword%'";
		}
		else {
			return '';
		}
	}

	protected function getContextConstraint() {
		if ($this->context <> 'any') {
			return " AND linktype = '$this->context' ";
		}
		else {
			return '';
		}
	}
}

