<?php
	session_start();
	$uid = $_SESSION['uID'];
	require_once("../model/activity_info_operation.php");
	$identity = get_identity_by_register_ID($uid);
	if($identity==2)
	{
		$id = $_GET['id'];
		delete_activity($id);
		header("Location: ../views/activity_page.php?i=1");
	}
	else
	{
		header("Location: ../index.php");
	}
?>