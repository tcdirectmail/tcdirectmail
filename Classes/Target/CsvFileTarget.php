<?php

namespace Tcdirectmail\Tcdirectmail\Target;

class CsvFileTarget extends AbstractArrayTarget {
    function init() {
		$this->data = array();
		if ($this->fields['csvfilename'] && $this->fields['csvseparator'] && $this->fields['csvfields']) {
			$csvdata = t3lib_div::getURL(PATH_site.'uploads/tx_tcdirectmail/'.$this->fields['csvfilename']);
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

