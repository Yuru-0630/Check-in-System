<?php
	$host = 'localhost';
	$username = 'etutor';
	$password = 'etutor';
	$db = 'etutor';
	$con = mysqli_connect($host, $username, $password, $db) or die('Error with MySQL connection'); 
	mysqli_query($con,"SET NAMES utf8");

	function register1062($username, $password, $identity)
	{
		global $con;
		date_default_timezone_set('Asia/Taipei');
		$datetime = date("Y-m-d H:i:s");
		$query = "INSERT INTO register (identity,username,password,image,registered_time,state) values ($identity,'$username','$password','icon/user_no_img.png','$datetime',1)";
		mysqli_query($con,$query);
	}

	function update_register1062($id,$username, $password)
	{
		global $con;
		$query = "UPDATE register SET username = '$username' , password = '$password' WHERE ID=$id";
		mysqli_query($con,$query);
	}

	function get_newest_register_Info()
	{
		global $con;
		$query = "SELECT * FROM register ORDER BY ID desc";
		$result = mysqli_query($con,$query);
		return mysqli_fetch_assoc($result);
	}

	function companion1062_register($name,$department,$grade,$student_ID_number,$student_ID_card_number)
	{
		register1062("tmp","tmp",4);
		$last_ID = get_newest_register_Info()['ID'];
		update_register1062($last_ID,"com1062register".$last_ID."kyl653z","com1062register".$last_ID."kyl653z");
		global $con;
		$query = "INSERT INTO companion (name,register_ID,department_ID,grade,student_ID_number,student_ID_card_number,isServing) values ('$name',$last_ID,$department,$grade,'$student_ID_number','$student_ID_card_number',1)";
		mysqli_query($con,$query);
	}
?>