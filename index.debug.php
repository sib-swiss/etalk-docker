<?php
	// Temporary debug
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	ini_set('error_log', '/tmp/php-errors.log');
	error_reporting(E_ALL);

	// Header config
	header('Vary: Accept');
	header('Content-Type: text/html; charset=utf-8');
	date_default_timezone_set('Europe/Zurich');
	include('_db.php');
	include('_formutils.php');

	if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
		$GLOBALS['browser'] = 'ms';
	}
	elseif (preg_match("/firefox/i", $_SERVER['HTTP_USER_AGENT'])) {
		$GLOBALS['browser'] = 'moz';
	}
	else {
		$GLOBALS['browser'] = 'webkit';
	}

	// Possible Character Encodings
	$text_encodings = ['ASCII', 'UTF-8', 'ISO-8859-1', 'ISO-8859-15', 'Windows-1252'];

	// Possible ways to convert incorrect encoding...
	// $var = mb_convert_encoding($var, 'UTF-8', $text_encodings);
	// $var = iconv('ISO-8859-1', 'UTF-8//TRANSLIT', $var);
	// $var = htmlspecialchars($var, ENT_NOQUOTES, "UTF-8");

	//$viewMode = (@$_REQUEST['dir']!='' && substr($_REQUEST['dir'], 0, 1)!='.' && $GLOBALS['browser']=='webkit');
	$viewMode = (@$_REQUEST['dir']!='' && substr($_REQUEST['dir'], 0, 1)!='.');
	if ($viewMode) {
		$talk = db_fetch(db_s('talks', array('dir' => $_REQUEST['dir'])));

		// Display active folder as title when no title given
		define('PAGE_TITLE', 'eTalk | ' . (!empty($talk['title']) ? $talk['title'] : $talk['dir']));

		// Detect encoding
		echo '<!--' . PHP_EOL;
		echo 'Detected Title Encoding: ' . mb_detect_encoding($talk['title'], $text_encodings) . PHP_EOL;
		echo '-->' . PHP_EOL;

		// Debug $talk content
		echo '<!--' . PHP_EOL;
		echo 'Talk:' . PHP_EOL;
		// var_dump($talk);
		print_r($talk);
		echo '-->' . PHP_EOL;
	}
	else {
		define('PAGE_TITLE', 'eTalk');
	}

	echo '<!DOCTYPE HTML><html><head><title>'.PAGE_TITLE.'</title>';
		echo '<link rel="stylesheet" type="text/css" media="screen" href="/s/screen.css" />';
		echo '<script type="text/javascript" src="/js/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="/js/jquery.color.min.js"></script>';
		echo '<script type="text/javascript" src="/js/jquery.animate-shadow-min.js"></script>';
		echo '<link rel="shortcut icon" type="image/ico" href="https://www.sib.swiss/templates/sib/favicon.ico">';
	echo '</head><body class="viewer'.($viewMode?' paused':'').'">';
	

    // Page Content ============================================================================================================================================
    if ($viewMode) {
		/* THIS PART IS DUPLICATED FOR NOTHING... ALREADY DEFINED BEFORE THE TEST.
		echo '<!DOCTYPE HTML><html><head><title>'.PAGE_TITLE.'</title>';
		echo '<link rel="stylesheet" type="text/css" media="screen" href="/s/screen.css" />';
		echo '<script type="text/javascript" src="/js/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="/js/jquery.color.min.js"></script>';
		echo '<script type="text/javascript" src="/js/jquery.animate-shadow-min.js"></script>';
		echo '<link rel="shortcut icon" type="image/ico" href="https://www.isb-sib.ch/templates/sib/images/favicon.ico">';
		echo '</head><body class="viewer'.($viewMode?' paused':'').'">'; */


	      echo '<header id="top">';
	    	if (!isset($_REQUEST['embed'])) {
		    	echo '<nav><img src="/i/back.png" id="bBack" alt="Back" class="btn" title="Retour à l’accueil" /></nav>';
		    }



#	    	echo '<h1>'.$talk['title'].'</h1>';
#	    	echo '<h2>'.$talk['author'].' &mdash; '.implode('.', array_reverse(explode('-', $talk['date']))).'</h2>';
	    	echo '<nav id="controls">';
	    		echo '<img src="/i/loading.gif" id="loading" class="btn" alt="" /> ';
				echo '<img src="/i/share.png" id="bShare" class="btn" alt="SHARE" title="Partager / Intégrer" />';
				echo '<img src="/i/audio_mute.png" id="bMute" class="btn" alt="MUTE" title="Activer/Couper le son" />';
				echo '<img src="/i/mode_full.png" id="bMode" class="btn" alt="Afficher/Masquer le transcript" />';
				echo '<img src="/i/prev.png" id="bPrev" class="btn" alt="◀︎◀︎" title="Précédent" />';
				echo '<img src="/i/play.png" id="bPlay" class="btn" alt="▶︎" />';
				echo '<img src="/i/pause.png" id="bPause" class="btn" alt="PAUSE" />';
				echo '<img src="/i/stop.png" id="bStop" class="btn" alt="◼︎" />';
				echo '<img src="/i/ffw.png" id="bNext" class="btn" alt="▶︎▶︎" title="Suivant" />';
			echo '</nav>';
	    echo '</header>';
	    // _______________________________________________________________________________________________________________________________________
    	echo '<div id="wait">';
    		echo '<header>';
	    		echo '<h1>'.$talk['title'].'</h1>';
	    		echo '<h2>'.$talk['author'].' &mdash; '.implode('.', array_reverse(explode('-', $talk['date']))).'</h2>';
	    		echo '<a href="#0" class="vidPlay">▶</a>';
	    	echo '</header>';
    		echo '<nav>';
	    		echo '<h2>Sommaire</h2>';
				$i=0;
				$chap_r = db_s('sounds', array('dir' => $_REQUEST['dir']), array('id' => 'ASC'));

				// Debug $chap_r content
				echo '<!--' . PHP_EOL;
				echo '$chap_r:' . PHP_EOL;
				// var_dump($chap_r);
				print_r($chap_r);
				echo '-->' . PHP_EOL;

				while ($chap = db_fetch($chap_r)) {
					if ($chap['chaptering']=='section') {
						echo '<a href="#'.$i.'">' . $chap['section_title'] . '</a>';

						// Detect encoding
						echo '<!--' . PHP_EOL;
						echo 'Detected Encoding: ' . mb_detect_encoding($chap['section_title'], $text_encodings) . PHP_EOL;
						echo '-->' . PHP_EOL;
					}
					$i++;

					// Debug $chap content
					echo '<!--' . PHP_EOL;
					echo '$chap:' . PHP_EOL;
					// var_dump($chap);
					print_r($chap);
					echo '-->' . PHP_EOL;
				}

				$docsFolder = 'data/'.$_REQUEST['dir'].'/docs';

				// Debug $docsFolder content
				echo '<!--' . PHP_EOL;
				echo '$docsFolder:' . PHP_EOL;
				// var_dump($docsFolder);
				print_r($docsFolder);
				echo 'is_dir:' . PHP_EOL;
				var_dump(is_dir($docsFolder));
				echo '-->' . PHP_EOL;

				if (is_dir($docsFolder)) {
					echo '<br/><h2>Fichiers liés</h2>';
					$files = scandir($docsFolder, 0);

					// Debug $files content
					echo '<!--' . PHP_EOL;
					echo '$files:' . PHP_EOL;
					// var_dump($files);
					print_r($files);
					echo '-->' . PHP_EOL;

					foreach ($files as $f) {
						if (substr($f, 0, 1)!='.' && !is_dir($docsFolder.'/'.$f)) {
							echo '<a href="/'.$docsFolder.'/'.$f.'" class="doc">'.$f.'</a>';
						}

						// Debug $f content
						echo '<!--' . PHP_EOL;
						echo '$f:' . PHP_EOL;
						// var_dump($f);
						print_r($f);
						echo '-->' . PHP_EOL;
					}
				}
    		echo '</nav>';
    	echo '</div>';
	    // _______________________________________________________________________________________________________________________________________
		echo '<aside id="embed"><div><div class="close">&times;</div><h1>Intégrer cette présentation</h1>';
			echo '<input id="fShareURL" type="text" readonly="readonly" style="float:right;width:87%;border:1px solid #000;margin-top:-1px;" /><label>URL:</label><br/>';
			echo '<textarea id="embed_code" readonly="readonly"></textarea>';
			echo '<form id="embed_customize" action="/">';
				echo '<fieldset><legend>Dimensions :</legend>';
					echo '<div><input id="embed_w" type="text" value="720" /> &times; <input id="embed_h" type="text" value="405" /> pixels</div>';
				echo '</fieldset>';
				echo '<fieldset><legend>Options:</legend>';
				echo '<ul>
						<li>
							<input id="embed_desc" type="checkbox" checked="checked" /><label for="embed_desc"> Description sous la vidéo</label>
						</li>
						<li>
							<input id="embed_link" type="checkbox" checked="checked" /><label for="embed_link"> Lien permanent dans la description</label>
						</li>
					</ul>';
				echo '</fieldset>';
			echo '</form>';
		echo '</div></aside>';
	    // _______________________________________________________________________________________________________________________________________
    	echo '<div id="overlay">';
    		echo '<img src="/i/close-w.png" class="close" alt="&times;" title="Close" width="22" height="22" />';
    		echo '<iframe></iframe>';
    	echo '</div>';
	   	echo '<div id="viz">';
    	$audioFiles = array();
		$i=0;
		$sounds_r = db_s('sounds', array('dir' => $_REQUEST['dir']), array('id' => 'ASC'));
		
		while ($sound = db_fetch($sounds_r)) {
			$track = array(
				'snd' => $sound['id'],
				'pict' => $sound['file'],
				'pict_link' => $sound['file_link'],
				'pict_cred' => $sound['file_credits'],
			);
			$links = '';
			$e = preg_split('/\s/',$sound['entities']);
			foreach ($e as $entity) {
				if ($entity!='') {
					$links.= '<a href="'.$entity.'" class="entity"><img src="/i/link.png" alt="" />'.@array_shift(explode('/', str_replace('http://', '', $entity))).'</a>';
				}
			}
			$track['link'] = $links;
			if ($sound['chaptering']=='section') {
				echo '<h2>'.$sound['section_title'].'</h2>';
			}

			// Display sound id when no text defined
			echo '<a class="'.$sound['type'].'" href="#'.$i.'" id="a'.$i.'">' . (!empty($sound['text']) ? markdown(stripslashes($sound['text'])) : 'File: ' . $sound['id']) . '</a>';
			$audioFiles[] = $track;
			$i++;

			// Detect encoding
			echo '<!--' . PHP_EOL;
			echo 'Detected Encoding: ' . mb_detect_encoding($sound['text'], $text_encodings) . PHP_EOL;
			echo '-->' . PHP_EOL;

			// Debug $sound + $track content
			echo '<!--' . PHP_EOL;
			echo 'Sound + Track:' . PHP_EOL;
			var_dump($sound, $track);
			echo '-->' . PHP_EOL;
		}

		// Debug $audioFiles content
		echo '<!--' . PHP_EOL;
		echo 'AudioFiles:' . PHP_EOL;
		var_dump($audioFiles);
		echo '-->' . PHP_EOL;

		echo '</div>';
	    // _______________________________________________________________________________________________________________________________________
		echo '<div id="dia"><figure>';
			echo '<img id="diaPict" src="" alt="" />';
			echo '<figcaption></figcaption>';
		echo '</figure><div id="links"></div></div>';
		// _____________________________________
		
		
		// Original player line
		// I haven't modified it. Just added a test before display.
		if (count($audioFiles) > 0) {
			echo '<audio id="player" preload="auto" src="/data/'.$audioFiles[0]['snd'].'" onerror="alert(\'The sound file \\\'\'+this.src+\'\\\' could not be loaded.\');" onended="endedPlay();" onloadstart="document.getElementById(\'loading\').style.display=\'inline\';" oncanplay="document.getElementById(\'loading\').style.display=\'none\';" onplay="startedPlay();"><source src="/data/'.$audioFiles[0]['snd'].'" type="audio/mp3" />HTML5 Only!</audio>';
		}

		/* Duplicated useless player line...
		Probably a dirty attemp to preload next file when existing.
		But written without a proper audio files counting...
		Commented to avoid duplication...
		echo '<audio id="player" preload="preload" src="/data/'.$audioFiles[0]['snd'].'" onerror="alert(\'The sound file \\\'\'+this.src+\'\\\' could not be loaded.\');" onended="endedPlay();" onloadstart="document.getElementById(\'loading\').style.display=\'inline\';" oncanplay="document.getElementById(\'loading\').style.display=\'none\';" onplay="startedPlay();"><source src="/data/'.$audioFiles[0]['snd'].'" type="audio/mp3" />HTML5 Only!</audio>'; */
		
		/* Preload the next file?
		Was already commented in the original version
		echo '<audio id="preloader" preload="preload" src="/data/'.$audioFiles[1]['snd'].'"><source src="/data/'.$audioFiles[1]['snd'].'" type="audio/mp3" />HTML5 Only!</audio>'; */

		// Load and init etalk modules
		if (count($audioFiles) > 0) {
			printJS('var audioFiles = ('.@json_encode($audioFiles).');');
			echo '<script type="text/javascript" src="/js/etalk.min.js"></script>';
		}
		// -- ONLY WHEN THE ARRAY IS NOT EMPTY --
    }
    else {
    	/*require 'main.html';*/
    	echo '<header id="top">';
    		echo '<h1>eTalk</h1><h2>Open-source online talks</h2>';
		echo '</header>';
		echo '<section>';

		/*
		Disabled Browser Check
		if ($GLOBALS['browser']!='webkit') {
			echo '<div>';
				echo '<h1>Votre navigateur web n’est pas compatible avec la fonctionnalité eTalk.</h1>';
				echo '<p>Nous vous prions d’utiliser avec l’un des navigateurs suivants:<ul><li>Google Chrome</li><li>Safari (version ≥7)</li><li>Internet Explorer (version 11)</li></ul></p>';
				echo '<p>Merci de votre compréhension.</p>';
			echo '</div>';
		}
		else { */
			
			echo '<nav>';
				$talks = array('' => '(sélectionnez une conférence)');
				$r_t = db_s('talks', array(), array('title' => 'ASC'));
				while ($t = db_fetch($r_t)) {
					//echo '<li class= "flex-disp-item"> <a href="?dir='.$t['dir'].'"><figure><div class="play"></div></figure><h2>'.$t['title'].'</h2><p>'.$t['author'].' ('.datetime('d.m.Y', $t['date']).')</p></a></li>';
					echo '<a href="?dir='.$t['dir'].'"><figure><div class="play"></div></figure><h2>'.$t['title'].'</h2><p>'.$t['author'].' ('.datetime('d.m.Y', $t['date']).')</p></a>';

					// Detect encoding
					echo '<!--' . PHP_EOL;
					echo 'Detected Encoding: ' . mb_detect_encoding($t['title'], $text_encodings) . PHP_EOL;
					echo '-->' . PHP_EOL;

					// Debug $t content
					echo '<!--' . PHP_EOL;
					echo '$t:' . PHP_EOL;
					// var_dump($t);
					print_r($t);
					echo '-->' . PHP_EOL;
				}

				// Debug $r_t content
				echo '<!--' . PHP_EOL;
				echo '$r_t:' . PHP_EOL;
				// var_dump($r_t);
				print_r($r_t);
				echo '-->' . PHP_EOL;

			echo '</nav>';

		/* }
		End of the disabled browser check
		*/
		echo '</section>';
	}
	
	// List included files to detect multiple useless file loading
	echo '<!--' . PHP_EOL;
	echo 'Included Files:' . PHP_EOL;
	foreach (get_included_files() as $file) {
		echo ' - ' . $file . PHP_EOL;
	}
	echo '-->' . PHP_EOL;

    echo '</body></html>';

?>
