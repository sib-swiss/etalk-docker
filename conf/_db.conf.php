<?php

if ($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='etalk.cc') {
	$GLOBALS['DBHost'] = 'localhost';
	$GLOBALS['DBUser'] = 'php';
	$GLOBALS['DBPass'] = 'polipo98';
}
else {
	$GLOBALS['DBHost'] = 'localhost';
	$GLOBALS['DBUser'] = 'root';
	$GLOBALS['DBPass'] = 'root';
}
$GLOBALS['DBName'] = 'etalk2';

define('DB_ENCODING', 'UTF8');
