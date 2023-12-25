<?php
	require_once("connect_db.php");
	$identity = array(
			2 => "管理員",
			3 => "帶班老師",
			4 => "大學伴",
			5 => "學生");

	$grade = array(
			11 => "小學一年級",
			12 => "小學二年級",
			13 => "小學三年級",
			14 => "小學四年級",
			15 => "小學五年級",
			16 => "小學六年級",
			21 => "國中一年級",
			22 => "國中二年級",
			23 => "國中三年級",
			31 => "高中一年級",
			32 => "高中二年級",
			33 => "高中三年級",
			41 => "大學部一年級",
			42 => "大學部二年級",
			43 => "大學部三年級",
			44 => "大學部四年級",
			45 => "大學部五年級",
			51 => "研究所一年級",
			52 => "研究所二年級",
			53 => "研究所三年級",
			54 => "研究所四年級",
			60 => "博士班");
	
	function get_register_ID($username)
	{
		global $con;
		$query = "SELECT ID FROM register WHERE username='$username'";
		if ($result = mysqli_query($con,$query))
		{
			if ($row = mysqli_fetch_assoc($result))
			{
				return $row['ID']; 
			}
		}
	}

	function get_department_Info_by_ID($id)
	{
		global $con;
	    $query = "SELECT name FROM department WHERE ID=$id";
	    $result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    return $row[0];
	}

	function get_companion_Info_by_ID($id)
	{
		global $con;
	    $query = "SELECT * FROM companion WHERE ID=$id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function get_companion_Info_desc_in_range($start,$end)
	{
		global $con;
		$offset = $start-1;
		$data_length = $end-$start+1;
	    $query = "SELECT * FROM companion ORDER BY ID desc LIMIT $data_length OFFSET $offset";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_companion_Info_by_register_ID($register_id)
	{
		global $con;
		$query = "SELECT * FROM companion WHERE register_ID=$register_id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function get_Num_of_companion_info()
	{
		global $con;
		$query = "SELECT * FROM companion";
	    $result = mysqli_query($con,$query);
	    return mysqli_num_rows($result);
	}

	function get_register_Info($id)
	{
		global $con;
	    $query = "SELECT * FROM register WHERE ID=$id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function get_all_register_Info()
	{
		global $con;
	    $query = "SELECT * FROM register";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_register_Info_desc_in_range($start,$end)
	{
		global $con;
		$offset = $start-1;
		$data_length = $end-$start+1;
	    $query = "SELECT * FROM register ORDER BY ID desc LIMIT $data_length OFFSET $offset";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_Num_of_register_info()
	{
		global $con;
		$query = "SELECT * FROM register";
	    $result = mysqli_query($con,$query);
	    return mysqli_num_rows($result);
	}

	function get_all_student_Info()
	{
		global $con;
	    $query = "SELECT * FROM student";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_student_Info_by_ID($id)
	{
		global $con;
	    $query = "SELECT * FROM student WHERE ID=$id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
	}
	
	function get_student_Info_by_register_ID($register_id)
	{
		global $con;
		$query = "SELECT * FROM student WHERE register_ID=$register_id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function get_Num_of_school_info()
	{
		global $con;
		$query = "SELECT * FROM partner_school";
	    $result = mysqli_query($con,$query);
	    return mysqli_num_rows($result);
	}

	function get_school_Name($school_id)
	{
		global $con;
	    $query = "SELECT name FROM partner_school WHERE ID=$school_id";
	    $result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    return $row[0];
	}

	function get_all_school_info()
	{
		global $con;
	    $query = "SELECT * FROM partner_school";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_identity_by_register_ID($register_id)
	{
		global $con;
	    $query = "SELECT identity FROM register WHERE ID=$register_id";
	    $result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    return $row[0];
	}

	function confirm_user($register_id)
	{
		global $con;
	    $query = "UPDATE register SET state=1 WHERE ID=$register_id";
	    mysqli_query($con,$query);
	}

	function get_companion_ID_by_student_ID_number($student_ID_number)
	{
		global $con;
	    $query = "SELECT ID FROM companion WHERE student_ID_number='$student_ID_number'";
	    $result = mysqli_query($con,$query);
	    if($row = mysqli_fetch_row($result))
	    {
	    	return $row[0];
	    }
	    else
	    {
	    	return 0;
	    }
	}

	function get_student_ID_number_by_companion_ID($companion_ID)
	{
		global $con;
	    $query = "SELECT student_ID_number FROM companion WHERE ID='$companion_ID'";
	    $result = mysqli_query($con,$query);
	    if($row = mysqli_fetch_row($result))
	    {
	    	return $row[0];
	    }
	    else
	    {
	    	return 0;
	    }
	}

	function get_school_ID_by_student_ID($student_ID)
	{
		global $con;
	    $query = "SELECT school_ID FROM student WHERE ID='$student_ID'";
	    $result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    return $row[0];
	}

	function get_companion_ID_by_name($name)
        {
                global $con;
            $query = "SELECT ID FROM companion WHERE name='$name'";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }

	function get_student_ID_by_name($name)
	{
		global $con;
	    $query = "SELECT ID FROM student WHERE name='$name'";
	    $result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    return $row[0];
	}

	function get_all_student_by_school_ID($school_ID)
	{
		global $con;
	    $query = "SELECT * FROM student WHERE school_ID=$school_ID";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function delete_user_info($id,$user_identity)
	{
		global $con;
		if($user_identity==4)
		{
			$table = "companion";
		}
		else if($user_identity==5)
		{
			$table = "student";
		}
	    $query = "DELETE FROM $table WHERE register_ID=$id";
		mysqli_query($con,$query);
	    $query2 = "DELETE FROM register WHERE ID=$id";
	    mysqli_query($con,$query2);
	}

?>
