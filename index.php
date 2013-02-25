<?php

// Entwicklermodus
ini_set("error_reporting", 0);

// MVC Implementierung
include('classes/controller.php');
include('classes/model.php');
include('classes/view.php');

// Konfiguration laden
require_once('system/config.php');

// $_GET und $_POST zusammenfassen
$request = array_merge($_GET, $_POST);

// Controller erstellen
$controller = new Controller($request);

// Inhalt ausgeben
echo $controller->display();

?>