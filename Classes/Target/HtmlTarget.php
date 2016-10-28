<?php

namespace Tcdirectmail\Tcdirectmail\Target;

class HtmlTarget extends AbstractArrayTarget {
	function init() {
		$htmlfile = $this->fields['htmlfile'];
		$htmlfetchtype = $this->fields['htmlfetchtype'];
       
		$content = \TYPO3\CMS\Core\Utility\GeneralUtility::getURL($htmlfile);
       
		if ($htmlfetchtype == 'mailto') {
			preg_match_all('|<a[^>]+href="mailto:([^"]+)"[^>]*>(.*)</a>|Ui', $content, $fetched_data);
       
			foreach ($fetched_data[1] as $i => $email) {
				$this->data[] = array('email' => $email, 'name' => $fetched_data[2][$i]);
			}
		} 
       
		if ($htmlfetchtype == 'regex') {
			preg_match_all("|[\.a-z0-9_-]+@[a-z0-9_-][\.a-z0-9_-]*\.[a-z]{2,4}|i", $content, $fetched_data);
       
			foreach ($fetched_data[0] as $address) {
				$this->data[]['email'] = $address;
			}
		}
	}
}

