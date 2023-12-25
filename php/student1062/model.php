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

	function get_newest_register_Info()
	{
		global $con;
		$query = "SELECT * FROM register ORDER BY ID desc";
		$result = mysqli_query($con,$query);
		return mysqli_fetch_assoc($result);
	}

	function student1062_register($name,$sex,$school_ID,$grade)
	{
		$last_ID = get_newest_register_Info()['ID'];
		register1062("stu1062register".($last_ID+1)."cpl729a","stu1062register".($last_ID+1)."cpl739a",5);
		$register_ID = $last_ID+1;
		global $con;
		$query = "INSERT INTO student (register_ID,school_ID,name,grade,sex,state) values ($register_ID,$school_ID,'$name',$grade,'$sex',1)";
		mysqli_query($con,$query);
	}
?>