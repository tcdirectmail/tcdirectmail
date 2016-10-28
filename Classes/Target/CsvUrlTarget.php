<?php

namespace Tcdirectmail\Tcdirectmail\Target;

class CsvUrlTarget extends AbstractArrayTarget {
    function init() {
		$this->data = array();
		if ($this->fields['csvurl'] && $this->fields['csvseparator'] && $this->fields['csvfields']) {
			$csvdata = \TYPO3\CMS\Core\Utility\GeneralUtility::getURL($this->fields['csvurl']);
			$sepchar = $this->fields['csvseparator']?$this->fields['csvseparator']:',';
			$fields = array_map ('trim', explode ($sepchar, $this->fields['csvfields']));
			$lines = explode ("\n", $csvdata);
			foreach ($lines as $line) {
				$row = array();
				$values = explode($sepchar, $line);
				foreach ($values as $i => $value) {
					$row[$fields[$i]] = trim($value);
				}
				$this->data[] = $row;
			}
		}
    }
}
