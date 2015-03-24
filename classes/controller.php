<?php
/**
 * @author markus
 */
class Controller {
    private $request = null;
    private $template = '';
    public $errors = array();

    public function __construct($request) {
	$this->request = $request;
	$this->template = !empty($request['view']) ? $request['view'] : 'default';
    }

    public function checkVersion(){

	$curlsession = curl_init();

	if($curlsession){
	    curl_setopt($curlsession, CURLOPT_URL, 'http://www.visiongraphix.de/tl_files/na_newsletter_version/version.php');
	    curl_setopt($curlsession, CURLOPT_HEADER, 0);
	    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt( $curlsession, CURLOPT_CONNECTTIMEOUT, 2);
	    $na_latest_version = curl_exec($curlsession);
	    curl_close($curlsession);
	} else {
	    $ctx = stream_context_create(array(
		'http' => array(
		    'timeout' => 2
		    )
		)
	    );
	    $na_latest_version = file_get_contents('http://www.visiongraphix.de/tl_files/na_newsletter_version/version.php', 0 , $ctx);
	}

	if($na_latest_version == ''){
	    array_push(Model::$errors, array('errors' => 'Es konnte nicht auf Updates überprüft werden. Die Prüfung auf Updates kann in der Datei system/config.php deaktiviert werden.'));
	}

	if($GLOBALS['NA_CONFIG']['version'] < $na_latest_version){
	    return $na_latest_version;
	} else {
	    return false;
	}
    }

    public function validatePlain($inhalt) {

	$hinweise = array();

	if (!preg_match('/Impressum/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'In jeder E-Mail muss auch ein Impressum enthalten sein.'));
	}

	if (!preg_match('/Adressbuch/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Weise in deinem Newsletter die Empfänger darauf hin, dich in das Adressbuch aufzunehmen, damit später Bilder sofort angezeigt werden.'));
	}

	return $hinweise;
    }

    public function validateHTML($inhalt) {

	$hinweise = array();

	if(!preg_match('/<table/',$inhalt)) {
	    array_push($hinweise, array('hints' => 'Um Outlook 07/03, Lotus Notes oder Google Mail zu unterstützen solltest du dein Template mit HTML-Tabellen bauen.'));
	}
	if (preg_match('/<script/',$inhalt)) {
	    array_push($hinweise, array('hints' => 'Auf JavaScript sollte in HTML-Newslettern ganz verzichtet werden, da die Clients dies nicht unterstützen.'));
	}

	if (!preg_match('/style/',$inhalt) || preg_match('/\.css/',$inhalt)) {
	    array_push($hinweise, array('hints' => 'Damit dein Newsletter gut aussieht solltest du das CSS direkt in die HTML-Datei einbinden.'));
	}

	if (preg_match('/src="(?!http:).*/',$inhalt)) {
	    array_push($hinweise, array('hints' => 'Achte darauf, dass alle Bilder von einer externen Quelle (Server) nachgeladen werden müssen.'));
	}

	if (preg_match('/alt=""/', $inhalt) || preg_match('/alt="\ "/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Der Alternativtext eines Bildest ist noch leer. Dieser wird benötigt,  weil Bilder im E-Mail Client nicht standardmäßig angezeigt werden.'));
	}

	if (substr_count($inhalt, '<img') != substr_count($inhalt, 'alt=')) {
	    array_push($hinweise, array('hints' => substr_count($inhalt, '<img')."  Bild(er) noch ohne Alternativtext. Dieser wird benötig, weil Bilder im E-Mail Client nicht standardmäßig angezeigt werden."));
	}

	if (substr_count($inhalt, 'href=\"http') > substr_count($inhalt, 'target=')) {
	    array_push($hinweise, array('hints' => substr_count($inhalt, 'href=\"http')-substr_count($inhalt, 'target=') . ' externe(r) Link(s) noch ohne target="_blank". Das wird benötig, damit der E-Mail Client externe Links wirklich im Browser öffnet.'));
	}

	// target="_self" -> target="_blank"
        // background-image bei google Mail

	if (!preg_match('/\<\!DOCTYPE/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Dein Template hat keinen Doctype. Empfohlen wird XHTML 1.0 Transitional.'));
	}

	if (preg_match('/DTD HTML 4/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Dein Template hat einen alten Doctype. Empfohlen wird XHTML 1.0 Transitional.'));
	}

	if (preg_match('/<div/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Dein Template enhält div-container. Darauf solltest du bei HTML-Newslettern soweit es geht verzichten.'));
	}

	if (!preg_match('/Impressum/', $inhalt) && !preg_match('/Herausgeber/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Jeder Newsletter muss ein Impressum enthalten.'));
	}

	if (!preg_match('/Adressbuch/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Weise in deinem Newsletter die Empfänger darauf hin, dich in das Adressbuch aufzunehmen, damit später Bilder sofort angezeigt werden.'));
	}

	if (preg_match('/float:/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'In Newslettern sollte auf ein Spalten-layout mit "float" verzichtet werden.'));
	}

	if (preg_match('/spacer\.gif/', $inhalt) || preg_match('/blank\.gif/', $inhalt)) {
	    array_push($hinweise, array('hints' => 'Manche E-Mail Clients erkennen E-Mails mit GIF-Bilder mit geringer Größe (z.B: 1x1 Pixel) als Spam.'));
	}

	if (!preg_match('/CHARSET=UTF-8/', strtoupper($inhalt))) {
	    array_push($hinweise, array('hints' => 'Für bessere Kompatiblität sollte der Charset der E-Mail auf utf-8 gesetzt werden.'));
	}

        if (preg_match('/<style/',$inhalt)) {
	    array_push($hinweise, array('hints' => 'Beachte, dass z.B. GoogleMail ein vorhandenes Style-Tag vollständig entfernt.'));
	}

        if (preg_match('/background-image/',$inhalt)) {
	    array_push($hinweise, array('hints' => 'Beachte, dass z.B. GoogleMail, Outlook 2007/10 Background-Images nicht anzeigen.'));
	}

        if (!preg_match('/text-decoration:/',$inhalt)) {
	  array_push($hinweise, array('hints' => 'Keiner der Links hat die Eigenschaft text-decoration. Dies kann in manchen Clients zu Darstellungsfehlern führen.'));
	}

	return $hinweise;
    }

    function send ($recipient, $html, $plain, $subject_project_partial){

        require('classes/class.phpmailer.php');

        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Mailer = $GLOBALS['NA_CONFIG']['mailTransport'];
        $mail->Sendmail = $GLOBALS['NA_CONFIG']['sendmailPath'];
        $mail->Host = $GLOBALS['NA_CONFIG']['smtpHost'];
        $mail->SMTPAuth = (!empty($GLOBALS['NA_CONFIG']['smtpUsername']) || !empty($GLOBALS['NA_CONFIG']['smtpPassword']))? true : false;
        $mail->Username = $GLOBALS['NA_CONFIG']['smtpUsername'];
        $mail->Password = $GLOBALS['NA_CONFIG']['smtpPassword'];
        $mail->SMTPDebug = false;

        $mail->From = $GLOBALS['NA_CONFIG']['senderMail'];
        $mail->FromName = $GLOBALS['NA_CONFIG']['senderName'];
        $mail->Sender = $GLOBALS['NA_CONFIG']['senderMail'];
        $mail->AddReplyTo($GLOBALS['NA_CONFIG']['senderMail'], $GLOBALS['NA_CONFIG']['senderName']);

        $recipient = preg_split("/[\s]*[,][\s]*/", $recipient);
        for($i = 0; $i < sizeof($recipient); $i++){
            $mail->AddAddress($recipient[$i]);
        }

        $mail->Subject = $subject_project_partial . (empty(!$GLOBALS['NA_CONFIG']['subject'])? ' ' . $GLOBALS['NA_CONFIG']['subject'] : '');
        $mail->Body = $html;
        $mail->AltBody= $plain;
        $mail->WordWrap = $GLOBALS['NA_CONFIG']['wordWrap'];

        if(!$mail->Send()) {
            array_push(Model::$errors, array('errors' => 'Beim Versenden der E-Mail ist ein Fehler aufgetreten: ' . $mail->ErrorInfo));
        } else {
             array_push(Model::$infos, array('infos' => 'E-Mail erfolgreich versendet.'));
        }
    }

    public function display(){

	$view = new View();
	$request = $this->request;
	$view->setTemplate('default');

	switch($this->template) {

	    case 'projects':

		$projects = Model::getProjects();
		$view->assign('projects', $projects);
		$versions = Model::getVersions($request['project']);
		$view->assign('versions', $versions);
		$view->assign('project', $request['project']);
		$view->assign('recipient', Model::getRecipientCookie());

                array_push(Model::$infos, array('infos' => 'Projekt geladen. Wähle Version.'));
		break;

	    case 'versions':

		$projects = Model::getProjects();
		$view->assign('projects', $projects);

		$versions = Model::getVersions($request['project']);
		$view->assign('versions', $versions);

		$view->assign('project', $request['project']);
		$view->assign('version', $request['version']);

		$version = Model::getVersion($request['project'], $request['version']);

		$hintsHTML = self::validateHTML($version[0]['html']);
		$view->assign('hintsHTML', $hintsHTML);

		if($request['plain']){
		    $hintsPlain = self::validatePlain($version[0]['html']);
		    $view->assign('hintsPlain', $hintsPlain);
		}

		$view->assign('html', $version[0]['html']);
		$view->assign('plain', $version[0]['plain']);

		$view->assign('recipient', Model::getRecipientCookie());

                array_push(Model::$infos, array('infos' => 'Version geladen und Newsletter überprüft.'));
		break;

	    case 'new_project':
		Model::saveProject($request['new_project_name']);
		$projects = Model::getProjects();
		$view->assign('projects', $projects);
		$project = Model::getLatestProject();
		$view->assign('project', $project[0]['latestProjectID']);

		if(get_magic_quotes_gpc()){
			$view->assign('html', stripslashes($request['html']));
			$view->assign('plain', stripslashes($request['plain']));
		    } else {
			$view->assign('html', $request['html']);
			$view->assign('plain', $request['plain']);
		    }
                 array_push(Model::$infos, array('infos' => 'Projekt gespeichert.'));
		break;

	    case 'del_projects':

		Model::deleteProject($request['del_project_id']);
		$projects = Model::getProjects();
		$view->assign('projects', $projects);
		$view->assign('project', $request['project']);

                array_push(Model::$infos, array('infos' => 'Projekt gelöscht.'));
		break;

	     case 'validate_send':

		if(!preg_match('/^\s+$/',$request['html'])){

		    $hintsHTML = self::validateHTML($request['html']);
		    $view->assign('hintsHTML', $hintsHTML);

		    if($request['plain']){
			$hintsPlain = self::validatePlain($request['plain']);
			$view->assign('hintsPlain', $hintsPlain);
		    }

		    if(get_magic_quotes_gpc()){
			$view->assign('html', stripslashes($request['html']));
			$view->assign('plain', stripslashes($request['plain']));
		    } else {
			$view->assign('html', $request['html']);
			$view->assign('plain', $request['plain']);
		    }

		    if($GLOBALS['NA_CONFIG']['versionize']){
			Model::saveNewsletter($request['project'], $request['html'], $request['plain']);

			$projects = Model::getProjects();
			$view->assign('projects', $projects);
			$view->assign('project', $request['project']);

			$versions = Model::getVersions($request['project']);
			$view->assign('versions', $versions);
		    }

                    if($request['recipient']){

                        $subject_project_partial = Model::getProjectName($request['project']);

                        $connection = Model::connect();

                        if(get_magic_quotes_gpc()){
                            $html_s = stripslashes($request['html']);
                            $plain_s = stripslashes($request['plain']);
                        } else {
                            $html_s = $request['html'];
                            $plain_s = $request['plain'];
                        }

                        self::send($request['recipient'], $html_s, $plain_s, $subject_project_partial[0]['name']);

                        $view->assign('recipient', $request['recipient']);
                        Model::setRecipientCookie($request['recipient']);
                    } else {
                        array_push(Model::$infos, array('infos' => 'Newsletter überprüft.'));
                    }

		} else {

		    array_push(Model::$errors, array('errors' => 'Das HTML-Template ist leer.'));

                    $view->assign('recipient', $request['recipient']);

		    if($GLOBALS['NA_CONFIG']['versionize']){

			$projects = Model::getProjects();
			$view->assign('projects', $projects);
			$view->assign('project', $request['project']);

			$versions = Model::getVersions($request['project']);
			$view->assign('versions', $versions);
		    }

		}



		break;

	    case 'default':
	    default:
		if($GLOBALS['NA_CONFIG']['versionize']){
		    $projects = Model::getProjects();
		    $view->assign('projects', $projects);
		    if ($projects){
			$versions = Model::getVersions($projects[0]['id']);
			$view->assign('versions', $versions);
		    }
		}

		$view->assign('recipient', Model::getRecipientCookie());

		if ($GLOBALS['NA_CONFIG']['checkForUpdates']){
		    $na_version = self::checkVersion();
		    if ($na_version){
			$view->assign('na_version', $na_version);
		    }
		}


	}

	// Verbindung zur DB
	$connection = Model::connect();

	$errors = Model::getErrors();
	$view->assign('errors', $errors);

        $infos = Model::getInfos();
        $view->assign('infos', $infos);

	return $view->loadTemplate();

    }

}

?>