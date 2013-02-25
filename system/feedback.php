<?php
    $request = array_merge($_GET, $_POST);
    mail("post@markus-falk.com", "Newsletter Assistent Feedback", $request['infos']);

     /*
    function send_tmp($recipient, $html, $plain, $subject_project_partial) {

        // Betreff
	$subject = $subject_project_partial . " " . $GLOBALS['NA_CONFIG']['subject'];

        // Grenze
	$boundary = md5(uniqid(time()));

        // Header
	$header = 'From: ' . $GLOBALS['NA_CONFIG']['senderName'] . ' <' .$GLOBALS['NA_CONFIG']['senderMail'] . '>' . "\n";
	$header .= 'MIME-Version: 1.0' . "\n";
	$header .= 'Content-Type: multipart/alternative; ';
	$header .= 'boundary="'. $boundary . '"' . "\n";

        // Plain
	$mail_body = "--" . $boundary . "\n";
	$mail_body .= 'Content-Type: text/plain; ';
	$mail_body .= 'charset="utf-8"' . "\n";
	$mail_body .= 'Content-Transfer-Encoding: 8bit' . "\n\n";
	$mail_body .= $plain . "\n\n";

        // HTML
	$mail_body .= "--" . $boundary . "\n";
	$mail_body .= 'Content-Type: text/html;';
	$mail_body .= 'charset="utf-8"' . "\n";
	$mail_body .= 'Content-Transfer-Encoding: quoted-printable' . "\n\n";
	$mail_body .= $html . "\n";
	$mail_body .= "--" . $boundary . "--\n\n";

        // Versand
	mail($recipient, $subject, $mail_body, $header);
    }

   */
?>