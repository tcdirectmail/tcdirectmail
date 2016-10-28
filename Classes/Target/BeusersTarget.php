<?php

namespace Tcdirectmail\Tcdirectmail\Target;

class BeusersTarget extends AbstractGentleSqlTarget {
	var $tableName = 'be_users';

	function init() {
		$config = explode(',',$this->fields['beusers']);
		$config[] = -1;
		$config = array_filter($config);

		$this->data = $GLOBALS['TYPO3_DB']->sql_query(
			"SELECT uid,email,realName,username,lang,admin FROM be_users
				WHERE uid IN (".implode(',',$config).")
				AND email <> ''
				AND disable = 0
				AND tx_tcdirectmail_bounce < 10");
	}
}
