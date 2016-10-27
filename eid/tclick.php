<?php
/**
 * This is the test version of the click.php script
 */


$l = base64_decode($_REQUEST['l']);
$c = $_REQUEST['c'];

if (t3lib_div::stdAuthCode($l) == $c) {
	header ('Location: ' . $l);
}
else {
	header('HTTP/1.1 503 Service unavailable');
	echo "The test link was broken.";
}

