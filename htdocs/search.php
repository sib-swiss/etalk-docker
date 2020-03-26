<?php
	include('_db.php');
	include('_formutils.php');
?> 
<!doctype html>
<html class="no-js" lang="en-US">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow">
    <title></title>

    <link rel='stylesheet' id='foundation-css-css' href='s/sitecss/foundation.css' type='text/css' media='' />
    <link rel='stylesheet' id='main-style-css' href='s/sitecss/style.css' type='text/css' media='all' />

    <link rel='stylesheet' id='redux-google-fonts-css'
        href='https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A400&#038;subset=latin&#038;ver=1419502366'
        type='text/css' media='all' />

    <link rel='stylesheet' id='basics' href='css/style.min_new.css'
        type='text/css' media='all' />

    <script type='text/javascript' src='js/sitejs/wp-includes/js/jquery/jquery.js'></script>
    <script type='text/javascript' src='js/sitejs/wp-includes/js/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript'
        src='js/sitejs/wp-content/themes/miomio/js/vendor/modernizr.js?ver=3.9.2'></script>

    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://manoolia.com/miomio/xmlrpc.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml"
        href="https://manoolia.com/miomio/wp-includes/wlwmanifest.xml" />
    <meta name="generator" content="WordPress 3.9.2" />
    <style type="text/css" title="dynamic-css" class="options-output">
        .site-header {
            background-color: #CBCBCB;
        }

        .site-footer {
            color: #CBCBCB;
        }

        body,
        p {
            font-family: Source Sans Pro;
            line-height: 25px;
            font-weight: 400;
            font-style: normal;
            color: #333;
            font-size: 16px;
        }

        h1 {
            font-size: 40px;
        }

        h2 {
            font-size: 32px;
        }

        h3 {
            font-size: 28px;
        }

        h4 {
            font-size: 24px;
        }

        h5 {
            font-size: 20px;
        }

        h6 {
            font-size: 16px;
        }
    </style>

    <script>
        (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-65825344-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body class="home blog">
    <header class="header-2">
        <div class="row">
            <nav class="top-bar" data-topbar>
                <ul class="title-area">
                    <li class="name">

                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
                </ul>
                <!--main menu -->
                <div class="top-bar-section">
                    <ul id="menu-main-manu" class="right">
                        <li id="menu-item-5"
                            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home active menu-item-5 active">
                            <a href="search.php">Home</a></li>
                        <li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-35"><a
                                href="introduction/">Introduction</a></li>
                        <li id="menu-item-77" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77"><a
                                href="mode-demploi/">How does it work?</a></li>
                        <li id="menu-item-77" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77"><a
                                href="mode-demploifr/">Mode d'emploi</a></li>
                        <li id="menu-item-51" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-51"><a
                                href="contact/">Contact us</a></li>
                    </ul>
                </div>
            </nav>
        </div>

    </header>
    <section class="main-container">
        <div class="row">
            <div>
                <div class="row">
                    <div class="small-12 columns slideshow">
                        <ul class="example-orbit" data-orbit>
                            <li>
                                <a href="">
                                    <img width="100%" height="50%"
                                        src="image/Imageunique.jpg"
                                        class="attachment-single-page wp-post-image" alt="100H" />
                                    </a>
                                <div class="orbit-caption" position="relative">
                                    <a href=#bp>
                                        <h4>MARK16 eTalks</h4>
                                    </a>
                                    <h5 style="color: white; font-size: 1em">SNSF project 2018-2023</h5>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- slideshow -->
                </div>
                <span id="bp" class='anchor'></span>

                <form action="search.php" method="POST">
                    <input style="width:400px" type="text" name="search" placeholder="<Type your search terms>"> &nbsp;
                    <button class="read-more" type="submit" name="submit-search">Search</button>
                </form>

<?php
    echo '<nav>';

    console_log('submitted:' . isset($_POST['submit-search']));
    console_log('$_REQUEST:' . $_POST);
    $criteria =  $_POST['search'];
    if (isset($_POST['submit-search']) && $criteria != '') {
        $r_t = search_term($criteria);
        $count = db_count($r_t);
        if ($count > 1) {
            echo '<h3>There are '.$count.' result(s) for ' . $criteria . ' :</h3>';
        } else if ($count == 1) {
            echo '<h3>There is 1 result for ' . $criteria . ' :</h3>';
        } else {
            echo '<h3>There is no result for ' . $criteria . '.</h3>';
        }
    } else {
        $r_t = db_s('talks', array('published' => '1'), array('date' => 'DESC'));
        echo '<h2>All results :</h3>';
    }
        while ($t = db_fetch($r_t)) {
            $dir = $t['dir'];
            $imagefile = 'tmp/'.get_main_image($dir);
            console_log('dir : '. $t['dir'] . '$ imagefile:' . $imagefile);


					if (!is_dir('data/'. $dir)) {
						db_d('talks', array('dir' => $dir));			
						console_log("deleted etalk for unknown dir : " . $dir);
					} else {
?>
                    <article id="post-<?= $t['dir'] ?>"
                        class="post-<?= $t['dir'] ?> ppost type-post status-publish format-standard has-post-thumbnail hentry category-web feed-item">

                        <div class="row">
                            <div class="largeIm columns">
                                <div class="img-holder">
                                    <a href="index.php?dir=<?= $t['dir'] ?>" target="_blank"
                                        rel="noopener noreferrer"><img width="50%" height="50%"
                                            src="<?=$imagefile?>"
                                            class="feed-img wp-post-image" alt="image" /></a>  
                                </div> <!-- img holder -->
                            </div>
                            <div class="largeTxt">
                                <div class="feed-content ">
                                    <a href="index.php?dir=<?= $t['dir'] ?>" target="_blank"
                                        rel="noopener noreferrer">
                                        <h2><?= $t['title'] ?></h2>
                                    </a>
                                    <div class="post-meta">    
                                        <ul>
                                            <li><?= $t['author'] ?></li>
                                            <li><a href="index.php?dir=<?= $t['dir'] ?>">eTalk</a></li>
                                            <li><?= $t['duration'] ?></li>
                                            <li><?= datetime('F d, Y', $t['date']) ?></li>
                                        </ul>    
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="post-meta">    
                                        <ul>
                                            <li>Metadata : <a href="<?= $t['external_id'] ?>" target="_blank"><?= $t['external_id']?></a></li>
                                        </ul>    
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="post-meta">                                            
                                    </div>  
                                    <div class="feed-excerpt">
                                        <a class="read-more button"
                                            href="index.php?dir=<?= $t['dir'] ?>" target="_blank"
                                            rel="noopener noreferrer">Read eTalk</a>
       
                                        <div class="clearfix"></div>
                                    </div> <!-- feed excerpt -->
    
                                </div> <!-- feed content -->
                            </div>
                        </div>
                    </article>
<?php
					}

                } // while
			    echo '</nav>';
?>

            </div>
        </div>
    </section> <!-- main-container -->

    <footer class="footer">
        <div class="footer-wrapper">
            <div class="row">
                <div class="medium-6 columns small-text-center medium-text-left">
                    <h6>DH+ group, SIB, Lausanne</h6>
                </div>
                <div class="medium-6 columns">
                    <!-- footer menu -->
                    <div class="footer-menu">
                        <ul id="menu-footer-menu" class="footer-menu">
                            <li id="menu-item-103"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-103"><a
                                    href="about/">About</a></li>
                            <li id="menu-item-104"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-104"><a
                                    href="contact/">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- footer-wrapper -->
    </footer>

    <!-- script for contact form -->
    <script type='text/javascript'
        src='js/sitejs/wp-content/plugins/contact-form-7/includes/js/jquery.form.min.js?ver=3.51.0-2014.06.20'></script>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var _wpcf7 = { "loaderUrl": "https:\/\/manoolia.com\/miomio\/wp-content\/plugins\/contact-form-7\/images\/ajax-loader.gif", "sending": "Sending ..." };
    /* ]]> */
    </script>
    <script type='text/javascript'
        src='js/sitejs/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=3.9.3'></script>
    <script type='text/javascript' src='js/sitejs/wp-content/themes/miomio/js/foundation.min.js'></script>
    <script type='text/javascript' src='js/sitejs//wp-content/themes/miomio/js/main.js'></script>

    <script>
        jQuery(document).ready(function ($) {

            $(document).foundation();

        });
    </script>

    <!-- custom footer styles -->
    <style>
    </style>

    <!--custom footer scripts -->
    <script>
    </script>

</body>

</html>

<?php
/*
# Helper for console log
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
} */

function get_main_image($dir) {
    $r_t = db_s('sounds', array('dir' => $dir), array('id' => 'ASC'));
    $t = db_fetch($r_t);
    $file = $t['file'];
    return str_replace($dir.'/','',$file);
}

// Search term in etalk metadata
function search_term($term) {
    $mysqli = db_o();
    $sql = "select * from talks t"
    . " where published = 1 and ("
    . "    title like '%" . $term . "%'"
    . "    or author like '%" . $term . "%'"
    . "    or exists (select 1 from sounds where sounds.dir = t.dir and sounds.text like '%" . $term . "%')"
    . " ) order by date desc";
    console_log('search $sql = ' . $sql );
    if(!$result = $mysqli->query($sql)){
        dieWithError($mysqli->errno, $mysqli->error, $sql);
    }
   return $result;	
}        
?>