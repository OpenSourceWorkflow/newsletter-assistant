<?php

    /*
     * - Absenderadresse
     * - Name des Absenders
     * - der Betreff besteht aus dem Projektnamen und diesem Zusatz
     */
    $GLOBALS['NA_CONFIG']['senderMail'] = '';
    $GLOBALS['NA_CONFIG']['senderName'] = '';
    $GLOBALS['NA_CONFIG']['subject'] = 'Newsletter Test-HTML';

    /*
     * - MySQL Server-Adresse
     * - MySQL Benutzername
     * - MySQL Passwort
     * - MySQL Datenbank-name
     */
    $GLOBALS['NA_CONFIG']['DBHost'] = '';
    $GLOBALS['NA_CONFIG']['DBUser'] = '';
    $GLOBALS['NA_CONFIG']['DBPass'] = '';
    $GLOBALS['NA_CONFIG']['DBDatabase'] = '';

    /*
     * $GLOBALS['NA_CONFIG']['version'] enthält die aktuelle Version dieser
     * Software und muss nicht geändert werden.
     *
     * Mit $GLOBALS['NA_CONFIG']['checkForUpdates'] kann eingestellt werden ob
     * die Software nach Updates sucht.
     * Damit die Software nach der neuesten Version suchen kann muss
     * PHP die Option allow_url_fopen erlauben
     *
     * oder
     *
     * die Bibliothek cURL muss installiert sein.
     * Ist beides nicht möglich, sollte $GLOBALS['NA_CONFIG']['versionize']
     * auf false gesetzt werden.
     */
    $GLOBALS['NA_CONFIG']['version'] = '2.0';
    $GLOBALS['NA_CONFIG']['checkForUpdates'] = true;

    /*
     * relativer Pfad zum root-Verzeichnis,
     * beginnt und endet mit Slash "/" bei Unterverzeichnissen (z.B.: "/newsletter_assistent/"),
     * sonst ist das root-Verzeichnis nur ein Slash
     */
    $GLOBALS['NA_CONFIG']['na_path'] = "/";

    /*
     * Die Software kann auch ohne zu speichern (ohne Datenbank) verwendet werden.
     * Dazu einfach $GLOBALS['NA_CONFIG']['versionize'] auf false setzen.
     */
    $GLOBALS['NA_CONFIG']['versionize'] = true;

    /*
     * Set word wrap (integer, 0 means word wrap is disabled)
     */
    $GLOBALS['NA_CONFIG']['wordWrap'] = 0;

?>