<?php
	session_start();
	require_once("../model/get_user_info.php");
	$identity = get_identity_by_register_ID($_SESSION['uID']);
	if($identity==2)
	{
		if(isset($_GET['id']))
		{
			confirm_user($_GET['id']);
		}
		header("Location: ../views/user.php?i=1");
	}
?>