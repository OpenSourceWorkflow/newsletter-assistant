<?php
/* 
 * Diese Datei führt die Installation der Datenbank
 * vor der ersten Benutzung aus, wenn die Versionierung
 * in der config.php aktiviert ist.
 */

ini_set("error_reporting",0);

// Konfiguration laden
require_once('config.php');

$errors = array();

$sql_projects = "
  CREATE TABLE IF NOT EXISTS na_projects (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY name (name)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
";

$sql_versions = "
  CREATE TABLE IF NOT EXISTS na_newsletter (
  id int(11) NOT NULL AUTO_INCREMENT,
  project_id int(11) NOT NULL,
  dates timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  html mediumtext COLLATE utf8_unicode_ci NOT NULL,
  plain mediumtext COLLATE utf8_unicode_ci NOT NULL,

  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
";

function setup($sql){
	
	global $errors;

        $conn = mysql_connect($GLOBALS['NA_CONFIG']['DBHost'], $GLOBALS['NA_CONFIG']['DBUser'], $GLOBALS['NA_CONFIG']['DBPass']);

	if (!$conn) {
	    array_push($errors, array('errors'=>"Verbindung zu DB fehlgeschlagen: ". mysql_error()));
        }
        if (!mysql_select_db($GLOBALS['NA_CONFIG']['DBDatabase'])) {
	    array_push($errors, array('errors'=>"Auswahl aus DB nicht möglich: ". mysql_error()));
        }

        $result = mysql_query("set names 'utf8'");
	$result = mysql_query($sql);

	if (!$result){
	    array_push($errors, array('errors'=>"Query konnte nicht ausgeführt werden: ". mysql_error()));   
	}
   }
   
   $projects = setup($sql_projects);
   $versions = setup($sql_versions);

?>

<html>
    <head>
	<title>Setup HTML-Newsletter Assistent <?php echo($GLOBALS['NA_CONFIG']['version']); ?></title>
	<link rel="shortcut icon" href="favicon.ico" />
	<link href="../css/screen.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="../css/print.css" rel="stylesheet" type="text/css" media="print" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
	<div id="container">
	    <h1>Setup Newsletter Asisstent <span><?php echo($GLOBALS['NA_CONFIG']['version']); ?></span></h1>
	    
		<?php
		if ($errors){
		?>
		<ul id="errors">
		<?php
		    foreach($errors as $error){
		?>
		<li><?php echo $error['errors']; ?></li>
		<?php
		    }
		    ?>
		</ul>
		<?php
		} else {
		?>
		<div id="setup">
		    <p>Newsletter Asisstent <span><?php echo($GLOBALS['NA_CONFIG']['version']); ?></span> erfolgreich installiert.</p>
		    <a href="<?php echo($GLOBALS['NA_CONFIG']['na_path']); ?>" title="zum Newsletter Asisstent <?php echo($GLOBALS['NA_CONFIG']['version']);"" ?>>Los geht's</a>
		<?php
		}
		?>
	    </div>
	</div>
    </body>
</html>