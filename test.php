<?php
	
	require_once('class-folder-php/class.folder.php');
	
	
	if(isset($_GET['name'])) {
		/*
		 *	Daten per GET Abfragen
		 */
		$path = urldecode($_GET['name']).'test/';
		
		switch($_GET['get']) {
			case 'code':
				
				if(is_dir($path) == false) {
					$files = new Folder(urldecode($_GET['name']), '*.php');
					$defaultcode = "<?php
	require_once('../../_res/simpletest/autorun.php');
	require_once('../".$files->name()."');
	
	/**
	 * Neuer Testcode
	 *
	 * Diese Klasse beinhaltet alle Tests zu diesem Projekt.
	 */
	class TestOfSomething extends UnitTestCase {
		function testSomething() {
		}
	}

?>";
					
					mkdir($path, 0777);
					$fh = fopen($path.'testcode.php', 'w+');
					fwrite($fh, $defaultcode);
					fclose($fh);
				}
				
				$files = new Folder($path, 'testcode.php');
				$content = file_get_contents($files->get(0));
				echo $content;
				break;
			
			case 'result':
				header('Location: '.$path.'testcode.php');
				break;
		}
	}
	elseif(isset($_POST['name'])) {
		/*
		 *	Inhalt per POST schreiben
		 */
		$path = urldecode($_POST['name']).'test/';
		$fh = fopen($path.'testcode.php', 'w+');
		fwrite($fh, stripslashes($_POST['content']));
		fclose($fh);
		echo json_encode(array('success' => true, 'message' => ''));
	}

?>