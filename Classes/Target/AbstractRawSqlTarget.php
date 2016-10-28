<?php

namespace Tcdirectmail\Tcdirectmail\Target;

class AbstractRawSqlTarget extends AbstractSqlTarget { 
	function init() {
		if ($this->fields['rawsql'] == '') {
			$sql = 'SELECT * FROM tt_address WHERE uid = -1';
		} else {
			$sql = $this->fields['rawsql'];
		}
		$this->data = $GLOBALS['TYPO3_DB']->sql_query($sql);
	}
}

