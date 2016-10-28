<?php

/**
 * This is the basic SQL related directmail target. Methods implemented with DB calls.
 * Extend this class to create directmail targets which extracts records from the database.
 */

namespace Tcdirectmail\Tcdirectmail\Target;

class AbstractSqlTarget extends AbstractTarget {
	var $tableName = 'undefinedtable';
	
	/**
	 * Fetch a record from the sql-record set. This also computes some commonly used values, 
	 * such as authCode, plain_only and tableName.
	 *
	 * @return	array	Record with user data.
	 */
	public function getRecord() {
		$r = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($this->data);
		if (is_array($r)) {
			if (!isset($r['plain_only'])) {
				$r['plain_only'] = $this->fields['plain_only'];
			}

			if (!isset($r['L'])) {
				$r['L'] = $this->fields['lang'];
			}
      
			if ($this->tableName <> 'undefinedtable') {
				$r['tableName'] = $this->tableName;
			}
      
			if (isset($r['uid'])) {
				$r['authCode'] = \TYPO3\CMS\Core\Utility\GeneralUtility::stdAuthCode($r['uid']);
			} else {
				$r['authCode'] = \TYPO3\CMS\Core\Utility\GeneralUtility::stdAuthCode($r['email']);
			}
        
			return $r;
		} else {
			return false;
		}
	}   
   
	public function getCount() {
		return $GLOBALS['TYPO3_DB']->sql_num_rows($this->data);
	}
   
	public function resetTarget() {
		$GLOBALS['TYPO3_DB']->sql_data_seek($this->data,0);
	}
   
	public function getError() {
		return $GLOBALS['TYPO3_DB']->sql_error($this->data);
	}
	   
	/**
	 * Here you can implement database operation done when an email address has failed. 
	 * It is not mandatory to do anything, but here is a sensible default provided for database-provided receivers. 
	 * IF YOU DO NOT WANT TO DELETE YOUR RECORDS, PLEASE, PLEASE OVERRIDE THIS METHOD WITH SOMETHING MORE GENTLE. 
	 * DONT BLAME ME FOR LOST DATA. Alternatively you can inherit from the tx_tcdirectmail_target:gentlesql class
	 * instead.
	 *
	 * @param   integer    Uid of the address that has failed.
	 * @param   integer    Status of the bounce
	 * @return  bool       Status of the success of the removal.
	 */
	public function disableReceiver($uid, $bounce_type) {
		global $TYPO3_DB;
	      
		if ($this->tableName <> 'undefinedtable') {
			$TYPO3_DB->sql_query("DELETE FROM $this->tableName WHERE uid = $uid");
			return $TYPO3_DB->sql_affected_rows();
		} else {
			return false;
		}                                    
	}      
}

