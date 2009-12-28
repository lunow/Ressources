<?php
	
	mkdir(dirname($_POST['name']), 0777);
	$fh = fopen($_POST['name'], 'w+');
	fwrite($fh, stripslashes($_POST['content']));
	fclose($fh);
	
	echo json_encode(array('success' => true));

?>