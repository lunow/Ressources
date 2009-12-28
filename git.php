<?php
	
	try {
		
		$name = urldecode($_GET['name']);
		if(!$name)
			throw new Exception('Keinen Pfad übergeben.');
		
		switch($_GET['action']) {
			
			case 'add':
				//exec('cd '+$name, $output, $len);
				//echo var_dump($output)."\n ==== \n";
				substr($name, -1);
				echo '\\'.$name.' git init'."\n";
				$output = shell_exec('\\'.$name.' git init');
				echo var_dump($output)."\n ==== \n";
				/*
				exec('rm .git -r', $output, $len);
				echo var_dump($output)."\n ==== \n";
				exec('git init', $output, $len);
				echo var_dump($output)."\n ==== \n";
				exec('git add .', $output, $len);
				echo var_dump($output)."\n ==== \n";
				exec('git commit -m "First automated Commit"', $output, $len);
				echo var_dump($output)."\n ==== \n";*/
				echo json_encode(array('success' => true));
				break;
			
			default:
				throw new Exception('Aktion '.$_GET['action'].' ist unbekannt.');
		}
	
	} catch(exception $e) {
		echo json_encode(array('success' => false, 'message' => $e->getMessage()));
	}

?>