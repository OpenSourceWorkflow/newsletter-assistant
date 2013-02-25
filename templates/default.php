<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">

	<head>

		<title>Newsletter Asisstent <?php echo($GLOBALS['NA_CONFIG']['version']); ?> [RC 1]</title>

		<meta name="language" content="de" />

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<link rel="shortcut icon" href="favicon.ico" />
                
		<link href="css/screen.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />

                <link href="css/codemirror/screen.css" rel="stylesheet" type="text/css" media="screen" />
                 <link href="css/colorbox/colorbox.css" rel="stylesheet" type="text/css" media="screen" />

		<script src="js/codemirror/codemirror.js" type="text/javascript"></script>
		<script src="js/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="js/cookies/cookies.js" type="text/javascript"></script>

                <script src="js/newsletter_assistent/na_scripts.js" type="text/javascript"></script>

		<script src="js/colorbox/jquery.colorbox-min.js"></script>


		
		    <script type="text/javascript">
			<?php if (!isset($this->_['projects'][0])){ ?>
			var no_projects = true;
			<?php }else { ?>
			    var no_projects = false;
			<?php } ?>
		    </script>
		
		

	</head>

	<body>
		<div id="container">


			<div id="content">
				
				<h1>Newsletter Asisstent <span><?php echo($GLOBALS['NA_CONFIG']['version']); ?> [RC 1]</span></h1>
                                
				<!-- Neue Version der Software? -->
				<?php
				if (isset($this->_['na_version'])){
				?>
				<p class="info">Die neue Version <?php echo($this->_['na_version']); ?> ist jetzt auf der <a href="http://www.visiongraphix.de/html-newsletter-assistent.html" title="zur Projekt-Website">Projekt-Website</a> verfügbar.</p>
				<?php
				}
				?>

				<!-- Fehler? -->
				<?php
				if (isset($this->_['errors'][0])){
				?>
				<ul id="errors">
				<?php
				    foreach($this->_['errors'] as $error){
				?>
				<li><?php echo $error['errors']; ?></li>
				<?php
				    }
				    ?>
				</ul>
				<?php
				}
				?>


                                <!-- Hinweise? -->
				<?php
				if (isset($this->_['infos'][0]) && !isset($this->_['errors'][0])){
				?>
				<ul id="infos">
				<?php
				    foreach($this->_['infos'] as $info){
				?>
				<li><?php echo $info['infos']; ?></li>
				<?php
				    }
				    ?>
				</ul>
				<?php
				}
				?>
                                
                                
                                

			    <form action="<?php echo $GLOBALS['NA_CONFIG']['na_path']?>" method="post">

				<?php if($GLOBALS['NA_CONFIG']['versionize']){ ?>
				<fieldset id="management">
				    <a href="#" id="toggle_management" title="erweiterte Funktionen anzeigen">+</a>
				    
				    <div class="col">
					<!-- Projekte auswählen -->
					<?php if (isset($this->_['projects'][0])){ ?>
					<label for="projects">Projekte:</label>
					<select id="projects" name="project">
					    <?php
					    foreach($this->_['projects'] as $project){
					    ?>
						<option <?php if($project['id'] == $this->_['project']){ echo ("selected=\"selected\"");} ?> value="<?php echo $project['id'] ?>"><?php echo $project['name']; ?></option>
					    <?php
					    }
					    ?>
					</select>
					<button name="view" value="projects">auswählen</button>
					<?php } ?>
				    </div> <!-- col -->

				    <div class="col">
				    <!-- Version auswählen -->
					<?php if (isset($this->_['versions'])){ ?>
					<label for="versions">Versionen:</label>
					 <select id="versions" name="version">
					    <?php
					    foreach($this->_['versions'] as $version){
					    ?>
						<option <?php if($version['id'] == $this->_['version']){ echo ("selected=\"selected\"");} ?> value="<?php echo $version['id'] ?>" ><?php echo $version['dates']; ?></option>
					    <?php
					    }
					    ?>
					</select>
					<button name="view" value="versions">bearbeiten</button>
					<?php } ?>
				    </div> <!-- col -->


				    <div id="more_options">
					<div class="col">
					    <!-- neues Projekt speichern -->
					    <label for="new_project">neues Projekt:</label>
					    <input type="text" id="new_project" name="new_project_name" />
					    <button name="view" value="new_project">speichern</button>
					</div> <!-- col -->
					<div class="col">
					<!-- Projekt löschen -->
					    <?php if (isset($this->_['projects'][0])){ ?>
					    <label for="del_projects">Projekt löschen:</label>
					    <select id="del_projects" name="del_project_id">
						<?php
						foreach($this->_['projects'] as $project){
						?>
						    <option <?php if($project['id'] == $this->_['project']){ echo ("selected=\"selected\"");} ?> value="<?php echo $project['id'] ?>"><?php echo $project['name']; ?></option>
						<?php
						}
						?>
					    </select>
					    <button name="view" value="del_projects">löschen</button>
					     <?php } ?>
					 </div> <!-- col -->
				    </div> <!-- more_options -->


				</fieldset>
				<?php } ?>





				<!-- Tipps -->
				
				    <?php
				    if (isset($this->_['hintsHTML'][0]) || isset($this->_['hintsPlain'][0])){
				    ?>
				    <div id="hints">
					<a href="#" id="toggle_hints" title="HTML-Newsletter Tipps anzeigen">+</a>
				    <?php
				    if (isset($this->_['hintsHTML'][0]) ){
				    ?>
				    <ul>
				    <?php
					foreach($this->_['hintsHTML'] as $hint){
				    ?>
				    <li><?php echo $hint['hints']; ?></li>
				    <?php
					}
					?>
				    </ul>
					 <?php
					}
					?>


				    <?php
				    if (isset($this->_['hintsPlain'][0])){
				    ?>
				    <ul>
				    <?php
					foreach($this->_['hintsPlain'] as $hint){
				    ?>
				    <li><?php echo $hint['hints']; ?></li>
				    <?php
					}
					?>
				    </ul>
					 <?php
					}
					?>
                                        <a href="#" id="feedbacklink">Tipps nicht mehr aktuell?</a>
				    </div>
				    <?php
				
				    }
				    ?>
				





				<fieldset id="rec">
				    <!-- Empfänger eingeben -->
				    <label for="recipients">Empfänger:</label>
				    <input type="text" name="recipient" id="recipients" value="<?php echo ($this->_['recipient']); ?>"/>
				</fieldset>

				<fieldset id="html_container">
                                <!-- Editor skalieren -->
                                <ul>
                                    <li><a href="#" title="Arbeitsbereich vergrößern" id="plus_box">+</a></li>
                                    <li><a href="#" title="Arbeitsbereich verkleinern" id="minus_box">-</a></li>
                                </ul>
				<!-- Eingabefeld für das HTML-Template -->
				<label for="html">HTML:</label>
				<textarea id="html" rows="10" cols="20" name="html"><?php echo ($this->_['html']); ?></textarea>
				</fieldset>
				
				<fieldset>
				<a href="#" id="toggle_plain" title="Feld für Plaintext anzeigen">+</a>

                                <!-- Eingabefeld für die Klartextalternative -->
				<label for="plain">Plaintext:</label>
				
				    <textarea id="plain" rows="20" cols="20" name="plain"><?php echo ($this->_['plain']); ?></textarea>
				    
				
				
				</fieldset>
				<?php if (isset($this->_['projects'][0]) || $GLOBALS['NA_CONFIG']['versionize'] == false){ ?>
				<button name="view" value="validate_send" id="absenden">absenden und auswerten</button>
				<?php } ?>
			    </form>
			</div> <!-- content -->
		</div> <!-- container -->
                <div style="display:none;">
                    <div id="feedbackform" >
                        <h2>Feedback</h2>
                        <form action="system/feedback.php" method="post">
                            <label for="feedback_text">Hinweis:</label>
                            <textarea cols="50" id="feedback_text" name="infos"></textarea>
                            <button type="submit" id="send_feedback">absenden</button>
                        </form>
                    </div> <!-- feedbackform-->
                </div>
	</body>
</html>