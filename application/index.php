<?php
session_start(); //session_destroy();
ob_start('ob_gzhandler');
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once('config/config.php');

function urlExcept($url, $listUrl){
	foreach($listUrl as $data){
		if(in_array($url, $data)){
			return $data['file'];
		}
	}
	return false;
}

function getUrl(){
	$uri = $_SERVER['REQUEST_URI'];
	$urlArr = explode('/', $uri);
	$total = count($urlArr);
	
	$alias = '';
	if(isset($urlArr[1])){
		$alias = $urlArr[1];
	}
	
	$other = NULL;
	
	$urlExcept = array(
		array('name'=>'Page Ajax', 'url'=>'ajax', 'file'=>'ajax'),
		array('name'=>'Page Admin', 'url'=>'cp_admin', 'file'=>'admin'),
		array('name'=>'Page Other', 'url'=>'pageother', 'file'=>'other'),
	);
	
	$file = urlExcept($alias, $urlExcept);
	
	if($file==false){
		$file = 'allPage';
	}
	
	for($i=2; $i<count($urlArr); $i++){
		$other[] = $urlArr[$i];
	}
	
	$arr = array(
		'host' => _DOMAIN_,
		'uri' => $uri,
		'file' => $file,
		'alias' => $alias,
		'other' => $other,
	);
	return $arr;
}

$currentUrl = getUrl();

$control = $currentUrl['file'];

$file = "controllers/{$control}.php";

if(file_exists($file)){
	include_once($file);
}else{
	echo 'Not found file controller: '.$file;
}

/*echo '<pre>';
print_r($currentUrl);
echo '</pre>';*/