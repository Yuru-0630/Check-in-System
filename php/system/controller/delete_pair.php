<?php
	session_start();
	$uid = $_SESSION['uID'];
	require_once("../model/get_pair_info.php");
	$identity = get_identity_by_register_ID($uid);
	if($identity==2)
	{
		$id = $_GET['id'];
		delete_pair_info($id);
		header("Location: ../views/pair.php?i=1");
	}
	else
	{
		header("Location: ../index.php");
	}
?>