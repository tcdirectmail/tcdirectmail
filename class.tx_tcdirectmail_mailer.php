<?php
/*************************************************************** 
*  Copyright notice 
* 
*  (c) 2007-2014 Daniel Schledermann <daniel@schledermann.net>
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

require_once(PATH_typo3 . 'contrib/swiftmailer/swift_required.php');

/**
 * This is the holy inner core of tcdirectmail. 
 * It is normally used in an instance per language to compile MIME 1.0 compatible mails
 */
class tx_tcdirectmail_mailer {
	/* Vars that might need to be overridden */
	var $senderName = "Test Testermann";
	var $senderEmail = "test@test.net";
	var $bounceAddress = 'bounce@test.test';
	var $siteUrl = "http://www.test.test/";

	/**
	 * Constructor that set up basic internal datastructures. Do not call directly
	 *
	 */
	public function __construct() {
		global $TYPO3_CONF_VARS;
    
		/* Determine the supposed hostname */
		if( ini_get('safe_mode') || TYPO3_OS == 'WIN'){
			$this->hostname = $_SERVER['HTTP_HOST'];
		} else {
			$this->hostname = trim(exec('hostname'));
		}
        
		/* Read some basic settings */
		$this->extConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['tcdirectmail']);
		$this->realPath = PATH_site;
		$this->inlinefiles = array();
		$this->files = array();
		$this->mimes = array();      
	      
		/* Set up mail replacement hooks */
		if (is_array($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['mailReplacementHook'])) {
			foreach ($TYPO3_CONF_VARS['EXTCONF']['tcdirectmail']['mailReplacementHook'] as $_classRef) {
				$this->mailReplacers[] = & t3lib_div::getUserObj($_classRef);
			}
		}
	}

	/**
	 * Determine the charset encoding of the mail.
	 *
	 * @internal
	 * @return   string      Determined charset encoding
	 */
	public function getCharsetEncoding() {
		// Do the code come with anything?
		if (preg_match ('|<meta http-equiv="Content-Type" content="text/html; charset=([^"]*)" />|', $this->html_tpl, $match)) {
			return $match[1];
		}
		// If nothing is found, we assume UTF-8
		else {
			return 'UTF-8';
		}
	}

	/**
	 * Set the title text of the mail
	 *
	 * @param   string      The title
	 * @return   void
	 */
	public function setTitle($src) {
		/* Detect what markers we need to substitute later on */
		preg_match_all ('/###[\w]+###/', $src, $fields);
		$this->titleMarkers = str_replace ('###', '', $fields[0]);

		/* Any advanced markers we need to sustitute later on */
		$this->titleAdvancedMarkers = array();
		preg_match_all ('/###:IF: (\w+) ###/U', $src, $fields);
		foreach ($fields[1] as $field) {
			$this->titleAdvancedMarkers[] = $field;
		}

		$this->title_tpl = $src;
		$this->title = $src;
	}

	/**
	 * Set the plain text content on the mail
	 *
	 * @param   string      The plain text content of the mail
	 * @return   void
	 */
	public function setPlain ($src) {
		/* Remove html-comments */
		$src = preg_replace('/<!--.*-->/U', '', $src);
      
		/* Detect what markers we need to substitute later on */
		preg_match_all ('/###[\w]+###/', $src, $fields);
		$this->plainMarkers = str_replace ('###', '', $fields[0]);
      
		/* Any advanced markers we need to sustitute later on */
		$this->plainAdvancedMarkers = array();
		preg_match_all ('/###:IF: (\w+) ###/U', $src, $fields);
		foreach ($fields[1] as $field) {
			$this->plainAdvancedMarkers[] = $field;
		}

		$this->plain_tpl = $src;
		$this->plain = $src;
	}
    
	/**
     * Set the html content on the mail
	 *
	 * @param   string      The html content of the mail
	 * @return   void
	 */    
	public function setHtml ($src) {
		/* Find linked css and convert into a style-tag */
		preg_match_all('|<link rel="stylesheet" type="text/css" href="([^"]+)"[^>]+>|Ui', $src, $urls);
		foreach ($urls[1] as $i => $url) {
				$urlParts = parse_url($url);
				$get_url = $urlParts['path'];
			$src = str_replace ($urls[0][$i], 
				"<style type=\"text/css\">\n<!--\n"
				.t3lib_div::getURL($this->realPath.$get_url)
				."\n-->\n</style>", $src);
		}

		// We cant very well have attached javascript in a newsmail ... removing
		$src = preg_replace('|<script type="text/javascript" src="[^"]+"></script>|', '', $src);

		// Convert external file resouces to attached filer or correct their links
		$replace_regs = array(
			'/ src="([^"]+)"/',
			'/ background="([^"]+)"/',
		);

		// Attach
		if ($this->extConf['attach_images']) {
			foreach ($replace_regs as $replace_reg) {
				preg_match_all($replace_reg, $src, $urls);
				foreach ($urls[1] as $i => $url) {
					if (preg_match("|^https?://|", $url)) {
						$this->inlinefiles[$url] = Swift_Image::fromPath($url);
					}
					elseif (preg_match("|^//|", $url)) {
						$this->inlinefiles[$url] = Swift_Image::fromPath("http:" . $url);
					}
					else {
						$this->inlinefiles[$url] = Swift_Image::fromPath($this->realPath . preg_replace('/\?.+$/', '', $url));
					}
				}
			}
		}

		// Or correct link
		else {
			foreach ($replace_regs as $replace_reg) {
				preg_match_all($replace_reg, $src, $urls);
				foreach ($urls[1] as $i => $url) {
					if (!preg_match('|^http://|', $url)) {
						$src = str_replace ($urls[0][$i], str_replace($url, $this->siteUrl.$url, $urls[0][$i]), $src);
					}
				}
			}
		}   

		/* Fix relative links */
		preg_match_all ('|<a [^>]*href="(.*)"|Ui', $src, $urls);
		foreach ($urls[1] as $i => $url) {
			header("X-Url-$i: $url");
			/* If this is already a absolute link, dont replace it */
			if (!preg_match('|^https?://|', $url) && !preg_match('|^mailto:|', $url) && !preg_match('|^#|', $url)) {
				$replace_url = str_replace($url, $this->siteUrl.$url, $urls[0][$i]);
				$src = str_replace ($urls[0][$i], $replace_url, $src);
			}
		}
      
		/* Detect what markers we need to substitute later on */
		preg_match_all ('/###[\w]+###/', $src, $fields);
		$this->htmlMarkers = str_replace ('###', '', $fields[0]);
      
		/* Any advanced IF fields we need to sustitute later on */
		$this->htmlAdvancedMarkers = array();
		preg_match_all ('/###:IF: (\w+) ###/U', $src, $fields);
		foreach ($fields[1] as $field) {
			$this->htmlAdvancedMarkers[] = $field;
		}

		$this->html_tpl = $src;
		$this->html = $src;
		$this->charset = $this->getCharsetEncoding();
	}
    
	/** 
	 * Tell the caller what markers are required by the mailers content
	 *
	 * @return   array   Array with the fields from html, plain and title.
	 */
	public function getMarkers() {
		return array_unique(array_merge($this->htmlAdvancedMarkers,
				$this->plainAdvancedMarkers,
				$this->titleAdvancedMarkers,
				$this->htmlMarkers,
				$this->plainMarkers,
				$this->titleMarkers));
	}
   
	/**
	 * Insert a "mail-open-spy" in the mail for test.
	 *
	 * @return   void
	 */
	public function testSpy () {
		$this->html = str_replace (
					'</body>', 
					'<div><img src="'.$this->siteUrl.'typo3/clear.gif" width="0" height="0" /></div></body>', 
					$this->html);
	}
    
	/**
	 * Insert a "mail-open-spy" in the mail for real. This relies on the $this->authcode being set.
	 *
	 * @return   void
	 */
	public function insertSpy($authCode, $sendid) {
		$this->html = str_replace (
				'</body>', 
				'<div><img src="'.$this->siteUrl.'index.php?eID=beenthere&c='.$authCode.'&s='.$sendid.'" width="0" height="0" /></div></body>',
				$this->html);
	}
    
	/**
	 * Reset all modifications to the content.
	 *
	 * @return   void
	 */
	public function resetMarkers() {
		$this->html  = $this->html_tpl;
		$this->plain = $this->plain_tpl;
		$this->title = $this->title_tpl;
	}
    
	/**
	 * Replace a named marker with a suppied value. 
	 * A marker can have the form of a simple string marker ###marker###
	 * Or a advanced boolean marker ###:IF: marker ### ..content.. (###:ELSE:###)? ..content.. ###:ENDIF:###
	 *
	 * @param   string      Name of the marker to replace
	 * @param   string      Value to replace marker with.
	 * @return   void
	 */
	public function substituteMarker($name, $value) {
		/* For each marker, only substitute if the field is registered as a marker. This approach has shown to 
		 speed up things quite a bit.  */

		$value = strip_tags($value);

		if (in_array($name, $this->htmlAdvancedMarkers)) {
			$this->html = tx_tcdirectmail_mailer::advancedSubstituteMarker($this->html, $name, htmlspecialchars($value));
		}

		if (in_array($name, $this->plainAdvancedMarkers)) {
			$this->plain = tx_tcdirectmail_mailer::advancedSubstituteMarker($this->plain, $name, $value);
		}

		if (in_array($name, $this->titleAdvancedMarkers)) {
			$this->title = tx_tcdirectmail_mailer::advancedSubstituteMarker($this->title, $name, $value);
		}

		if (in_array($name, $this->htmlMarkers)) {
			$this->html  = str_replace("###$name###", htmlspecialchars($value), $this->html);
		}

		if (in_array($name, $this->plainMarkers)) {
			$this->plain = str_replace("###$name###", $value, $this->plain);
		}

		if (in_array($name, $this->titleMarkers)) {
			$this->title = str_replace("###$name###", $value, $this->title);
		}
	}

	/**
	 * Substitute an advanced marker.
	 *
	 * @internal
	 * @param   string      Source to apply marker substitution to.
	 * @param   string      Name of marker.
	 * @param   boolean      Display value of marker.
	 * @return   string      Source with applied marker.
	 */
	public function advancedSubstituteMarker ($src, $name, $value) {
		preg_match_all("/###:IF: $name ###([\w\W]*)###:ELSE:###([\w\W]*)###:ENDIF:###/U", $src, $matches);
		foreach ($matches[0] as $i => $full_mark) {
			if ($value) {
				$src = str_replace($full_mark, $matches[1][$i], $src);
			} else {
				$src = str_replace($full_mark, $matches[2][$i], $src);
			}
		}

		preg_match_all("/###:IF: $name ###([\w\W]*)###:ENDIF:###/U", $src, $matches);
		foreach ($matches[0] as $i => $full_mark) {
			if ($value) {
				$src = str_replace($full_mark, $matches[1][$i], $src);
			} else {
				$src = str_replace($full_mark, '', $src);
			}
		}

		return $src;
	}

	/**
	 * Apply multiple markers to mail contents
	 *
	 * @param   array      Assoc array with name => value pairs.
	 * @return   void
	 */
	public function substituteMarkers ($record) {
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tcdirectmail']['substituteMarkersHook'])) {
			foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tcdirectmail']['substituteMarkersHook'] as $_classRef) {
				$_procObj = & t3lib_div::getUserObj($_classRef);
				$this->html = $_procObj->substituteMarkersHook($this->html, 'html', $record);
				$this->plain = $_procObj->substituteMarkersHook($this->plain, 'plain', $record);
				$this->title = $_procObj->substituteMarkersHook($this->title, 'title', $record);
			}
		}      
      
		foreach ($record as $name => $value) {
			$this->substituteMarker($name, $value);
		}
	}
    
	/**
	 * Replace all links in the mail to make spy links.
	 *
	 * @param    string     Encryption code for the links
	 * @return   array      Data structure with original links.
	 */
	public function makeClickLinks ($authCode, $sendid) {
		$links['plain'] = array();
		$links['html'] = array();

		// Exchange all http:// links  html 
		preg_match_all ('|<a [^>]*href="(http://[^"]*)"|Ui', $this->html, $urls);

		foreach ($urls[1] as $i => $url) {
			$links['html'][$i] = html_entity_decode($url);
			  
			// Two step replace to be as precise as possible
			$link = str_replace($url, $this->siteUrl."index.php?eID=click&l=$i&t=html&c=$authCode&s=$sendid", $urls[0][$i]);
			$this->html  = str_replace($urls[0][$i], $link, $this->html);
		}

		// Exchange all http:// links plaintext
		preg_match_all ('|http://[^ \r\n\)]*|i', $this->plain, $urls);
		foreach ($urls[0] as $i => $url) {
			$links['plain'][$i] = html_entity_decode($url);
			$this->plain = str_replace($url, $this->siteUrl."index.php?eID=click&l=$i&t=plain&c=$authCode&s=$sendid", $this->plain);
		}

		return $links;   
	}

	/**
	 * Replace all links in the mail to make test spy links.
	 * This will create links similar to the real spy links, but does not require any database activity in order to work, 
	 * and does not reveal any information of the receiver.
	 *
	 * @return   void
	 */
	public function testClickLinks () {
		/* Exchange all http:// links  html */
		preg_match_all ('|<a [^>]*href="(http://[^"]*)"|Ui', $this->html, $urls);
		foreach ($urls[1] as $i => $url) {
			$link = str_replace($url, $this->siteUrl."index.php?eID=tclick&l=".base64_encode(html_entity_decode($url)), $urls[0][$i]);
			$this->html  = str_replace($urls[0][$i], $link, $this->html);
		}

		/* Exchange all http:// links plaintext */
		preg_match_all ('|http://[^ \n\r\)]*|i', $this->plain, $urls);
		foreach ($urls[0] as $i => $url) {   
			$this->plain = str_replace($url, $this->siteUrl."index.php?eID=tclick&l=".base64_encode($url),$this->plain);
		}
	}
	    
	/**
	 * The regular send method. Use this to send a normal personalized mail.
	 *
	 * @param   array      Record with receivers information as name => value pairs.
	 * @param   array      Array with extra headers to apply to mails as name => value pairs.
	 * @return   void
	 */
	public function send ($receiverRecord, $extraHeaders = array()) {
		$this->substituteMarkers($receiverRecord);   
		$this->raw_send($receiverRecord, $extraHeaders);
		$this->resetMarkers();   
	}

	/**
	 * Raw send method. This does not replace markers, or reset the mail afterwards.
	 *
	 * @interal
	 * @param   array      Record with receivers information as name => value pairs.
	 * @param   array      Array with extra headers to apply to mails as name => value pairs.
	 * @return   void
	 */
	public function raw_send($receiverRecord, $extraHeaders = array()) {
		$messageId = md5(microtime().$receiverRecord['email']).'@'.$this->hostname;
		$charset = $GLOBALS['TSFE']->metaCharset?$GLOBALS['TSFE']->metaCharset:'utf-8';

		// Hook for actions INSTEAD of actually sending the mail
		if (is_array($this->mailReplacers)) {
			foreach($this->mailReplacers as $_procObj) {
				$_procObj->mailReplacementHook($receiverRecord['email'], $title, implode("\n", $body), implode("\n", $headers), $this->bounceAddress);
			}
    }
		// Mail it
		else {

      $mail = t3lib_div::makeInstance('t3lib_mail_Message');

      // Get the inline images
      foreach ($this->inlinefiles as $filename => $embedObj) {
				$this->html = str_replace($filename, $mail->embed($embedObj), $this->html);
      }

			// Get the attached files
			foreach ($this->files as $attachObj) {
				$mail->attach($attachObj);
			}

      $mail->setTo(array($receiverRecord['email']))
        ->setFrom(array($this->senderEmail => $this->senderName))
        ->setSender($this->bounceAddress?$this->bounceAddress:$this->senderEmail)
        ->setId($messageId)
        ->setSubject($this->title)
        ->addPart($this->plain, 'text/plain')
        ->setBody($this->html, 'text/html')
        ->setCharset($charset);

      $mail->send();
      $success = $mail->isSent();
    }
	}

	public function addAttachment($filename) {
		$this->files[] = Swift_Attachment::fromPath($filename);
	}
}
