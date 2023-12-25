<?php
	require_once("get_user_info.php");
	$state = array(
			0 => "號碼尚未註冊",
			1 => "未簽到",
			2 => "已簽到");
	
	/*
	$state_unused = array(
			0 => "號碼尚未註冊",
			1 => "未簽到",
			2 => "已簽到，無登入課程系統",
			3 => "無簽到，已登入課程系統",
			4 => "已簽到，已登入課程系統",
			5 => "無簽到，已過課程時間");
	*/

	function get_now_datetime_for_db()
	{
		date_default_timezone_set('Asia/Taipei');
		$datetime = date("Y-m-d H:i:s");
		return $datetime;
	}

	function get_Num_of_Info($table_name)
	{
		global $con;
		$query = "SELECT * FROM ".$table_name;
	    $result = mysqli_query($con,$query);
	    return mysqli_num_rows($result);
	}

	function get_Num_of_Info_with_ID($table_name,$id)
	{
		global $con;
                $query = "SELECT * FROM ".$table_name." WHERE class_ID = $id";
            $result = mysqli_query($con,$query);
            return mysqli_num_rows($result);
	}

	function get_Info_desc_in_range($table_name,$start,$end)
	{
		global $con;
		$offset = $start-1;
		$data_length = $end-$start+1;
	    $query = "SELECT * FROM ".$table_name." ORDER BY ID desc LIMIT $data_length OFFSET $offset";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_class_attendance_Info_list_in_range($class_id,$start,$end)
	{
		$array_list = array();
		global $con;
		$offset = $start-1;
		$data_length = $end-$start+1;
	    $query = "SELECT * FROM class_attendance";
	    $result = mysqli_query($con,$query);
	    while ($array = mysqli_fetch_assoc($result)) 
	    {
	    	if($array['class_ID']==$class_id)
	    	{
	    		array_push($array_list, $array);
	    	}
	    }
	    return $array_list;
	}

	function add_class($class_date,$class_day,$starting_time,$ending_time,$note)
	{
		global $con;
		$query = "INSERT INTO class (class_date,day,starting_time,ending_time,note) values ('$class_date',$class_day,'$starting_time','$ending_time','$note')";
		mysqli_query($con,$query);
	}

	function delete_class($id)
	{
		global $con;
		$query = "DELETE FROM class WHERE ID = $id";
	    $result = mysqli_query($con,$query);
	}

	function get_newest_class_Info()
	{
		global $con;
		$query = "SELECT * FROM class ORDER BY ID desc";
		$result = mysqli_query($con,$query);
		return mysqli_fetch_assoc($result);
	}

	function add_companion_to_class($class_ID)
	{
		global $con;
		$query = "SELECT * FROM companion WHERE isServing = 1";
		$result = mysqli_query($con,$query);
		while($array = mysqli_fetch_assoc($result))
		{
			$companion_ID = $array['ID'];
			$query2 = "SELECT * FROM pair WHERE companion_ID='$companion_ID'";
			$result2 = mysqli_query($con,$query2);
			while ($array2 = mysqli_fetch_assoc($result2)) 
			{
				$query3 = "SELECT day FROM class WHERE ID = $class_ID";
				$result3 = mysqli_query($con,$query3);
				$row = mysqli_fetch_row($result3);
				if($array2['day']==$row[0])
				{
					$query4 = "INSERT INTO class_attendance (class_ID,companion_ID,state) values ($class_ID,$companion_ID,1)";
					mysqli_query($con,$query4);
				}
			}
		}
	}

	function delete_class_attendance_record($id)
	{
		global $con;
		$query = "DELETE FROM class WHERE ID = $id";
	    mysqli_query($con,$query);
	    $query2 = "DELETE FROM class_attendance WHERE class_ID = $id";
	    mysqli_query($con,$query2);
	}

	function manual_check_in($id)
	{
		global $con;
		$datetime = get_now_datetime_for_db();
		$query = "UPDATE class_attendance SET state = 2,time_sign_in = '$datetime' WHERE ID = $id";
		mysqli_query($con,$query);
	}

	function class_check_in($class_ID,$student_ID_card_number)
	{
		global $con;
		$_student_ID_card_number = mysqli_real_escape_string($con,$student_ID_card_number);
		$query = "SELECT ID FROM companion WHERE student_ID_card_number = $_student_ID_card_number";
		$result = mysqli_query($con,$query);
		if($row = mysqli_fetch_row($result))
		{
			$companion_ID = $row[0];
		}
		else
		{
			return 0;
		}
		$query2 = "SELECT state FROM class_attendance WHERE class_ID = $class_ID AND companion_ID = $companion_ID";
		$result2 = mysqli_query($con,$query2);
		if($row2 = mysqli_fetch_row($result2))
		{
			if($row2[0]==2)
			{
				return 9;
			}
			else
			{
				$datetime = get_now_datetime_for_db();
				$query3 = "UPDATE class_attendance SET state = 2 , time_sign_in = '$datetime' WHERE class_ID = $class_ID AND companion_ID = $companion_ID";
				mysqli_query($con,$query3);
				return 2;
			}
		}
		else
		{
			return -1;
		}
	}
	
?>
