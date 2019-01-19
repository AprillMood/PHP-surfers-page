<?php 
session_start();

if(isset($_GET['command'])) { $cmd = (int)$_GET['command']; }

if ($cmd == 1){
	unset($_SESSION['pageUser']);
	unset($_SESSION['new_id']);
	header("Location: index.php?menu=1");
}

if ($cmd == 2){
	if(isset($_GET['new_id'])) { $aid = (int)$_GET['new_id']; }
	$_SESSION['new_id'] = $aid;
	
	header("Location: index.php?menu=12");
}

?>