<?php
/* _db
 * Database wrapper for PHP
 * Version 2.2 - MySQL
 * Copyright (c) 2006-2013 Cyril Bornet, all rights reserved
 * ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
 * Historique des versions :
 *  05/03/2006 | 1.0 | Version initiale, comprenant méthodes openTable(), db_s(), db_g(), db_e(), db_i(), db_u() et db_d().
 *  25/05/2007 | 1.2 | Renommage des fonctions ci-dessus vers db_o(), db_s(), db_g(), db_e(), db_i(), db_u(), db_d(), pour compatibilité avec version publique.
 *  03/08/2007 | 1.3 | Correction affectant la fonction db_o() : suppression du paramètre $table (inutile) / ajout de la fonction ouverte db_x().
 *  03/08/2007 | 1.4 | Système de journalisation pour toutes les méthodes altérant des données.
 *  12/11/2010 | 1.5 | Potential security flaws fixes.
 *  04/01/2011 | 1.6 | Unique connection in global variable
 *  09/02/2012 | 2.0 | Updated sort arguments calls, added transactions support
 *	31/01/2013 | 2.1 | UPDATE/DELETE by References
 *	07/06/2013 | 2.2 | Operators in WHERE clauses (VB)
 * ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
 * Copyright (c) 2019 Jonathan Barda, SIB
 * ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
 *	12/11/2019 | 2.3 | Changed Database Driver to MySQLND
 */

// === Ouvre une CONNEXION globale au serveur de DB ============================================================================================================
$GLOBALS['db_link'] = false;
$mysqli = new mysqli($GLOBALS['DBHost'], $GLOBALS['DBUser'], $GLOBALS['DBPass'], $GLOBALS['DBName']);
$mysqli_debug = false;

/* Debug (Before) */
if ($mysqli_debug === true) {
	echo '<!--' . PHP_EOL;
	echo 'Initial character set: ' . $mysqli->character_set_name() . PHP_EOL;
	echo '-->' . PHP_EOL;
}

// Set character encoding to UTF-8 (value of DB_ENCODING)
$mysqli->query('SET NAMES ' . DB_ENCODING);

/* Debug (After) */
if ($mysqli_debug === true) {
	echo '<!--' . PHP_EOL;
	echo 'Current character set: ' . $mysqli->character_set_name() . PHP_EOL;
	echo '-->' . PHP_EOL;
}

function db_o() {
	global $mysqli;
	if ($mysqli->connect_error) {
		die('<h1>Down for maintenance</h1><p>This website is currently down for maintenance. We are currently working on it, so please come back in a few hours...</p><hr>' . $_SERVER['HTTP_HOST']);
	}

	$GLOBALS['db_link'] = $mysqli; // Will be set only if not dying before
	return $mysqli;
}

// === Effectue une RECHERCHE dans la base de données du site ==================================================================================================
function db_s($table, $refs=array(), $sortParams=array()) {
	$mysqli = db_o();																											// Ouvre une connexion
	$sql = 'SELECT * FROM '.$table.db_w($refs);

	// Sort parameters ______________________________________________________________________
	if (count($sortParams)>0) {
		$sort = array();
		foreach ($sortParams as $key => $dir) {
			$sort[] = $key.' '.$dir;
		}
		$sql.=' ORDER BY '.implode(', ', $sort);
	}
	if(!$result = $mysqli->query($sql)){
 		dieWithError($mysqli->errno, $mysqli->error, $sql);
	}
	return $result;
}

function db_w($refs) {
	// Filter parameters ____________________________________________________________________
	$mysqli = db_o();																	// Ouvre une connexion
	$str = '';
	if (count($refs)>0) {
		$where = array();
		foreach ($refs as $key => $value) {	
			if (strstr($key, '%') !== false) {
				$proper_key = str_replace('%','',$key);
				$str_val = ($value===null)?'null':'"'.db_escape(str_replace($proper_key,$value,$key)).'"';
				$where[] = $proper_key.' LIKE '.$str_val;
			}elseif(strstr($key, "!")){
				$proper_key = str_replace('!','',$key);
				$str_val = ($value===null)?'null':'"'.db_escape($value).'"';
				$where[] = $key.' != '.$str_val;
			}else{
				$str_val = ($value===null)?'null':'"'.db_escape($value).'"';
				$where[] = $key.' = '.$str_val;
			}
		}
		$str = ' WHERE ('.implode(' AND ', $where).')';
	}
	return $str;
}

// === INSERE les données $datas dans la table $table de la base de donnés de ce site ==========================================================================
function db_i($table, $datas, $do_log=true) {
	$mysqli = db_o();																	// Ouvre une connexion
	$keys = array();
	$values = array();

	foreach ($datas as $key => $value) {											// \
		$keys[] = $key;																//  |
		$values[] = '"'.db_escape($value).'"';										//  Parcourt les données en paramètres pour les réarranger conformément à la requête SQL
	}																				// /
	$sql = 'INSERT INTO '.$table.' ('.implode(', ', $keys).') VALUES ('.implode(', ', $values).');';				// Requête SQL

	if ($do_log) { db_log($sql); }

	if($result = $mysqli->query($sql)){
		// return $mysqli->insert_id;
		// return $mysqli->info;
		return $mysqli->affected_rows;
	} else {
		dieWithError($mysqli->errno, $mysqli->error, $sql);
		return false;
	}	// Témoin d'enregistrement (true = OK)
}

// === REMPLACE la ligne avec sélecteur spécifié ===============================================================================================================
function db_r($table, $datas, $do_log=true) {
	$mysqli = db_o();																	// Ouvre une connexion
	$keys = array();
	$values = array();

	foreach ($datas as $key => $value) {											// \
		$keys[] = $key;																//  |
		$values[] = '"'.db_escape($value).'"';										//  Parcourt les données en paramètres pour les réarranger conformément à la requête SQL
	}																				// /
	$sql = 'REPLACE INTO '.$table.' ('.implode(', ', $keys).') VALUES ('.implode(', ', $values).');';				// Requête SQL

	if ($do_log) { db_log($sql); }
	
	if($result = $mysqli->query($sql)){
		// return $mysqli->insert_id;
		return $mysqli->info;
	} else {
		dieWithError($mysqli->errno, $mysqli->error, $sql);
		return false;
	}
}


// === MODIFIE la ligne avec id=$id dans la table $table de la base de donnés de ce site =======================================================================
function db_u($table, $refs, $datas, $do_log=true) {
	$mysqli = db_o();																	// Ouvre une connexion
	$test = db_s($table, $refs);											// Pour éviter le risque d'écraser des données, on fait un test de cohérence avant d'entamer les modifs.
	if (db_count($test) > 1) {													//
		dieWithError('', '', 'db_u() cannot be used on tables with non-unique IDs.');	// Si plusieurs lignes ont le même ID, on arrête tout ici par précaution
	}
	$toChange = array();															// \
	foreach ($datas as $key => $value) {											//  |
		// $str_val = ($value==null)?'null':'"'.db_escape($value).'"';						//  |
		$str_val = ($value==null)?'""':'"'.db_escape($value).'"';						//  |
		$toChange[] = $key.'='.$str_val;											//  |
	}																				// /
	$sql = 'UPDATE '.$table.' SET '.implode(',',$toChange).db_w($refs);				// Requête SQL

	if ($do_log) { db_log($sql); }
	
	if($result = $mysqli->query($sql)){
		// return $mysqli->insert_id;
		return $mysqli->info;
	} else {
		dieWithError($mysqli->errno, $mysqli->error, $sql);
		return false;
	}
}

// === SUPPRIME la ligne avec id=$id dans la table $table de la base de donnés de ce site ======================================================================
function db_d($table, $refs, $do_log=true) {
	$mysqli = db_o();																	// Ouvre une connexion
	$test = db_s($table, $refs);											// Pour éviter le risque d'écraser des données, on fait un test de cohérence avant d'entamer les modifs.
	if (db_count($test) > 1) {													//
		dieWithError('', '', 'db_d() cannot be used on tables with non-unique IDs.');	// Si plusieurs lignes ont le même ID, on arrête tout ici par précaution
	}
	elseif (db_count($test) > 0) {
		$sql = 'DELETE FROM '.$table.db_w($refs);

		if ($do_log) { db_log($sql); }

		if($result = $mysqli->query($sql)){
			// return $mysqli->insert_id;
			return $mysqli->info;
		} else {
			dieWithError($mysqli->errno, $mysqli->error, $sql);
			return false;
		}
	}
}

// === EXECUTE la requête passée en paramètre ==================================================================================================================
function db_x($request, $do_log=true, $qParams=array()) {
	$mysqli = db_o();																	// Ouvre une connexion

	if ($do_log && substr($request, 0, 7) != 'SELECT ' && $mysqli->errno>0) { db_log($request); }

	if($result = $mysqli->query($request)){
		return $result;
	}
	else {
		dieWithError($mysqli->errno, $mysqli->error, $request);
	}
}

// === TRANSACTIONS ============================================================================================================================================

function db_begin($title='default') {
	$mysqli = db_o();																	// Ouvre une connexion
	$sql = 'BEGIN TRANSACTION '.$title.'';
	$result = $mysqli->query($sql);
}

function db_commit($title='default') {
	$mysqli = db_o();																	// Ouvre une connexion
	$sql = 'COMMIT TRANSACTION '.$title.'';
	$result = $mysqli->query($sql);
}

// === TOOLS & Helpers =========================================================================================================================================

function db_escape($string) {
	$mysqli = db_o();																	// Ouvre une connexion
	return $mysqli->real_escape_string($string);
}

function db_fetch($result) {
	return $result->fetch_assoc();
}

function db_seek($result, $offset = 0) {
	return $result->data_seek($offset);
}

function db_count($result) {
	return $result->num_rows;
}

function dieWithError($code, $msg, $stmt) {
	echo('<br/><br/><b>MySQL error '.$code.': '.$msg.'</b><br/>When executing : <pre style="background:#CCC;padding:5px;">'.$stmt.'</pre>');
}

// === JOURNALISE la requête en paramètre, selon variables courantes ===========================================================================================

function db_log($request) {
	$mysqli = db_o();																	// Ouvre une connexion
	$result = $mysqli->query('INSERT INTO db_log (user_id, date, query) VALUES ("'.@$_SESSION['user_id'].'", CURRENT_TIMESTAMP, "'.db_escape($request).'");');
}

// To avoid memory issues
function db_close($link = null) {
	// Link not given...
	if (!is_null($link)) {
		// Get link from global scope
		$link = $GLOBALS['db_link'];
	}

	// Close the given / detected db link
	if ($link !== false) {
		$link->close();
	}
}

?>