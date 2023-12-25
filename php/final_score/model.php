<?php
	$host = 'localhost';
	$username = 'etutor';
	$password = 'etutor';
	$db = 'etutor';
	$con = mysqli_connect($host, $username, $password, $db) or die('Error with MySQL connection'); 
	mysqli_query($con,"SET NAMES utf8");


	function get_department_Info_by_ID($id)
	{
		global $con;
	    $query = "SELECT name FROM department WHERE ID=$id";
	    $result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    return $row[0];
	}

	function get_companion_ID_by_student_ID_card_number($student_ID_card_number)
	{
		global $con;
		$query = "SELECT ID FROM companion WHERE student_ID_card_number=$student_ID_card_number";
		$result = mysqli_query($con,$query);
		if ($row = mysqli_fetch_row($result))
		{
			return $row[0];
		}
		else
		{
			return -1;
		}
	}

	function get_level_by_companion_ID($companion_ID)
	{
		global $con;
		$query = "SELECT level FROM final_score WHERE companion_ID=$companion_ID";
		$result = mysqli_query($con,$query);

		if ($row = mysqli_fetch_row($result))
		{
			return $row[0];
		}
		else
		{
			return -1;
		}
	}
?>