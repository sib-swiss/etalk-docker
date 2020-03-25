<?php

if ($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='etalk.cc') {
	$GLOBALS['DBHost'] = 'XXXX';
	$GLOBALS['DBUser'] = 'XXXX';
	$GLOBALS['DBPass'] = 'XXXX';
}
else {
	$GLOBALS['DBHost'] = 'localhost';
	$GLOBALS['DBUser'] = 'XXXX';
	$GLOBALS['DBPass'] = 'XXXX';
}
$GLOBALS['DBName'] = 'etalk2';

define('DB_ENCODING', 'UTF8');
