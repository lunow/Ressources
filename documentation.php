<?php
	$_GET['path'] = urldecode($_GET['path']);
	
	$_phpDocumentor_setting = array(
	 'title' => $_GET['path'],
	 'target' => $_GET['path'].'/doku',
	 'directory' => $_GET['path'],
	 'ignore' => $_GET['path'].'/test',
	 'output' => 'HTML:Smarty:PHP',
	 'quiet' => 'true',
	);
	
	require_once('_res/PhpDocumentor/phpDocumentor/phpdoc.inc');
	$url = $_SERVER['HTTP_REFERER'];
	$parts = explode('/', $_GET['path']);
	$url.= array_pop($parts);
	$url.= '/doku/';
	
	//echo json_encode(array('path' => $url));
	echo '<iframe src="'.$url.'" />';
?>