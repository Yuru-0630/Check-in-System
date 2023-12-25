<?php
	session_start();
	$uid = $_SESSION['uID'];
	require_once("../model/get_user_info.php");
	$identity = get_identity_by_register_ID($uid);
	if($identity==2)
	{
		$id = $_GET['id'];
		$user_identity = $_GET['identity'];
		delete_user_info($id,$user_identity);
		header("Location: ../views/user.php?i=1");
	}
	else
	{
		header("Location: ../index.php");
	}
?>