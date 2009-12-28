var editor = '';
var save_action = function() {};
var clipboard_content = '';

jQuery(function($) {
	$('.folders .folder a').live('click', function() {
		if($(this).attr('rel') == '_new') {
			new_project();
		}
		else {
			load($(this));
		}
		return false;
	});
	
	$('#code .git :checkbox').click(function() {
		if($(this).is(':checked')) {
			git('add', $('.folders .active').attr('rel'));
		}
		else {
			git('remove', $('.folders .active').attr('rel'));
		}
	});
		
	$.jGrowl('Hallo Welt');
});


function git(action, name) {
	$.ajax({
		url: 'git.php',
		data: {name: name, action: action},
		type: 'GET',
		dataType: 'json',
		success: function(j) {
			if(j.success && action == 'add') {
				$.jGrowl('Git Repository angelegt');
				//$('#code .git .cloneurl').hide().html(j.cloneurl).fadeIn();
			}
			else if(j.success && action == 'remove') {
				$.jGrowl('Git Repository entfernt.');
				$('#code .git .cloneurl').fadeOut();
			}
			else {
				$.jGrowl('Fehler im Gitmodul:<br><i>'+j.message+'</i>', {sticky: true});
			}
		}
	});
}

function new_project() {
	$('.content').hide();
	$('.folders').find('.active').removeClass('active').end().find('li.add a').addClass('active');
	
	$('.new').tabs().fadeIn(function() {
		$(this).find(':input:first').focus();
	});
	make_editor($('#newcode'), '//Neuer Inhalt');
	set_save_action(function() {
		$.ajax({
			url: 'new.php',
			data: {name: $('input.path').val(), content: editor.getCode()},
			type: 'POST',
			dataType: 'json',
			success: function(j) {
				if(j.success) {
					window.location.reload();
				}
				else {
					$.jGrowl("Neues Projekt konnte nicht angelegt werden.", {sticky: true});
				}
			}
		});
	});
}


function load($a) {
	path = $a.attr('rel');
	name = $a.attr('href');
	$a.closest('ul').find('li>a.active').removeClass('active').end().end().addClass('active');
	$('#right .new').hide();
	$('#right')
		.find('.content')
			.hide()
			.tabs('destroy')
			.fadeIn()
			.tabs({
				show: function(event, ui) {
					switch($(ui.tab).attr('href').substr(1, $(ui.tab).attr('href').length)) {						
						case 'code':
							get_file(name);
							create_index(name);
							break;
						
						case 'doku':
							get_documentation(path);
							break;
						
						case 'test':
							load_tests(name);
							break;
					}
				}
			});
}

function create_index(name) {
	displayname = name.substr(0, name.length-1);
	$('#code :header:first').text(displayname);
	$('#clippy').html('').flash({
		src: '_res/clippy.swf',
		width: '110',
		height: '14',
		flashvars: {
			text: clipboard_content
		}
	});
}

function load_tests(name) {
	$.ajax({
		url: 'test.php',
		data: {get: 'code', name: name},
		type: 'GET',
		dataType: 'html',
		success: function(content) {
			$('#testcode').html(content);
			make_editor($('#testcode'), content);
			set_save_action(function() {
				save_testcode(name);
				refresh_testresult(name);
			});
			$.jGrowl('Tests geladen.');
		}
	});
	refresh_testresult(name);
}

function save_testcode(name) {
	$.ajax({
		url: 'test.php',
		data: {name: name, content: editor.getCode()},
		type: 'POST',
		dataType: 'json',
		success: function(j) {
			if(!j.success) {
				$.jGrowl("Fehler beim Speichern.\n"+j.message);
			}
			else {
				$.jGrowl('Test gespeichert.');
			}
		}
	});
}

function save_filecode(name) {
	$.ajax({
		url: 'code.php',
		data: {name: name, content: editor.getCode()},
		type: 'POST',
		dataType: 'json',
		success: function(j) {
			if(!j.success) {
				$.jGrowl("Fehler beim Speichern.\n"+j.message);
			}
			else {
				$.jGrowl('Datei gespeichert.');
			}
		}
	});
}

function refresh_testresult(name) {
	$('#testresponse').hide();
	$.ajax({
		url: 'test.php',
		data: {get: 'result', name: name},
		type: 'GET',
		dataType: 'html',
		success: function(content) {
			$('#testresponse').html('<div class="wrap">'+content+'</div>').fadeIn();
			$.jGrowl('Testresultate aktualisiert.');
		}
	});
}

function set_save_action(func) {
	save_action = func;
}

function get_file(name) {
	$.ajax({
		url: 'code.php',
		data: {name: name},
		type: 'GET',
		dataType: 'html',
		success: function(content) {
			$('#codetxt').html(content);
			clipboard_content = content;
			make_editor($('#codetxt'), content);
			create_index(name);
			set_save_action(function() {
				save_filecode(name);
			});
			$.jGrowl('Quelltext '+name+' geladen.');
		}
	});
}

function get_documentation(path) {
	$('#doku').html('<i>Dokumentation wird generiert...</i>');
	$.ajax({
		url: 'documentation.php',
		data: {path: path},
		type: 'GET',
		dataType: 'html',
		success: function(content) {
			$('#doku').html(content);
			$.jGrowl('Dokumentation aktualisiert.');
		}
	});
}

function make_editor($target, content) {
	$('.CodeMirror-wrapping').remove();
	window.setTimeout(function() {
		editor = CodeMirror.fromTextArea($target.attr('id'), {
			path: '_res/CodeMirror/js/',
			//parserfile: 'parsexml.js',
			parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js",
	                 "../contrib/php/js/tokenizephp.js", "../contrib/php/js/parsephp.js",
	                 "../contrib/php/js/parsephphtmlmixed.js"],
			stylesheet: ["_res/CodeMirror/css/xmlcolors.css", "_res/CodeMirror/css/jscolors.css", "_res/CodeMirror/css/csscolors.css", "_res/CodeMirror/css/phpcolors.css"],
			content: content,
			height: '100%',
			lineNumbers: true,
			saveFunction: function() {
				save_action.call();
				return false;
			}
		});
	}, 100);
}