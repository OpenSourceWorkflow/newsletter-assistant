<?php
/**
 * @author markus
 */
class Model {

    public static $errors = array();
    public static $infos = array();

    public static function secure_sql($user_input){
	// Verbindung zur DB
	$connection = Model::connect();

	if(get_magic_quotes_gpc()){
	    $user_input = stripslashes($user_input);
	    $user_input = mysql_real_escape_string($user_input, $connection);
	} else {
	    $user_input = mysql_real_escape_string($user_input, $connection);
	}
	return $user_input;
    }

    public static function getErrors(){
	return self::$errors;
    }

    public static function getInfos(){
	return self::$infos;
    }

    public static function connect(){
        $conn = mysql_connect($GLOBALS['NA_CONFIG']['DBHost'], $GLOBALS['NA_CONFIG']['DBUser'], $GLOBALS['NA_CONFIG']['DBPass']);

	if (!$conn) {
	    array_push(self::$errors, array('errors'=>"Verbindung zur Datenbank fehlgeschlagen: ". mysql_error()));
        }

        if (!mysql_select_db($GLOBALS['NA_CONFIG']['DBDatabase'])) {
	    array_push(self::$errors, array('errors'=>"Auswahl aus Datenbank nicht möglich: ". mysql_error()));
        }
	return $conn;
   }

   public static function execute_sql($sql, $action){

	// Verbindung zur DB
	$connection = Model::connect();

        $result = mysql_query("set names 'utf8'");
	$result = mysql_query($sql, $connection);
	
	if (!$result) {
	    array_push(self::$errors, array('errors'=>"Anfrage konnte nicht ausgeführt werden: ". mysql_error()));
        }
	
       if ($action == "read"){
	    $entries = array();
	    while ($row = mysql_fetch_assoc($result)) {
		array_push($entries, $row);
	    }
	    return $entries;
       } else if($action == "create" || $action == "destroy"){
	    return;
       }
   }

   public static function getProjects(){
	$sql = "SELECT * FROM na_projects ORDER BY id DESC";
	return self::execute_sql($sql, "read");
    }
    
    public static function getVersions($project){
	$sql = "SELECT na_newsletter.id, na_newsletter.dates, na_newsletter.html, na_newsletter.plain FROM na_newsletter INNER JOIN na_projects ON (na_newsletter.project_id = na_projects.id) WHERE na_newsletter.project_id = $project ORDER BY dates DESC";
	return self::execute_sql($sql, "read");
    }

    public static function getVersion($project, $version){
	$sql = "SELECT na_newsletter.id, na_newsletter.dates, na_newsletter.html, na_newsletter.plain FROM na_newsletter INNER JOIN na_projects ON (na_newsletter.project_id = na_projects.id) WHERE na_newsletter.project_id = $project AND na_newsletter.id = $version";
	return self::execute_sql($sql, "read");
    }

    public static function saveProject($name){
	// Verbindung zur DB
	$connection = Model::connect();

	$name = self::secure_sql($name);
	
	if ($name == "") {
	    array_push(self::$errors, array('errors'=>"Bitte gib einen Namen für dein neues Projekt ein."));
        } else {
	    $sql1 = "INSERT INTO na_projects (id, name) VALUES (null, '$name')";
	    $sql2 = "INSERT INTO na_newsletter (id, project_id, dates , html, plain) SELECT null, MAX(na_projects.id) as project_id, null, '', '' FROM na_projects;";
	    self::execute_sql($sql1, "create");
	    self::execute_sql($sql2, "create");
	}
	
    }

    public static function saveNewsletter($project_id, $html, $plain){
	$html = self::secure_sql($html);
	$plain = self::secure_sql($plain);
	
	$sql = "INSERT INTO na_newsletter (id, project_id, dates , html, plain) VALUES (null, '$project_id', null, '$html', '$plain')";
	return  self::execute_sql($sql,"create");
    }

     public static function deleteProject($id){
	$sql1 = "DELETE FROM na_projects WHERE id = $id";
	$sql2 = "DELETE FROM na_newsletter WHERE project_id = $id";
	
	self::execute_sql($sql1, "destroy");
	self::execute_sql($sql2, "destroy");
    }

    public static function getLatestProject(){
	$sql = "SELECT MAX(na_projects.id) as latestProjectID FROM na_projects";
	return self::execute_sql($sql, "read");
    }

    public static function getProjectName($id){
	$sql = "SELECT name FROM na_projects WHERE id = $id";
	return self::execute_sql($sql, "read");
    }

    public static function setRecipientCookie($value){
	setcookie("na_recipients", $value);
    }

    public static function getRecipientCookie(){
	return $_COOKIE["na_recipients"];
    }

  
}
?>