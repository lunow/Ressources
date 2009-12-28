<?php
	
	require_once('class-folder-php/class.folder.php');
	$files = new Folder(urldecode($_REQUEST['name']), '*.php');
	
	if(isset($_POST['content'])) {
		try {
			$fh = fopen($files->get(0), 'w+');
			
			if(!$fh)
				throw new Exception('Datei '.$files->get(0).' kann nicht geöffnet werden.');
			
			if(!fwrite($fh, stripslashes($_POST['content'])))
				throw new Exception('Datei '.$files->get(0).' konnte nicht beschrieben werden.');
				
			fclose($fh);
			
			echo json_encode(array('success' => true));
		}
		catch(exception $e) {
			echo json_encode(array('success' => false, 'message' => $e->getMessage()));
		}
		die();
	}
	
	$content = file_get_contents($files->get(0));
	echo $content;

?>