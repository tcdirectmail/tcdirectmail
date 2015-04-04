<?php

class Tx_Tcdirectmail_Controller_ModuleController extends t3lib_SCbase {
   	var $pageinfo;

		/**
 		 *
 		 */
		protected function getIconPath() {
				return $GLOBALS['BACK_PATH'].'gfx/';
		}

   	/**
     * 
     */
	public function init()   {
      	global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
				$LANG->includeLLFile("EXT:tcdirectmail/Lang/locallang.xlf");

      	parent::init();

      /*
      if (t3lib_div::_GP("clear_all_cache"))   {
         $this->include_once[]=PATH_t3lib."class.t3lib_tcemain.php";
      }
       */
      	$TYPO3_DB = $GLOBALS['TYPO3_DB'];

   	}

   	/**
     * Adds items to the ->MOD_MENU array. Used for the function menu selector.
     */
	public function menuConfig()   {
      	global $LANG, $MODULE_PARTS;

      	$this->MOD_MENU = Array (
         		"function" => Array (
            		"status" => $LANG->getLL("status"),
            		'statistics' => $LANG->getLL('statistics'),
            		'maintanence' => $LANG->getLL('maintenance'),
            		'validity' => $LANG->getLL('validity'),
            		'preview' => $LANG->getLL('preview'),
								//	    'help' => $LANG->getLL('help'),
         		)
      	);

      	parent::menuConfig();

   	}

    // If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
   	/**
     * Main function of the module. Write the content to $this->content
     */
	public function main() {
      	global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

      	// Access check!
      	// The page will show only if there is a valid page and if this page may be viewed by the user
      	$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
      	$access = is_array($this->pageinfo) ? 1 : 0;

      	if (($this->id && $access) || ($BE_USER->user["admin"] && !$this->id))   {

            // Draw the header.
         		$this->doc = t3lib_div::makeInstance("bigDoc");
         		$this->doc->backPath = $BACK_PATH;
         		$this->doc->form='<form name="tcdirectmailform" action="" method="POST">';

            // JavaScript
         		$this->doc->JScode = '
            		<script language="javascript" type="text/javascript">
script_ended = 0;
function jumpToUrl(URL)   {
    document.location = URL;
        }
			  function checkAll(elementName){
						var boolValue = elementName.checked;
     				for (var i=0;i<document.tcdirectmailform.elements.length;i++){
				        var e = document.tcdirectmailform.elements[i];
       					if (e.name != elementName.name)
         						e.checked = boolValue;
     		}
   			}
            </script>
         ';
         $this->doc->postCode='
<script language="javascript" type="text/javascript">
script_ended = 1;
if (top.fsMod) top.fsMod.recentIds["web"] = '.intval($this->id).';
</script>
         ';

         $headerSection = $this->doc->getHeader("pages",$this->pageinfo,$this->pageinfo["_thePath"])."<br>".$LANG->sL("LLL:EXT:lang/locallang_core.php:labels.path").": ".t3lib_div::fixed_lgd_cs($this->pageinfo["_thePath"],-50);

         // Filter out functions defined as disallowed in the user-ts.
         if (is_array($GLOBALS['BE_USER']->userTS['tcdirectmail.']['modfuncDisallow.'])) {         
            foreach ($GLOBALS['BE_USER']->userTS['tcdirectmail.']['modfuncDisallow.'] as $func => $disallowed) {
              if ($disallowed) {
                 if ($func == $this->MOD_SETTINGS['function']) {
                    die ("Access denied");
                }  
                unset($this->MOD_MENU['function'][$func]);
              }
            }
         }

         $this->content.=$this->doc->startPage($LANG->getLL("title"));
         $this->content.=$this->doc->header($LANG->getLL("title"));
         $this->content.=$this->doc->spacer(5);
         $this->content.=$this->doc->section("",$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,"SET[function]",$this->MOD_SETTINGS["function"],$this->MOD_MENU["function"])));
         $this->content.=$this->doc->divider(5);

         // Render content:
         $this->moduleContent();


         // ShortCut
         if ($BE_USER->mayMakeShortcut())   {
            $this->content.=$this->doc->spacer(20).$this->doc->section("",$this->doc->makeShortcutIcon("id",implode(",",array_keys($this->MOD_MENU)),$this->MCONF["name"]));
         }

         $this->content.=$this->doc->spacer(10);
      } else {
            // If no access or if ID == zero

         $this->doc = t3lib_div::makeInstance("mediumDoc");
         $this->doc->backPath = $BACK_PATH;

         $this->content.=$this->doc->startPage($LANG->getLL("title"));
         $this->content.=$this->doc->header($LANG->getLL("title"));
         $this->content.=$this->doc->spacer(5);
         $this->content.=$this->doc->spacer(10);
      }
   }

   /**
    * Prints out the module HTML
    */
   function printContent()   {

      $this->content.=$this->doc->endPage();
      echo $this->content;
   }

   /**
    * Generates the module content
    */
   function moduleContent()   {
      global $LANG, $TYPO3_DB;

      // Must have an id
      if (!$_REQUEST['id']) return;

      // Must be a directmail page
      $rs = $TYPO3_DB->sql_query('SELECT doktype FROM pages WHERE uid = '.intval($_REQUEST['id']));
      list($doktype) = $TYPO3_DB->sql_fetch_row($rs);

      if ($doktype != 189) {
          $content = $this->notADirectmailPage();
          $this->content.=$this->doc->section($LANG->getLL("error"),$content,0,1);
          return;
      }

      switch((string)$this->MOD_SETTINGS["function"])   {

         case 'status':
            $content = $this->viewStatus();
            $this->content.=$this->doc->section($LANG->getLL("status"),$content,0,1);
         break;

         case 'maintanence':
            $content = $this->doMaintenance();
            $this->content.=$this->doc->section($LANG->getLL("maintenance"),$content,0,1);
         break;

         case 'preview':
            $content = $this->viewPreview();
            $this->content.=$this->doc->section($LANG->getLL("preview"),$content,0,1);
         break;

         case 'validity':
            $content = $this->checkMailValidity();
            $this->content.=$this->doc->section($LANG->getLL("validity"),$content,0,1);
         break;

         case 'statistics':
            $content = $this->viewStatistics();
            $this->content.=$this->doc->section($LANG->getLL("statistics"),$content,0,1);
         break;

	 case 'help':
	 	$content = $this->showHelp();
		$this->content.=$this->doc->section($LANG->getLL("help"),$content,0,1);
		break;

         default :
            $obj = t3lib_div::makeInstance((string)$this->MOD_SETTINGS["function"]);
            $this->content.=$obj->main();
         break;

      } 
   }

   /**
    * View all sorts of stuff about the current page. 
    */
	protected function viewStatus() {
		global $TYPO3_DB;   
		global $LANG;
		global $BE_USER;


		// Schedule a send?
		if ($_REQUEST['send_now']) {
			$TYPO3_DB->sql_query("UPDATE pages SET tx_tcdirectmail_senttime = " . time() . " WHERE uid = " . intval($_REQUEST['id']));
		}

		// Schedule a test send
		if ($_REQUEST['send_test_cron']) {
			$TYPO3_DB->sql_query("UPDATE pages SET tx_tcdirectmail_dotestsend = 1 WHERE uid = " . intval($_REQUEST['id']));
		}  

		// Send a test mail
		if ($_REQUEST['send_test']) {
			tx_tcdirectmail_tools::mailForTest($this->pageinfo, $_REQUEST['test_send_receivers']);
		}

		// Invoke the mailer?
		if ($_REQUEST['invoke_mailer']) {
			$this->invokeMailer();
		}

		// Check if there is a domain-name set
		if($BE_USER->user['admin']){
			$output .= '<h3>' . $LANG->getLL('domain_name') . '</h3>';

			$domain = tx_tcdirectmail_tools::getDomainForPage($this->pageinfo);
			if ($domain) {
				$output .= '<p><img src="'.$this->getIconPath().'ok.png" />'.str_replace ('###DOMAIN###', $domain, $LANG->getLL('domain_ok')).'</p>';
			} else {
				$output .= '<p><img src="'.$this->getIconPath().'icon_fatalerror.gif" />'.$LANG->getLL('domain_notok').'</p>';
			}

			$output .= '<br />';
		}

		// Write the sender name
		$output .= '<h3>'.$LANG->getLL('sender_name').'</h3>';

		$sender = tx_tcdirectmail_tools::getSenderForPage($this->pageinfo);
		$output .= '<p>'.str_replace ('###SENDER###', $sender, $LANG->getLL('sender_for_page')).'</p>';
		$output .= '<br />';

		// Write the sender email
		$output .= '<h3>'.$LANG->getLL('sender_email').'</h3>';

		$email = tx_tcdirectmail_tools::getEmailForPage($this->pageinfo);
		$output .= '<p>'.str_replace ('###EMAIL###', $email, $LANG->getLL('email_for_page')).'</p>';
		$output .= '<br />';


		// Get starttime for lock-records
		$rs = $TYPO3_DB->exec_SELECTquery('begintime', 'tx_tcdirectmail_lock', "stoptime = 0 AND pid = $_REQUEST[id]");
		list ($begintime) = $TYPO3_DB->sql_fetch_row($rs);

		$output .= '<form>';

		// Get current time.status
		$rs = $TYPO3_DB->exec_SELECTquery('tx_tcdirectmail_senttime', 'pages', "uid = $_REQUEST[id]");
		list ($senttime) = $TYPO3_DB->sql_fetch_row($rs);

		// Real sends?
		$output .= '<h3>'.$LANG->getLL('status_real_receivers').'</h3>';
		if ($this->pageinfo['tx_tcdirectmail_real_target']) {
			$targetUids = explode(',',$this->pageinfo['tx_tcdirectmail_real_target']);
			foreach ($targetUids as $targetUid) {
				$target = tx_tcdirectmail_target::loadTarget($targetUid);
				$total_to_send += $target->getCount();
			}

			if ($begintime) {      
				$rs = $TYPO3_DB->exec_SELECTquery('COUNT(uid)',
								'tx_tcdirectmail_sentlog',
								"begintime = '$begintime' AND pid = $_REQUEST[id]");

				list ($already_sent) = $TYPO3_DB->sql_fetch_row($rs);


				$output .= '<p>'.str_replace('###STATUS###',"$already_send / $total_to_send",$LANG->getLL('currently_sending')).'</p>';
				if (tx_tcdirectmail_tools::confParam('show_invoke_mailer') && $BE_USER->user['admin']) {
					$output .= '<br />';
					$output .= '<input style="cursor:pointer;" type="submit" name="invoke_mailer" value="Invoke mailer engine" />';
				}
			} elseif ($senttime != 0) {
				$output .= '<p>'.str_replace('###TIME_TO_SEND###', strftime('%Y-%m-%d %H:%M', $senttime),
				str_replace('###NUMBERS_TO_SEND###', $total_to_send, $LANG->getLL('scheduled_info'))) .'</p>';				
				if (tx_tcdirectmail_tools::confParam('show_invoke_mailer') && $BE_USER->user['admin']) {
					$output .= '<br />';
					$output .= '<input style="cursor:pointer;" type="submit" name="invoke_mailer" value="Invoke mailer engine" />';
				}
			} else {
				$output .= '<p><strong>'.$LANG->getLL('not_scheduled').'</strong></p>';
				$output .= '<br />';
				$output .= '<p>'.$LANG->getLL('total_receivers').' : <strong>'.$total_to_send.'</strong></p>';
				$output .= '<br />';
				$output .= '<p><input onclick="return confirm(\''.$LANG->getLL('confirm_text').'\');" style="cursor:pointer;" type="submit" name="send_now" value="'.$LANG->getLL('send_now').'" /></p>';
				$output .= '</p>';
			}
		} else {
			$output .= '<p><strong>'.$LANG->getLL('no_real_receivers').'</strong></p>';
		}
		$output .= '<br />';

		// Test sends?
		$output .= '<h3>'.$LANG->getLL('status_test_receivers').'</h3>';
		if ($this->pageinfo['tx_tcdirectmail_test_target']) {
			$target = tx_tcdirectmail_target::loadTarget($this->pageinfo['tx_tcdirectmail_test_target']);

		 if ($_REQUEST['send_test']) {
				if(is_array($_REQUEST['test_send_receivers'])){
					foreach($_REQUEST['test_send_receivers'] as $key => $value){
						$receivers[] = $value;
					}
					$output .= '<p style="font-weight:700;">'.$LANG->getLL('testmail_sent').'</p>';
					$output .= '<p style="color:green; padding: 5px 0 0 0;">'.implode('<br />',$receivers).'</p>';
				}
				else{
					$output .= '<p style="color:red; padding: 5px 0 0 0; font-weight:700;">'.$LANG->getLL('no_testmail_sent').'</p>';
				}
		 }
			 else {
		    $output .= '<p style="font-weight:700;">'.$LANG->getLL('not_currently_sending').'</p>';
		 }

		 $output .= '<table cellpadding="2" cellspacing="2">';

         // List what users can be mailed
		 if($target->getCount() > 1){
			$output .= '<tr><td colspan="5">&nbsp;</td></tr>';
			$output .= '<tr><td><input type="checkbox" name="selectAll_top" onClick="checkAll(this);" /></td><td colspan="4">'.$LANG->getLL('toggleAll').'</td></tr>';
		 }
			while ($record = $target->getRecord()) {
			if (!$tbl_headers_set) {
				$output .= '<tr><td></td><td><strong>';
				$output .= implode('</strong></td><td><strong>', array_keys($record));
				$output .= '</strong></td></tr>';
				$tbl_headers_set = true;
			}

			$output .= '<tr><td>';
			$output .= '<input type="checkbox" name="test_send_receivers[]" value="'.$record['email'].'" /></td><td>';  
			$output .= implode ('</td><td>', $record);
			$output .= '</td></tr>';
		}
		$output .= '</table>';
		$output .= '<br />';

		$output .= '<p>';
		$output .= '<input onclick="return confirm(\''.$LANG->getLL('confirm_text').'\');" style="cursor:pointer;" type="submit" name="send_test" value="'.$LANG->getLL('send_test').'" />';
		//$output .= '<input onclick="return confirm(\''.$LANG->getLL('confirm_text').'\');" style="cursor:pointer;" type="submit" name="send_test_cron" value="'.$LANG->getLL('send_test_cron').'" />';

		$output .= '</p>';   
		} else {   
			$output .= '<p><strong>'.$LANG->getLL('no_test_receivers').'</strong></p>';
		}

		$output .= '</form>';

		return $output;
	}

	protected function invokeMailer() {
		global $TYPO3_DB;

		// Find out if the mail has already been spooled
		$rs = $TYPO3_DB->sql_query("SELECT COUNT(uid) FROM tx_tcdirectmail_lock  
						WHERE stoptime = 0
						AND pid = $_REQUEST[id]");

		list($already_spooled) = $TYPO3_DB->sql_fetch_row($rs);

		// If it is NOT spooled..   spool it
		if (!$already_spooled) {
			$begintime = time();
			// Lock the page
			$TYPO3_DB->exec_INSERTquery('tx_tcdirectmail_lock', 
							array('pid' => $this->pageinfo['uid'], 
									'begintime' => $begintime, 
									'stoptime' => 0));

			$lockid = $TYPO3_DB->sql_insert_id();
			tx_tcdirectmail_tools::createSpool($this->pageinfo, $begintime);

			// Unlock the page
			tx_tcdirectmail_tools::setScheduleAfterSending ($this->pageinfo);
			$TYPO3_DB->exec_UPDATEquery('tx_tcdirectmail_lock', "uid = $lockid", array('stoptime' => time()));         
		}

		// Go on and run the queue
		tx_tcdirectmail_tools::runSpoolInteractive();
	}

	protected function checkMailValidity() {
       global $LANG;
       global $TYPO3_DB;

       $warn = array();
       $fail = array();
       $note = array();

       // Get the page-contents
       $id = intval($_REQUEST['id']);
       $rs = $TYPO3_DB->exec_SELECTquery('*', 'pages', "uid = ".intval($_REQUEST[id]));
       $page = $TYPO3_DB->sql_fetch_assoc($rs); 
       $domain = tx_tcdirectmail_tools::getDomainForPage($page);
       $html_src = file_get_contents("http://$domain/index.php?id=$id&no_cache=1");

       // Any linked CSS-files
       if (strpos($html_src, '<link rel="stylesheet" type="text/css" href="')) {
          $note[] = $LANG->getLL('mail_contains_linked_styles');
       }

       // Find linked css and convert into a style-tag
       preg_match_all('|<link rel="stylesheet" type="text/css" href="([^"]+)"[^>]+>|Ui', $html_src, $urls);
       foreach ($urls[1] as $i => $url) {
           $get_url = str_replace("http://$domain/", '', $url);
					 $fileName = PATH_site.str_replace("http://$domain/", '', $url);
					 if (file_exists($fileName)) {
           $html_src = str_replace ($urls[0][$i],
                   "<style type=\"text/css\">\n<!--\n"
                   .file_get_contents(PATH_site.str_replace("http://$domain/", '', $url))
                   ."\n-->\n</style>", $html_src);
					 }
       }

       // Any javascript
       if (strpos($html_src, '<script')) {
           $fail[] = $LANG->getLL('mail_contains_javascript');
       }
       

       // Images in CSS
       if (preg_match('|background-image: url\([^\)]+\)|', $html_src) || preg_match('|list-style-image: url\([^\)]+\)|', $html_src)) {
           $fail[] = $LANG->getLL('mail_contains_css_images');
       }
       
       // CSS-classes
       if (preg_match('|<[a-z]+ [^>]*class="[^"]+"[^>]*>|', $html_src)) {
           $note[] = $LANG->getLL('mail_contains_css_classes');
       }
       
       // Positioning & element sizes in CSS
       if (preg_match_all('|<[a-z]+[^>]+style="([^"]*)"|', $html_src, $matches)) {
           
           foreach ($matches[1] as $stylepart) {
          if (strpos($stylepart, 'width') !== false) {
            $warn[] = str_replace ('###PROPERTY###','width', $LANG->getLL('mail_contains_css_some_property'));
          }

          if (strpos($stylepart, 'margin') !== false) {
            $warn[] = str_replace ('###PROPERTY###','margin', $LANG->getLL('mail_contains_css_some_property'));
          }

          if (strpos($stylepart, 'height') !== false) {
            $warn[] = str_replace ('###PROPERTY###','height', $LANG->getLL('mail_contains_css_some_property'));
          }

          if (strpos($stylepart, 'padding') !== false) {
            $warn[] = str_replace ('###PROPERTY###','padding', $LANG->getLL('mail_contains_css_some_property'));
          }

          if (strpos($stylepart, 'position') !== false) {
            $warn[] = str_replace ('###PROPERTY###','position', $LANG->getLL('mail_contains_css_some_property'));
          }
      }

      $warn = array_unique($warn);
       }

       if (count($fail)) {
      $content .= '<h4>'.$LANG->getLL('mail_contains_serious_errors').'</h4>';
      foreach ($fail as $failure) {
          $content .= '<p><img src="'.$this->getIconPath().'icon_fatalerror.gif" />'.$failure.'</p>';
      }
       } else {
      $content .= '<h4><img src="'.$this->getIconPath().'ok.png" />'.$LANG->getLL('mail_contains_no_serious_errors').'</h4>';
       }

       if (count($warn)) {
      $content .= '<h4>'.$LANG->getLL('mail_contains_warnings').'</h4>';
      foreach ($warn as $warning) {
          $content .= '<p><img src="'.$this->getIconPath().'warning.png" />'.$warning.'</p>';
      }
       } else {
      $content .= '<h4><img src="'.$this->getIconPath().'ok.png" />'.$LANG->getLL('mail_contains_no_warnings').'</h4>';
       }

       if (count($note)) {
      $content .= '<h4>'.$LANG->getLL('mail_contains_notices').'</h4>';
      foreach ($note as $notice) {
          $content .= '<p><img src="'.$this->getIconPath().'icon_note.gif" />'.$notice.'</p>';
      }
       } else {
      $content .= '<h4><img src="'.$this->getIconPath().'ok.png" />'.$LANG->getLL('mail_contains_no_notices').'</h4>';
       }


       return $content;
   }



	protected function notADirectmailPage() {
		return '<p>'.$GLOBALS['LANG']->getLL('not_a_directmail').'</p>';
	}

	protected function doMaintenance () {
       global $LANG;
       global $TYPO3_DB;

       $id = intval($_REQUEST['id']);

       // Clear invalid stats?
       if ($_REQUEST['clear_invalid']) {
          $sql = "DELETE FROM tx_tcdirectmail_sentlog WHERE begintime = 0 AND pid = $id";
          $TYPO3_DB->sql_query($sql);
          $sql = "DELETE FROM tx_tcdirectmail_lock WHERE (begintime = 0 OR stoptime = 0) AND pid = $id";
          $TYPO3_DB->sql_query($sql);
       }

       if ($_REQUEST['delete_begintime']) {
         $sql = "DELETE tx_tcdirectmail_lock, tx_tcdirectmail_sentlog, tx_tcdirectmail_clicklinks FROM tx_tcdirectmail_lock
                 LEFT JOIN tx_tcdirectmail_sentlog ON tx_tcdirectmail_lock.begintime = tx_tcdirectmail_sentlog.begintime
                 LEFT JOIN tx_tcdirectmail_clicklinks ON tx_tcdirectmail_sentlog.uid = tx_tcdirectmail_clicklinks.sentlog
                 WHERE tx_tcdirectmail_lock.pid = $id
                 AND tx_tcdirectmail_lock.begintime = ".intval($_REQUEST[delete_begintime]);
          $TYPO3_DB->sql_query($sql);         
       }


       // Invalid-stats form
       $out .= "<form action=\"" . t3lib_BEfunc::getModuleUrl('web_txtcdirectmailM1', array('id' => $_REQUEST['id'])) ."\">";
       $sql = "SELECT uid FROM tx_tcdirectmail_sentlog WHERE begintime = 0 AND pid = $id LIMIT 1";

       $rs = $TYPO3_DB->sql_query($sql);
       $invalid_log = $TYPO3_DB->sql_fetch_row($rs);

       $sql = "SELECT uid FROM tx_tcdirectmail_lock WHERE (begintime = 0 OR stoptime = 0) AND pid = $id LIMIT 1";
       $rs = $TYPO3_DB->sql_query($sql);
       $invalid_lock = $TYPO3_DB->sql_fetch_row($rs);

       $out .= '<p><h3>'.$LANG->getLL('stats_status').'</h3></p>';
       if ($invalid_lock || $invalid_log) {
          $out .= '<p>'.$LANG->getLL('invalid_stats_found').'</p>';
          $out .= '<p><input type="submit" name="clear_invalid" value="'.$LANG->getLL('clear_invalid').'" /></p>';
       } else {
          $out .= '<p>'.$LANG->getLL('stats_ok').'</p>';
       }


       // Old-stats form
       // Get numbers for each session
       $sql = "SELECT lck.begintime, lck.stoptime, COUNT(lg.receiver)
          FROM tx_tcdirectmail_lock lck
          LEFT JOIN tx_tcdirectmail_sentlog lg ON lck.begintime = lg.begintime
          WHERE lck.pid = $id
          AND lg.pid = $id
          GROUP BY 1,2";

       $rs = $TYPO3_DB->sql_query($sql);


       // Display 
       $out .= '<p><h3>'.$LANG->getLL('delete_old_stats').'</h3></p>';
       $out .= '<table>';
       $out .= '<tr><td></td><td>'.
       $LANG->getLL('date').'</td><td>'.
       $LANG->getLL('fromtime').'</td><td>'.
       $LANG->getLL('totime').'</td><td>'.
       $LANG->getLL('total_receivers').'</td></tr>';

       while (list($begintime, $stoptime, $num_receivers) = $TYPO3_DB->sql_fetch_row($rs)) {
          $out .= "<tr style=\"background-color: eeeeee;\">
                <td><a href=\"" . t3lib_BEfunc::getModuleUrl('web_txtcdirectmailM1', array('id' => $id, 'delete_begintime' => $begintime)) ."\"><strong>".
                $LANG->getLL('delete')."</strong></td><td>".
                strftime('%Y-%m-%d',$begintime)."</td>
                <td>".strftime('%H:%M',$begintime).'</td><td>'.strftime('%H:%M',$stoptime)."</td>
                <td align=right>".$num_receivers."</td></tr>";
       }
       $out .= '</table>';
       $out .= '</form>';

       return $out;
   }

        // View number of mails delivered in the past 
	protected function viewPreview() {
            global $TYPO3_DB;
            global $LANG;
	    global $BACK_PATH;

	    // Get list of receivers 
	    $rs = $TYPO3_DB->exec_SELECTquery('*', 'pages', "uid = $_REQUEST[id]");
	    $page = $TYPO3_DB->sql_fetch_assoc($rs);

	    $mailer = tx_tcdirectmail_tools::getConfiguredMailer($page);
	    $targets = array_filter(explode(',',$page['tx_tcdirectmail_real_target']));

	    $out .= '<table>';
	    $out .= '<tr>';
	    $out .= '<td><b>'.$LANG->getLL('receiver').'</b></td>';
	    $out .= '<td><b>'.$LANG->getLL('status').'</b></td>';
	    $out .= '<td><b>'.$LANG->getLL('num_fields').'</b></td>';
	    $out .= '<td><b>'.$LANG->getLL('missing_fields').'</b></td>';
	    $out .= '<td><b>'.$LANG->getLL('preview').'</b></td>';
	    $out .= '</tr>';


	    foreach ($targets as $tid) {
		$tobj = tx_tcdirectmail_target::loadTarget($tid);

		$out .= '<tr><td colspan="5"><b>'.$this->editTarget($tid).'</b></td></tr>';

		while ($record = $tobj->getRecord()) {
		    $out .= '<tr>';		
		    $out .= "<td><a href=\"mailto:$record[email]\">$record[email]</td>";


		    // Number of fields 
		    $num_fields = count($record);

		    // Number of unsubstituted fields 
		    $mailer->substituteMarkers($record);
		    preg_match_all('|###[a-z0-9_]+###|i', $mailer->html, $nonfields_html);
		    preg_match_all('|###[a-z0-9_]+###|i', $mailer->plain, $nonfields_plain);
		    $num_nonfields = max (count ($nonfields_html[0]), count ($nonfields_plain[0]));


		    // Ok fields icon? 
		    $status_url = $GLOBALS['BACK_PATH'].'gfx';
		    if ($num_nonfields != 0) {
			$out .= '<td><img src="'.$GLOBALS['BACK_PATH'].'gfx/icon_fatalerror.gif" /></td>';
		    } else {
			$out .= '<td><img src="'.$GLOBALS['BACK_PATH'].'gfx/ok.png" /></td>';
		    }

		    $out .= "<td>$num_fields</td>";
		    $out .= "<td>$num_nonfields</td>";
		    $out .= '<td>';

		    if (!$record['plain_only']) {
			$out .= $this->previewLink('html', $record['email']);
		    } else {
			$out .= $GLOBALS['LANG']->getLL('preview_html');
		    }

		    $out .= '&nbsp;'.$this->previewLink('plain', $record['email']).'</td>';
		    $out .= "</tr>\n";

		}
		$mailer->resetMarkers();
	    }

	    $out .= '</table>';

	    return $out;
	}

	protected function previewLink($type, $email) {
	    return '<a target="_new" href="/index.php?eID=preview&email='.rawurlencode($email).'&type='.$type.'&uid='.$_REQUEST['id'].'">'.
            $GLOBALS['LANG']->getLL("preview_$type").'</a>';
	}

	protected function editTarget($uid) {
	    global $TYPO3_DB;
	    global $BACK_PATH;

	    $rs = $TYPO3_DB->exec_SELECTquery('title', 'tx_tcdirectmail_targets', "uid = $uid");
	    list($title) = $TYPO3_DB->sql_fetch_row($rs);

	    $out .= '<a href="'.$BACK_PATH.'alt_doc.php?returnUrl='.rawurlencode(t3lib_div::getIndpEnv("REQUEST_URI"));
	    $out .= '&edit[tx_tcdirectmail_targets]['.$uid.']=edit">';
	    $out .= '<img src="'.$BACK_PATH.'gfx/edit2.gif" />';
	    $out .= '<img src="'.$BACK_PATH.t3lib_extMgm::extRelPath('tcdirectmail').'mailtargets.gif" />';
	    $out .= "$title ($uid)";

	    return $out;
	}   


        // View number of mails delivered in the past 
	protected function viewStatistics() {
		global $TYPO3_DB;
		global $LANG;

		// Check if the page is a directmail 
		$sql = "SELECT doktype FROM pages WHERE uid = $_REQUEST[id]";
		$rs = $TYPO3_DB->sql_query($sql);
		list ($doktype) = $TYPO3_DB->sql_fetch_row($rs);

		// Is a detailed view requested? 
		if ($_REQUEST['detail_begintime']) {
			return $this->viewStatsDetailSum($_REQUEST['detail_begintime']);
		}

		// Get numbers for each session 
		$sql = "SELECT lck.begintime, lck.stoptime, COUNT(lg.receiver) 
				FROM tx_tcdirectmail_lock lck 
				LEFT JOIN tx_tcdirectmail_sentlog lg ON lck.begintime = lg.begintime 
				WHERE lck.pid = $_REQUEST[id] 
				AND lg.pid = $_REQUEST[id] 
				GROUP BY 1,2";

		$rs = $TYPO3_DB->sql_query($sql);

		// Display 
		$output .= '<table>';
		$output .= '<tr><td>'.
		$LANG->getLL('date').'</td><td>'.
		$LANG->getLL('fromtime').'</td><td>'.
		$LANG->getLL('totime').'</td><td>'.
		$LANG->getLL('total_receivers').'</td></tr>';

		while (list($begintime, $stoptime, $num_receivers) = $TYPO3_DB->sql_fetch_row($rs)) {
			$output .= "<tr style=\"background-color: eeeeee;\"> 
                                    <td><a href=\"" . t3lib_BEfunc::getModuleUrl('web_txtcdirectmailM1', array('id' => $_REQUEST['id'], 'detail_begintime' => $begintime)) . "\"><strong>".
                                    strftime('%Y-%m-%d',$begintime)."</strong></a></td> 
                                    <td>".strftime('%H:%M',$begintime).'</td><td>'.strftime('%H:%M',$stoptime)."</td> 
                                    <td align=right>".$num_receivers."</td></tr>";
		}
		$output .= '</table>';

		return $output;
	}

	protected function showHelp() {
		return "No help yet";
	}


	protected function viewStatsDetailSum() {
		global $TYPO3_DB;
		global $LANG;

		if ($_REQUEST['sword']) {
			$receiver_option .= " AND receiver LIKE '%$_REQUEST[sword]%' ";
		}

		//****************************************
		//***** Save stats as receiver target ****
		//****************************************

		// if ($_REQUEST['save_stats']) {
		//  $this->saveCurrentStatsAsTarget();
		//}


		//********************
		//*** Filter  form ***
		//********************

		// total activated links 
		$sql = "SELECT linktype, linkid, SUM(opened)
			FROM tx_tcdirectmail_sentlog 
			INNER JOIN tx_tcdirectmail_clicklinks ON sentlog = uid 
			WHERE begintime = $_REQUEST[detail_begintime] 
			AND pid = $_REQUEST[id]
			GROUP BY 1,2
			ORDER BY 1,2";

		$rs = $TYPO3_DB->sql_query($sql);

		// Filter form 
		$out .= '<form action="' . t3lib_BEfunc::getModuleUrl('web_txtcdirectmailM1') . '" method="POST">';
		$out .= '<input type="hidden" name="detail_begintime" value="'.$_REQUEST['detail_begintime'].'" />';
		$out .= '<input type="hidden" name="id" value="'.$_REQUEST['id'].'" />';
		$out .= '<table>';
		$out .= '<tr><td colspan="2"><h3>'.$LANG->getLL('filter_form').'</h3></td></tr>';
		$out .= '<tr style="background-color: eeeeee;"><td>'.$LANG->getLL('has_email_sword')
			.':</td><td><input type="text" name="sword" value="'.$_REQUEST['sword'].'" /></td>';
		$out .= '<tr style="background-color: eeeeee;"><td>'.$LANG->getLL('beenthere')
			.':</td><td><select name="beenthere"><option></option>';

		$out .= '<option value="yes"'.(($_REQUEST['beenthere'] == 'yes')?' selected':'').'>'.$LANG->getLL('beenthere_yes').'</option>';
		$out .= '<option value="no"'.(($_REQUEST['beenthere'] == 'no')?' selected':'').'>'.$LANG->getLL('beenthere_no').'</option>';

		$out .= '</select></td></tr>';          
		$out .= '<tr style="background-color: eeeeee;"><td>'.$LANG->getLL('has_opened_link')
			.':</td><td><select name="opened_link"><option></option>';

		while (list($type, $linkid, $in_use) = $TYPO3_DB->sql_fetch_row($rs)) {
			if ($in_use) {
				$out .= "<option value=\"$type|$linkid\"";
				if ($_REQUEST['opened_link'] == "$type|$linkid") {            
					$out .= ' selected';
				}

				$out .= ">$type #$linkid</option>";
			}
		}

		$out .= '</select></td></tr>';
		$out .= '<tr style="background-color: eeeeee;"><td colspan="2"><input type="submit" value="'.$LANG->getLL('update_view').'" /></td></tr>';
		$out .= '</table>';
		$out .= '</form>';



		//*********************
		//** General success **
		//*********************

		$out .= '<table>';
		$out .= '<tr><td colspan="3"><h3>'.$LANG->getLL('mail_success').'</h3></td></tr>';

		// If a specific link is requested 
		if ($_REQUEST['opened_link']) {
			list($linktype, $linkid) = explode('|', $_REQUEST['opened_link']);
			$sql = "SELECT COUNT(uid) 
				FROM tx_tcdirectmail_sentlog 
				INNER JOIN tx_tcdirectmail_clicklinks ON uid = sentlog
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND pid = $_REQUEST[id]
				AND beenthere = 1
				AND linktype = '$linktype'
				AND linkid = $linkid
				AND opened = 1";

			$rs = $TYPO3_DB->sql_query($sql);
			list($total_receivers) = $TYPO3_DB->sql_fetch_row($rs);        
			$out .= '<tr style="background-color: eeeeee;"><td>'
					.$LANG->getLL('total_receivers').'</td><td align="right" colspan="2"><b>'.$total_receivers.'</b></td></tr>';                      

			// Or just confirmed addresses in general 
		} elseif ($_REQUEST['beenthere'] == 'yes') {
			$sql = "SELECT COUNT(uid)
				FROM tx_tcdirectmail_sentlog 
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND beenthere = 1
				AND pid = $_REQUEST[id]";

			$rs = $TYPO3_DB->sql_query($sql);
			list($total_receivers) = $TYPO3_DB->sql_fetch_row($rs);        
			$out .= '<tr style="background-color: eeeeee;"><td>'
					.$LANG->getLL('total_receivers').'</td><td align="right" colspan="2"><b>'.$total_receivers.'</b></td></tr>';             

			// Or unconfirmed addresses 
		} elseif ($_REQUEST['beenthere'] == 'no') {
			// Get total numbers of recients 
			$sql = "SELECT COUNT(uid) 
			FROM tx_tcdirectmail_sentlog 
			WHERE begintime = $_REQUEST[detail_begintime] 
			$receiver_option
			AND pid = $_REQUEST[id]";

			$rs = $TYPO3_DB->sql_query($sql);
			list($total_receivers) = $TYPO3_DB->sql_fetch_row($rs);

			// Count opened emails 
			$sql = "SELECT COUNT(uid) 
				FROM tx_tcdirectmail_sentlog 
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND beenthere = 0
				AND pid = $_REQUEST[id]";

			$rs = $TYPO3_DB->sql_query($sql);
			list ($sumnotbeenthere) = $TYPO3_DB->sql_fetch_row($rs);
			$out .= '<tr style="background-color: eeeeee;"><td>'
				.$LANG->getLL('numbers_not_spied_upon').'</td><td align="right">'
				.$this->viewSums($sumnotbeenthere,$total_receivers).'</td></tr>';

			// Count bounced emails 
			$sql = "SELECT SUM(bounced) 
				FROM tx_tcdirectmail_sentlog 
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND pid = $_REQUEST[id]";

			$rs = $TYPO3_DB->sql_query($sql);
			list ($sumbounced) = $TYPO3_DB->sql_fetch_row($rs);
			$out .= '<tr style="background-color: eeeeee;"><td>'
				.$LANG->getLL('numbers_bounced').'</td><td align="right">'
				.$this->viewSums($sumbounced,$total_receivers).'</td></tr>';
			// Or everyone 
		} else  {
			// Get total numbers of recients 
			$sql = "SELECT COUNT(uid) 
				FROM tx_tcdirectmail_sentlog 
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND pid = $_REQUEST[id]";

			$rs = $TYPO3_DB->sql_query($sql);
			list($total_receivers) = $TYPO3_DB->sql_fetch_row($rs);

			// Count opened emails 
			$sql = "SELECT SUM(beenthere) 
				FROM tx_tcdirectmail_sentlog 
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND beenthere = 1
				AND pid = $_REQUEST[id]";




			$rs = $TYPO3_DB->sql_query($sql);
			list ($sumbeenthere) = $TYPO3_DB->sql_fetch_row($rs);
			$out .= '<tr style="background-color: eeeeee;"><td>'
				.$LANG->getLL('numbers_spied_upon').'</td><td align="right">'
				.$this->viewSums($sumbeenthere,$total_receivers).'</td></tr>';

			// Count bounced emails 
			$sql = "SELECT SUM(bounced) 
				FROM tx_tcdirectmail_sentlog 
				WHERE begintime = $_REQUEST[detail_begintime] 
				$receiver_option
				AND pid = $_REQUEST[id]";

			$rs = $TYPO3_DB->sql_query($sql);
			list ($sumbounced) = $TYPO3_DB->sql_fetch_row($rs);
			$out .= '<tr style="background-color: eeeeee;"><td>'
				.$LANG->getLL('numbers_bounced').'</td><td align="right">'
				.$this->viewSums($sumbounced,$total_receivers).'</td></tr>';
		}          

		$out .= '</table>';


          //************************
          //**** Counting links ****
          //************************

          if ($_REQUEST['beenthere'] <> 'no') {
             $out .= '<table>';

             if ($_REQUEST['opened_link']) {
               $sql = "SELECT otherlinks.linkid, SUM(otherlinks.opened), MIN(otherlinks.url) 
                       FROM tx_tcdirectmail_sentlog 
                       INNER JOIN tx_tcdirectmail_clicklinks thelink ON thelink.sentlog = uid 
                       INNER JOIN tx_tcdirectmail_clicklinks otherlinks ON otherlinks.sentlog = uid 
                       WHERE begintime = $_REQUEST[detail_begintime] 
                       $receiver_option
                       AND otherlinks.linktype = '###TYPE###' 
                       AND otherlinks.opened = 1
                       AND thelink.linktype = '$linktype'
                       AND thelink.linkid = $linkid
                       AND thelink.opened = 1
                       GROUP BY 1 
                       ORDER BY 1";
             } else {
               $sql = "SELECT linkid, SUM(opened), MIN(url) 
                       FROM tx_tcdirectmail_sentlog 
                       INNER JOIN tx_tcdirectmail_clicklinks ON sentlog = uid 
                       WHERE begintime = $_REQUEST[detail_begintime] 
                       $receiver_option
                       AND linktype = '###TYPE###' 
                       AND opened = 1
                       GROUP BY 1 
                       ORDER BY 1";
             }

             $opened_options .= "<option></option>";
             // Get all links for the sessions 
             foreach (array('html','plain') as $type) {
               $out .= '<tr><td colspan="4"><h3>'.$LANG->getLL($type.'_links').'</h3></td></tr>';
               $out .= '<tr style="background-color: eeeeee;"><td><b>'.
                       $LANG->getLL('link_number').'</b></td><td colspan="2"><b>'.
                       $LANG->getLL('numbers_of_times_opened').'</b></td><td><b>'.
                       $LANG->getLL('url').'</b></td></tr>';


               $rs = $TYPO3_DB->sql_query(str_replace('###TYPE###', $type, $sql));
               while (list($linkid, $sum_opened, $url) = $TYPO3_DB->sql_fetch_row($rs)) {            
                 $out .= "<tr style=\"background-color: eeeeee;\"> 
                   <td>#$linkid</td> 
                   <td align='right'>".$this->viewSums($sum_opened, $total_receivers)."</td> 
                   <td><a href=\"$url\" target=\"_blank\">$url</a></td> 
                 </tr>";
               }
             }
          }

          $out .= '</table>';

          return $out;
        }


	protected function viewSums ($sum, $total) {
          if ($total < 1) {
              return "</td><td align=\"right\"><b>$sum</b>";
          } else {
              return '<b>'.number_format ($sum / $total * 100, 2)."%</b></td><td align=\"right\"> $sum/$total";
          }
        }	
}


