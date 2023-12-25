<?php
	session_start();
	$uid = $_SESSION['uID'];
	require_once("../model/activity_info_operation.php");
	$identity = get_identity_by_register_ID($uid);
	if($identity==2)
	{
		$act = $_GET['act'];
		$id = $_GET['id'];
		$activity_ID = $_GET['actID'];
		if($act=='signin')
		{
			manual_check_in($id);
		}
		else if($act=='delete')
		{
			delete_activity_attendance_record($id);
		}
		header("Location: ../views/activity_attendance_page.php?i=1&id=".$activity_ID);
	}
	else
	{
		header("Location: ../index.php");
	}
?>