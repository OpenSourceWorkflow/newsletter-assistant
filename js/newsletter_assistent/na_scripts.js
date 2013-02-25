jQuery(document).ready(function($) {
    

    // Status der Tipps
    state_hints = $.cookie('state_hints');
    if(state_hints != "true"){
	$('#hints ul').slideDown('fast', function() {
	    $('#toggle_hints').text("-");
	});
    } else {
	$('#hints ul').slideUp(0, function() {
	    $('#toggle_hints').text("+");
	});
    }
    $('#toggle_hints').click(function() {
	current_state_hints = $.cookie('state_hints');
	$('#hints ul').slideToggle('fast', function() {
	    if (current_state_hints == "true"){
		$.cookie('state_hints', 'false', { expires: 999});
		$('#toggle_hints').text("-");
	    } else {
		$.cookie('state_hints', 'true', { expires: 999});
		$('#toggle_hints').text("+");
	    }
	  });
	  return false;
    });


    if(no_projects){
	$('#toggle_management').css("display","none");
	$('#more_options').slideDown('fast', function() {
		$('#toggle_management').text("-");
	    });

    } else {

    // Status des Managementbereichs
	state_management = $.cookie('state_management');
	if(state_management != "true"){
	    $('#more_options').slideDown('fast', function() {
		$('#toggle_management').text("-");
	    });
	} else {
	    $('#more_options').slideUp(0, function() {
		$('#toggle_management').text("+");
	    });
	}
	$('#toggle_management').click(function() {
	    current_state_management = $.cookie('state_management');
	    $('#more_options').slideToggle('fast', function() {
		if (current_state_management == "true"){
		    $.cookie('state_management', 'false', { expires: 999});
		    $('#toggle_management').text("-");
		} else {
		    $.cookie('state_management', 'true', { expires: 999});
		    $('#toggle_management').text("+");
		}
	      });
	      return false;
	});
    }


    // Status des Plain-Text-Eingabeformulars
    state_plain = $.cookie('state_plain');
    if(state_plain == "true"){
	$('#plain').slideDown('fast', function() {
	    $('#toggle_plain').text("-");
	});
    } else {
	$('#plain').slideUp(0, function() {
	    $('#toggle_plain').text("+");
	});
    }
    $('#toggle_plain').click(function() {
	current_state_plain = $.cookie('state_plain');
	$('#plain').slideToggle('fast', function() {
	    if (current_state_plain == "true"){
		$('#toggle_plain').text("+");
		$.cookie('state_plain', 'false', { expires: 999});
	    } else {
		$.cookie('state_plain', 'true', { expires: 999});
		$('#toggle_plain').text("-");
	    }
	  });
	  return false;
    });


    // Rückmeldung ausblenden bei Erfolg
    $('#infos').delay(3000).fadeOut(400);


    // textarea vergrößern
    state_textarea = $.cookie('state_textarea');

    $('#plus_box').click(function() {

        $(".CodeMirror-wrapping").height(state_textarea);
        var height = $(".CodeMirror-wrapping").height()+20;
        $(".CodeMirror-wrapping").remove();
        codemirror(height);
        $.cookie('state_textarea', height, { expires: 999});
        return false;
    });

    $('#minus_box').click(function() {
        $(".CodeMirror-wrapping").height(state_textarea);
        var height = $(".CodeMirror-wrapping").height()-20;
        $(".CodeMirror-wrapping").remove();
        codemirror(height);
        $.cookie('state_textarea', height, { expires: 999});
        return false;
    });

    // Code Mirror
    function codemirror(height){
        
        var editor = CodeMirror.fromTextArea('html', {
            parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
            stylesheet: ["css/codemirror/xmlcolors.css", "css/codemirror/jscolors.css", "css/codemirror/csscolors.css"],
            path: "js/codemirror/",
            height: height+"px",
            lineNumbers: true,
            reindentOnLoad: true
        });
    }
    codemirror(state_textarea);

    // Colorbox
    $("#feedbacklink").colorbox({
            transition:"none",
            width:"605px",
            height:"475px",
            inline:true,
            opacity:0.45,
            open:false,
            href:"#feedbackform"
    });

    // Feedback senden
     $('#send_feedback').click(function() {

         var infos = $("#feedback_text").val();
         if (infos){
             $("#feedbackform p").remove();
             $.ajax({
               type: "POST",
               url: "system/feedback.php",
               data: "infos=" + infos,
               success: function(infos){
                $('#feedbackform form').fadeOut('fast', function() {
                    $('#feedbackform').append('<p>Danke für die Rückmeldung.</p>');
                });

               }
             });
         } else {
             $('#feedbackform h2').after('<p>Das Eingabefeld ist noch leer!</p>');
             $('#feedbackform textarea').attr('cols', '10');
             $('#feedbackform textarea').css('height', '210px');
         }
         return false;
     });
});
