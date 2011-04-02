<?php
list($file,$server,$_SERVER['REQUEST_METHOD'],$params) = json_decode(stream_get_contents(STDIN));

$old_server = $_SERVER;
$_SERVER = array();
// 'GATEWAY_INTERFACE','PATH_INFO','QUERY_STRING','REMOTE_ADDR','REQUEST_METHOD','REQUEST_URI','SCRIPT_NAME','SERVER_NAME','SERVER_PORT','SERVER_PROTOCOL','SERVER_SOFTWARE','HTTP_HOST','HTTP_USER_AGENT','HTTP_ACCEPT','HTTP_CACHE_CONTROL','HTTP_ACCEPT_LANGUAGE','HTTP_ACCEPT_ENCODING','HTTP_CONNECTION'
foreach(array('GATEWAY_INTERFACE','PATH_INFO','QUERY_STRING','REMOTE_ADDR','REQUEST_METHOD','REQUEST_URI','SCRIPT_NAME','SERVER_NAME','SERVER_PORT','SERVER_PROTOCOL','SERVER_SOFTWARE','HTTP_HOST','HTTP_USER_AGENT','HTTP_ACCEPT','HTTP_ACCEPT_LANGUAGE','HTTP_ACCEPT_ENCODING','HTTP_CONNECTION') as $key) {
	$_SERVER[$key] = $server->$key;
}

$_SERVER = array_merge($_SERVER,array(
	'SERVER_SIGNATURE' => "phrooby 0.0.0 ({$old_server['RUBY_VERSION']})",
	//'REMOTE_PORT
	'REQUEST_TIME' => $old_server['REQUEST_TIME'],
	'SCRIPT_FILENAME' => $file,
	'SCRIPT_NAME' => '/'.basename($file),
	'DOCUMENT_ROOT' => dirname($file),
	'argv' => array(),
	'argc' => '0'
));

chdir(dirname($file));
include($file);
//print_r($_SERVER);
/*
Keys which haven't been dealt with yet:
$_SERVER = array(
	'PATH' => '/usr/bin:/bin:/usr/sbin:/sbin',
	'SERVER_ADDR' => '127.0.0.1',
	'SERVER_ADMIN' => 'you@example.com',
	'REMOTE_PORT' => '62874',
	'QUERY_STRING' => '',
	'REQUEST_URI' => '/prepare.php',
	'PHP_SELF' => '/prepare.php',
	'argv' => [],
	'argc' => '0',
	'REMOTE_HOST'
);*/

