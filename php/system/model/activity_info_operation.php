<?php
	require_once("get_user_info.php");

	function get_now_datetime_for_db()
	{
		date_default_timezone_set('Asia/Taipei');
		$datetime = date("Y-m-d H:i:s");
		return $datetime;
	}

	function get_all_Info_by_ID($table_name,$id)
	{
		global $con;
		$query = "SELECT * FROM ".$table_name." WHERE ID = $id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
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
                $query = "SELECT * FROM ".$table_name." WHERE activity_ID = $id";
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

	function get_activity_attendance_Info_list_in_range($activity_id,$start,$end)
	{
		$array_list = array();
		global $con;
		$offset = $start-1;
		$data_length = $end-$start+1;
	    $query = "SELECT * FROM activity_attendance";
	    $result = mysqli_query($con,$query);
	    while ($array = mysqli_fetch_assoc($result)) 
	    {
	    	if($array['activity_ID']==$activity_id)
	    	{
	    		array_push($array_list, $array);
	    	}
	    }
	    return $array_list;
	}

	function get_newest_activity_Info()
	{
		global $con;
		$query = "SELECT * FROM activity ORDER BY ID desc";
		$result = mysqli_query($con,$query);
		return mysqli_fetch_assoc($result);
	}
	
	function add_all_companion_to_activity($activity_id)
	{
		global $con;
		$query = "SELECT * FROM companion WHERE isServing = 1";
		$result = mysqli_query($con,$query);
		while($array = mysqli_fetch_assoc($result))
		{
			$register_ID = $array['register_ID'];
			$query2 = "INSERT INTO activity_attendance(activity_ID,participant_register_ID,participant_state) values ($activity_id,$register_ID,0)";
			mysqli_query($con,$query2);
		}
	}

	function add_activity($name,$starting_time,$ending_time,$location,$description,$note)
	{
		global $con;
		$query = "INSERT INTO activity (name,starting_time,ending_time,location,description,note) values ('$name','$starting_time','$ending_time','$location','$description','$note')";
		mysqli_query($con,$query);
	}
	
	function delete_activity($id)
	{
		global $con;
		$query = "DELETE FROM activity WHERE ID = $id";
	    $result = mysqli_query($con,$query);
	}

	function delete_activity_attendance_record($id)
	{
		global $con;
		$query = "DELETE FROM activity_attendance WHERE ID = $id";
	    mysqli_query($con,$query);
	}

	function manual_check_in($id)
	{
		global $con;
		$datetime = get_now_datetime_for_db();
		$query = "UPDATE activity_attendance SET participant_state = 1,time_sign_in = '$datetime' WHERE ID = $id";
		mysqli_query($con,$query);
	}

	function activity_check_in($activity_ID,$student_ID_card_number)
	{
		global $con;
		$_student_ID_card_number = mysqli_real_escape_string($con,$student_ID_card_number);
		$query = "SELECT register_ID FROM companion WHERE student_ID_card_number = $_student_ID_card_number";
		$result = mysqli_query($con,$query);
		if($row = mysqli_fetch_row($result))
		{
			$register_ID = $row[0];
		}
		else
		{
			return 0;
		}
		$query2 = "SELECT participant_state FROM activity_attendance WHERE activity_ID = $activity_ID AND participant_register_ID = $register_ID";
		$result2 = mysqli_query($con,$query2);
		if($row2 = mysqli_fetch_row($result2))
		{
			if($row2[0]==1)
			{
				return 9;
			}
			else
			{
				$datetime = get_now_datetime_for_db();
				$query3 = "UPDATE activity_attendance SET participant_state = 1 , time_sign_in = '$datetime' WHERE activity_ID = $activity_ID AND participant_register_ID = $register_ID";
				mysqli_query($con,$query3);
				return 1;
			}
		}
		else
		{
			return -1;
		}
	}
?>
