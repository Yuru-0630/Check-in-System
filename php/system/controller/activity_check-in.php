<?php
	require_once("../model/activity_info_operation.php");
	if(isset($_POST['student_ID_number']) && !empty($_POST['student_ID_number']))
	{
		$activity_id = $_POST['activity_id'];
		$msg = activity_check_in($activity_id,$_POST['student_ID_number']);
		echo $msg;
	}
	else
	{
		echo -2;
	}
?>