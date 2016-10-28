<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006-2016 Daniel Schledermann <daniel@schledermann.net>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * This is the target's super class. 
 * All directmail targets must inherit from this class though some inheritance path.
 */

namespace Tcdirectmail\Tcdirectmail\Target;

abstract class AbstractTarget {
	var $fields;
	var $data;
   
	/**
	 * This is the object factory, without init(), for all directmail targets.
	 *
	 * @param     integer     Uid of a tx_directmail_target from the database.
	 * @return    object      Of directmail_target type.
	 */
	public static function getTarget($uid) {
		global $TYPO3_DB;

		$uid = intval($uid);
       
		$rs = $TYPO3_DB->sql_query("SELECT * FROM tx_tcdirectmail_targets WHERE uid = $uid");
		$fields = $TYPO3_DB->sql_fetch_assoc($rs);
		$object = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($fields['targettype']);
		if (is_subclass_of($object, 'tx_tcdirectmail_target')) {
			$object->fields = $fields;
			return $object;
		} else {
			die ("Ooops..   $fields[targettype] is not a tx_tcdirectmail_target child class");
		}   
	}
   
	/**
	 * This is the object factory, with init(), for all directmail targets.
	 *
	 * @param     integer     Uid of a tx_directmail_target from the database.
	 * @return    object      Of directmail_target type.
	 */
	public static function loadTarget ($uid) {
		$object = tx_tcdirectmail_target::getTarget($uid);
		$object->init();
		return $object;
	}
   
	/**
	 * This is the method called when a directmail_target is produced in the loadTarget factory
	 *
	 * @return    void
	 */
	public function init() {
        // As default I do nothing
    }


	/**
	 * Fetch one receiver record from the directmail target. 
	 * The record MUST contain an "email"-field. Without this one this mailtarget is useless.
	 * In order for registered links to work, it should also contain an "authCode"-field.
	 * To collect bounces you will need to have both fields "authCode" and "uid".
	 * For compatibility with various subscription systems, the record can contain "tableName"-field.
	 *
	 * @return   array      Assoc array with fields for the receiver
	 */
	public abstract function getRecord();

	/**
	 * Reset the directmail target, so the next record being fetched will be the first. 
	 * Not currently in use by any known extension
	 *
	 * @return   void
	 */
	public abstract function resetTarget();
   
	/**
	 * Get the number of receivers in this directmail target
	 *
	 * @return   integer      Numbers of receivers.
	 */
	public abstract function getCount();
   
	/**
	 * Get error text if the fetching of the directmail target has somehow failed.
	 *
	 * @return   string      Error text or empty string.
	 */
	public abstract function getError();
   
	/**
	 * Here you can implement start events for a real send-out.
	 * 
	 * @return    void
	 */
	public function startReal() {
	}

	/**
	 * Here you can implement end events for a real send-out.
	 * 
	 * @return    void
	 */   
	public function endReal() {
	}
	   
	/**
	 * Here you can define an action when an address bounces. This can either be database operations such a a deletion. 
	 * For external data-sources, you might consider collecting the addresses for later removal from the foreign system. 
	 * The tx_tcdirectmail_target_sql implements a sesible default. Bounces can only be expected to work if the record 
	 * contains "uid" and "authCode" fields. "tableName" should also be included for compatibility reasons.
	 * It is not mandatory to do anything, but bounce handling cannot work without it.
	 *
	 * @param   integer    Uid of the address that has failed.
	 * @param   integer    Status of the bounce expect: TCDIRECTMAIL_HARDBOUNCE or TCDIRECTMAIL_SOFTBOUNCE 
	 * @return  bool       Status of the success of the removal.
	 */
	public function disableReceiver($uid, $bounce_type) {
		return false;
	}

	/**
	 * Here you can implement some action to take when ever the user has opened the mail via beenthere.php
	 *
	 * @param	integer	Uid of the user that has opened the mail
	 * @return	void
	 */
	public function registerOpen ($uid) {
	}

	/**
	 * Here you can implement some action to take when ever the user has clicked a link via click.php
	 *
	 * @param	integer	Uid of the user that has clicked a link
	 * @return	void
	 */
	public function registerClick ($uid) {
	}
}

