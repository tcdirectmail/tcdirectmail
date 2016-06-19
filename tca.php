<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

$TCA["tx_tcdirectmail_targets"] = Array (
    "ctrl" => $TCA["tx_tcdirectmail_targets"]["ctrl"],
    "interface" => Array (
        "showRecordFieldList" => "hidden,title"
    ),
    "feInterface" => $TCA["tx_tcdirectmail_targets"]["feInterface"],
    "columns" => Array (
        "hidden" => Array (
            "exclude" => 1,
            "label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
            "config" => Array (
                "type" => "check",
                "default" => "0"
            )
        ),
        "title" => Array (

            "label" => "LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.title",
            "config" => Array (
                "type" => "input",
                "size" => "30",
            )
        ),

        "plain_only" => Array (
            "exclude" => 1,
            "label" => "LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.plain_only",
            "config" => Array (
                "type" => "check",
                "default" => "0"
            )
        ),

	'lang' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:lang/locallang_tca.php:sys_language',
	    'config' => Array (
                "type" => "select",
		"foreign_table" => "sys_language",
		"foreign_table_where" => "ORDER BY sys_language.uid",
		"size" => 1,
		"minitems" => 0,
		"maxitems" => 1,
		"items" => array(
			'0' => array('',-1),
			'1' => array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
		),
	    ),
	),

	'beusers' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.beusers',
	    'config' => Array (
                "type" => "select",
		"foreign_table" => "be_users",
		"foreign_table_where" => "ORDER BY be_users.uid",
		"size" => 5,
		"minitems" => 0,
		"maxitems" => 100,
	    ),
	),

	'fegroups' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.fegroups',
	    'config' => Array (
                "type" => "group",
		"internal_type" => "db",
		"allowed" => "fe_groups",
		"size" => 5,
		"minitems" => 0,
		"maxitems" => 100,
	    ),
	),

	'fepages' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.fepages',
	    'config' => Array (
                "type" => "group",
		"internal_type" => "db",
		"allowed" => "pages",
		"size" => 5,
		"minitems" => 0,
		"maxitems" => 100,
	    ),
	),


	'ttaddress' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.ttaddress',
	    'config' => Array (
                "type" => "group",
		"internal_type" => "db",
		"allowed" => "pages",
		"size" => 5,
		"minitems" => 0,
		"maxitems" => 100,
	    ),
	),


	'rawsql' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.rawsql',
	    'config' => Array (
		'type' => 'text',
		'cols' => '50',
		'rows' => '10',
	    ),
		'displayCond' => 'HIDE_FOR_NON_ADMINS',
	),

	'csvseparator' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.sepchar',
	    'config' => Array(
		'type' => 'input',
		'size' => 1,
	    ),
	),

	'csvfields' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.csvfields',
	    'config' => Array(
		'type' => 'input',
		'size' => 20,
	    ),
	),

	'csvvalues' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.csvdata',
	    'config' => Array(
		'type' => 'text',
		'cols' => 40,
		'rows' => 10,
	    ),
	),

	'csvfilename' => Array (
	    'exclude' => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.csvfile',
	    'config' => Array(
                "type" => "group",
		"internal_type" => "file",
		"allowed" => "txt,csv",
		"max_size" => 500,
		"uploadfolder" => "uploads/tx_tcdirectmail",
		"size" => 1,
		"minitems" => 0,
		"maxitems" => 1,
	    ),
	),


	'csvurl' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.csvurl',
            'config' => Array(
                'type' => 'input',
                'size' => 20,
            ),

	),


	"targettype" => Array (
	    "exclude" => 1,
	    'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.type',
	    "config" => array(
		'type' => 'select',
		'items' => array(
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optbeusers', 'tx_tcdirectmail_target_beusers'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optfegroups', 'tx_tcdirectmail_target_fegroups'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optfepages', 'tx_tcdirectmail_target_fepages'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optttaddress', 'tx_tcdirectmail_target_ttaddress'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optrawsql', 'tx_tcdirectmail_target_rawsql'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optcsvfile', 'tx_tcdirectmail_target_csvfile'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optcsvlist', 'tx_tcdirectmail_target_csvlist'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optcsvurl', 'tx_tcdirectmail_target_csvurl'),
		    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.opthtml', 'tx_tcdirectmail_target_html'),
		    ),
		'size' => 1,
		'maxitems' => 1,
	    ),
	),

	'htmlfile' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.htmlurl',
            'config' => Array(
                'type' => 'input',
                'size' => 20,
            ),

	),

	'htmlfetchtype' => Array (
            "exclude" => 1,
            'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.htmlfetch',
            "config" => array(
                'type' => 'select',
                'items' => array(
                    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optmailto', 'mailto'),
                    array('LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.optregex', 'regex'),
                    ),
                'size' => 1,
                'maxitems' => 1,
            ),
	),


        "calculated_receivers" => array (
            'label' => 'LLL:EXT:tcdirectmail/Lang/locallang_db.xlf:tx_tcdirectmail_targets.actual_receivers',
            'config' => array (
                'type' => 'user',
                'userFunc' => 'user_showreceivers',
            ),
        ),
    ),
    "types" => Array (
         "0" => Array("showitem" => "hidden;;1;;1-1-1, title, targettype"),
         'tx_tcdirectmail_target_beusers' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, lang, targettype, beusers, ;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_fegroups' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, lang, targettype, fegroups,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_fepages' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, lang, targettype, fepages,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_ttaddress' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, lang, targettype, ttaddress,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_rawsql' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, targettype, rawsql,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_csvfile' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, targettype, csvseparator, csvfields, csvfilename,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_csvlist' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, targettype, csvseparator, csvfields, csvvalues,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_csvurl' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, targettype, csvseparator, csvfields, csvurl,;;;;2-2-2, calculated_receivers'),
         'tx_tcdirectmail_target_html' => Array('showitem' => 'hidden;;1;;1-1-1, title, plain_only, lang, targettype, htmlfile, htmlfetchtype,;;;;2-2-2, calculated_receivers'),
    ),
    "palettes" => Array (
         "1" => Array("showitem" => ""),
    )
);


if (!function_exists('user_displayfieldtitle')) {
	function user_displayfieldtitle ($fieldname) {
		$fieldname = htmlspecialchars(strip_tags($fieldname));

		switch ($fieldname) {
			case 'email':
			case 'plain_only':
			case 'authCode':
			case 'uid':
			case 'tableName':
			case 'L':
				return '<strong style="color: green;">' . $fieldname . '</strong>';

			default:
				if (preg_match ('/_[0-9]+$/', $fieldname)) {
					return '<strong style="color: red;">' . $fieldname . '</strong>';
				} else {
					return "<strong>" . $fieldname . "</strong>";
				}
		}
	}
}

if (!function_exists('user_showreceivers')) {
	function user_showreceivers($PA, $fObj) {
		global $TYPO3_DB;

		if (intval($PA['row']['uid']) == 0) {
			return "";
		}

		$uid = $PA['row']['uid'];

		$target = tx_tcdirectmail_target::loadTarget($uid);

		if ($target->getError()) {
			return "Error";
		}

		$numRows = 0;
		$numFields = 0;
		$out = '';
		while ($row = $target->getRecord()) {

			// At the first row, print out the headers
			if ($numRows == 0) {
				$out .= '<thead>';
				$out .= '<tr>';

				foreach (array_keys($row) as $fieldname) {
					$numFields++;
					$out .= '<th>' . user_displayfieldtitle($fieldname) . '</th>';
				}

				$out .= '</tr>';
				$out .= '</thead>';
				$out .= '<tbody>';
			}

			// Show the row in a nice way
			$out .= '<tr>';
			foreach ($row as $field) {
				$out .= '<td>' . htmlspecialchars(strip_tags($field)) . '</td>';
			}
			$out .= '</tr>';

			// If we reach 30 rows, break. We dont want to show more.
			if ($numRows == 30) {
				$out .= '<tr><td colspan="' . $numFields . '"><strong>...</strong></td></tr>';
				break;
			}

			$numRows++;
		}

		$out .= '<tr><td colspan="' . $numFields . '"><strong>' . $target->getCount() . '&nbsp;Total</strong>';
		$out .= '</tbody>';

		return '<div style="height: 240px; width:430px; overflow: scroll; background-color: white;"><table>' . $out . '</table></div>';
	}
}

if (!function_exists('user_showalreadymailed')) {
	function user_showalreadymailed($PA, $fObj) {
		$target = tx_tcdirectmail_target::getTarget($PA['row']['uid']);
		list($description, $sql) = unserialize($this->fields['alreadymailed']);
		return '<div style="height: 120px; width:430px; overflow: scroll; background-color: white;"><p>' . htmlspecialchars($description) . '</p></div>';
	}
}
