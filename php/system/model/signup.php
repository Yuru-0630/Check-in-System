<?php
	require_once("get_user_info.php");

	function confirm_password($password , $password_r)
	{
		if($password == $password_r)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	function check_user_exist($username)
	{
		global $con;
		$_username = mysqli_real_escape_string($con,$username);
		$query = "SELECT * FROM register WHERE username='$_username'";
		$result = mysqli_query($con,$query);
		while($row = mysqli_fetch_assoc($result))
		{
			if(strcmp($row['username'],$_username)==0)
			{
				return 1;
			}
		}
		return 0;
	}

	function register($username, $password, $identity)
	{
		global $con;
		date_default_timezone_set('Asia/Taipei');
		$datetime = date("Y-m-d H:i:s");
		$query = "INSERT INTO register (identity,username,password,image,registered_time,state) values ($identity,'$username','$password','icon/user_no_img.png','$datetime',0)";
		mysqli_query($con,$query);
	}

	function companion_register($username,$password,$name,$department,$grade,$student_ID_number,$student_ID_card_number)
	{
		register($username,$password,4);
		$register_ID = get_register_ID($username);
		global $con;
		$query = "INSERT INTO companion (name,register_ID,department_ID,grade,student_ID_number,student_ID_card_number,isServing) values ('$name',$register_ID,$department,$grade,'$student_ID_number','$student_ID_card_number',1)";
		mysqli_query($con,$query);
	}

	function teacher_register($username,$password,$name,$school_ID)
	{
		register($username,$password,3);
		$register_ID = get_register_ID($username);
		global $con;
		$query = "INSERT INTO teacher (name,register_ID,school_ID,isServing) values ('$name',$register_ID,$school_ID,1)";
		mysqli_query($con,$query);
	}



?>
