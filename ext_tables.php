<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

if (TYPO3_MODE=="BE")	{
		
	t3lib_extMgm::addModule("web","txtcdirectmailM1","before:info",t3lib_extMgm::extPath($_EXTKEY)."mod1/");
}


$tempColumns = Array (
	"tx_tcdirectmail_senttime" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_senttime",		
		"config" => Array (
			"type" => "input",
			"size" => "12",
			"max" => "20",
			"eval" => "datetime",
			"checkbox" => "0",
			"default" => "0"
		)
	),
	"tx_tcdirectmail_repeat" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat",		
		"config" => Array (
			"type" => "select",
			"items" => Array (
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.0", "0"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.1", "1"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.2", "2"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.3", "3"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.4", "4"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.5", "5"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.6", "6"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_repeat.I.7", "7"),
			),
			"size" => 1,	
			"maxitems" => 1,
		)
	),
	
	"tx_tcdirectmail_plainconvert" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_plainconvert",		
		"config" => Array (
			"type" => "select",
			"items" => Array (
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_plainconvert.I.2", "tx_tcdirectmail_plain_simple"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_plainconvert.I.0", "tx_tcdirectmail_plain_template"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_plainconvert.I.1", "tx_tcdirectmail_plain_lynx"),
				Array("LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_plainconvert.I.3", "tx_tcdirectmail_plain_html2text"),
			),
			"size" => 1,	
			"maxitems" => 1,
		)
	),
	
        "tx_tcdirectmail_attachfiles" => Array (        
                "exclude" => 1,        
	        "label" => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_attachfiles",        
        	"config" => Array (
	        	"type" => "group",
        		"internal_type" => "file",
            		"allowed" => "",    
            		"disallowed" => "php,php3",    
            		"max_size" => 500,    
            		"uploadfolder" => "uploads/tx_tcdirectmail",
           		"size" => 3,    
            		"minitems" => 0,
            		"maxitems" => 10,
        	)
    	),
    "tx_tcdirectmail_real_target" => Array (        
        "exclude" => 1,        
        "label" => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_real_target",        
        "config" => Array (
            "type" => "group",    
            "internal_type" => "db",    
            "allowed" => "tx_tcdirectmail_targets",    
            "size" => 5,    
            "minitems" => 0,
            "maxitems" => 20,
        )
    ),
    "tx_tcdirectmail_test_target" => Array (        
        "exclude" => 1,        
        "label" => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_test_target",        
        "config" => Array (
            "type" => "group",    
            "internal_type" => "db",    
            "allowed" => "tx_tcdirectmail_targets",    
            "size" => 1,    
            "minitems" => 0,
            "maxitems" => 1,
        )
    ),
    'tx_tcdirectmail_sendername' => Array (
	'exclude' => 1,
	'label' => 'LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_sendername',
	'config' => Array (
	    'type' => 'input',
	    'size' => 30,
	)
    ),
    
    'tx_tcdirectmail_senderemail' => Array (
	'exclude' => 1,
	'label' => 'LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_senderemail',
	'config' => Array (
	    'type' => 'input',
	    'size' => 30,
	)
    ),    

    'tx_tcdirectmail_bounceaccount' => Array (
       'exclude' => 1,
       'label' => 'LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_bounceaccount',
       'config' => Array (
				 'type' => 'input',
				 'size' => 30,
			 ),
    ),
    
    'tx_tcdirectmail_spy' => Array (
	'exclude' => 1,
	'label' => 'LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_spy',
	'config' => Array(
	    'type' => 'check',
	),
    ),
    
    'tx_tcdirectmail_register_clicks' => Array (
	'exclude' => 1,
	'label' => 'LLL:EXT:tcdirectmail/locallang_db.xml:pages.tx_tcdirectmail_register_clicks',
	'config' => Array(
	    'type' => 'check',
	),
    ),              
);


t3lib_div::loadTCA("pages");
t3lib_extMgm::addTCAcolumns("pages",$tempColumns,1);


global $PAGES_TYPES;
$PAGES_TYPES[189] = Array(
    "type" => "Directmail",
    "icon" => t3lib_extMgm::extRelPath('tcdirectmail')."mail.gif",
);
      

array_splice ($TCA["pages"]["columns"]["doktype"]["config"]["items"], 3, 0, array(array(  
	0 => "LLL:EXT:tcdirectmail/locallang_db.xml:pages.directmailtype",
	1 => 189,
	2 => t3lib_extMgm::extRelPath('tcdirectmail')."mail.gif"
    ))
);


t3lib_SpriteManager::addTcaTypeIcon('pages', 189, t3lib_extMgm::extRelPath('tcdirectmail')."mail.gif");
// Add the new doktype to the list of types available from the new page menu at the top of the page tree
t3lib_extMgm::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea := addToList(189)'
);


$TCA['pages']['types']['189'] = $TCA['pages']['types']['1'];
$TCA['pages']['types']['189']['showitem'] .= ',--div--;LLL:EXT:tcdirectmail/locallang_db.xml:pages.directmailtype, tx_tcdirectmail_sendername, tx_tcdirectmail_senderemail, tx_tcdirectmail_bounceaccount, tx_tcdirectmail_plainconvert, tx_tcdirectmail_spy, tx_tcdirectmail_register_clicks, tx_tcdirectmail_usebcc,;;;;4-4-4, tx_tcdirectmail_senttime, tx_tcdirectmail_repeat, tx_tcdirectmail_real_target,tx_tcdirectmail_test_target,;;;;6-6-6, tx_tcdirectmail_attachfiles';

t3lib_extMgm::allowTableOnStandardPages("tx_tcdirectmail_targets");
$TCA["tx_tcdirectmail_targets"] = Array (
    "ctrl" => Array (
        "title" => "LLL:EXT:tcdirectmail/locallang_db.xml:tx_tcdirectmail_targets",        
        "label" => "title",    
        "tstamp" => "tstamp",
        "crdate" => "crdate",
        "cruser_id" => "cruser_id",
        "default_sortby" => "ORDER BY crdate",    
        "delete" => "deleted",    
        "type" => "targettype",
        "enablecolumns" => Array (        
            "disabled" => "hidden",
        ),
        "dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
        "iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."mailtargets.gif",
    ),
    "feInterface" => Array (
        "fe_admin_fieldList" => "hidden, title",
    )
);


$tempColumns = Array (
    "tx_tcdirectmail_bounce" => Array (        
        "exclude" => 1,        
        "label" => "LLL:EXT:tcdirectmail/locallang_db.xml:fe_users.tx_tcdirectmail_bounce",        
        "config" => Array (
            "type" => "input",
            "size" => "4",
            "max" => "4",
            "eval" => "int",
            "checkbox" => "0",
            "range" => Array (
                "upper" => "100",
                "lower" => "0"
            ),
            "default" => 0
        )
    ),
);


t3lib_div::loadTCA("fe_users");
t3lib_extMgm::addTCAcolumns("fe_users",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("fe_users","tx_tcdirectmail_bounce;;;;1-1-1");

t3lib_div::loadTCA("tt_address");
t3lib_extMgm::addTCAcolumns("tt_address",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tt_address","tx_tcdirectmail_bounce;;;;1-1-1");

t3lib_div::loadTCA("be_users");
t3lib_extMgm::addTCAcolumns("be_users",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("be_users","tx_tcdirectmail_bounce;;;;1-1-1");
