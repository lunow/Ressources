<?
	//EINSTELLUNGEN
	define('PATH_TO_SERVER_ROOT_DIR', '/Users/paul/Projekte');
	
	require_once('class-folder-php/class.folder.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
	<head>
		<title>Ressourcen</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="_res/style.css" />
		<link rel="stylesheet" href="_res/jquery-ui-1.7.2.custom.css" />
		
		<script src="_res/jquery.min.js" language="javascript" type="text/javascript"></script>
		<script src="_res/jquery-ui-1.7.2.custom.min.js" language="javascript" type="text/javascript"></script>
		<script src="_res/jquery.hotkeys.js" language="javascript" type="text/javascript"></script>
		<script src="_res/jquery.flash.js" language="javascript" type="text/javascript"></script>
		
		<script src="_res/CodeMirror/js/codemirror.js" language="javascript" type="text/javascript"></script>
		<link rel="stylesheet" href="_res/CodeMirror/css/docs.css">
		
		<script src="_res/jquery.jgrowl.min.js" language="javascript" type="text/javascript"></script>
		<link rel="stylesheet" href="_res/jquery.jgrowl.css" />
		
		<!--
			<script src="_res/BespinEmbedded.js" language="javascript" type="text/javascript"></script>
			<link rel="stylesheet" href="_res/BespinEmbedded.css" />
		-->
		<script src="_res/ressourcen.js" language="javascript" type="text/javascript"></script>
		
		
	</head>
	<body>
		<div id="left">
			<?
				$folders = new Folder(PATH_TO_SERVER_ROOT_DIR.$_SERVER['REQUEST_URI']);
				$folders->onlyDir();
				$folders->search('[!_res]*');
			?>
			<ul class="folders">
				<? foreach($folders as $folder): ?>
					<li class="folder">
						<a href="<?=$folders->name()?>/" rel="<?=urlencode($folder)?>">
							<?=$folders->name()?>
						</a>
					</li>
				<? endforeach; ?>
				<li class="folder add">
					<a href="#" rel="_new">Neues Projekt...</a>
				</li>
			</ul>
		</div>
		
		<div id="right">
			
			<div class="new">
				<ul>
					<li><a href="#new">Neues Projekt</a></li>
				</ul>
				<div id="new">
					<div class="head">
						<label>Ordner und Dateiname:</label>
						<input type="text" name="path" class="path" />
					</div>
					<textarea id="newcode"></textarea>
				</div>
			</div>
			
			<div class="content">
				<ul>
					<!--<li><a href="#index">Index</a></li>-->
					<li><a href="#code">Quelltext</a></li>
					<li><a href="#test">Test</a></li>
					<li><a href="#doku">Dokumentation</a></li>
				</ul>
				<!--<div id="index">
					
				</div>-->
				<div id="code">
					<div class="head">
						<h1>[unset]</h1>
						<div class="download">
							<p>Code kopieren:</p>
							<div id="clippy"></div>
							<span class="clear"></span>
						</div>
						<!--<div class="git">
							<label>
								Git Repository
								<input type="checkbox" />
								<span class="cloneurl"></span>
							</label>
						</div>-->
						<span class="clear"></span>
					</div>					
					<code id="codetxt"></code>
				</div>
				
				<div id="doku"></div>
				
				<div id="test">
					<code id="testcode">//Test hier initialisieren</code>
					<div id="testresponse">0/0 Tests gelaufen</div>
					<div class="clear"></div>
				</div>
			</div>	
		</div>
	</body>
</html>
