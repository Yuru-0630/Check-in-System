<?php
	session_start();
	$uid = $_SESSION['uID'];
	require_once("../model/attendance_info_operation.php");
	$identity = get_identity_by_register_ID($uid);
	if($identity==2)
	{
		$act = $_GET['act'];
		$id = $_GET['id'];
		$class_ID = $_GET['cID'];
		if($act=='signin')
		{
			manual_check_in($id);
		}
		else if($act=='delete')
		{
			delete_class_attendance_record($id);
		}
		header("Location: ../views/class_attendance.php?i=1&id=".$class_ID);
	}
	else
	{
		header("Location: ../index.php");
	}
?>