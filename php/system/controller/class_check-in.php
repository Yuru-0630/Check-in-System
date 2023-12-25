<?php
	require_once("../model/attendance_info_operation.php");
	if(isset($_POST['student_ID_number']) && !empty($_POST['student_ID_number']))
	{
		$class_ID = $_POST['class_ID'];
		$msg = class_check_in($class_ID,$_POST['student_ID_number']);
		echo $msg;
	}
	else
	{
		echo -2;
	}
?>