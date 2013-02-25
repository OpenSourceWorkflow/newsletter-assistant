<?php
/**
 *
 * @author markus
 */
class View {
    private $path = 'templates';
    private $_ = array();

    public function assign($key, $value){
	$this->_[$key] = $value;
    }

    public function setTemplate($template = 'default'){
	$this->template = $template;
    }

    public function loadTemplate(){
	$tpl = $this->template;
	// Pfad zum Template erstellen & überprüfen ob das Template existiert.
	$file = $this->path . DIRECTORY_SEPARATOR . $tpl . '.php';
	$exists = file_exists($file);
    	if ($exists){
		// Der Output des Scripts wird n einen Buffer gespeichert, d.h.
		// nicht gleich ausgegeben.
		ob_start();

		// Das Template-File wird eingebunden und dessen Ausgabe in
	// $output gespeichert.
		include $file;
		$output = ob_get_contents();
		ob_end_clean();

		// Output zurückgeben.
		return $output;
	}
	else {
	    // Template-File existiert nicht-> Fehlermeldung.
	    return 'could not find template';
	}
    }
}
?>
