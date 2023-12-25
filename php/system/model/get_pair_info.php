<?php
	require_once("get_user_info.php");

	$subject = array(
			1 => "國文",
			2 => "英文",
			3 => "數學");

	$day = array(
			1 => "一",
			2 => "二",
			3 => "三",
			4 => "四",
			5 => "五",
			6 => "六",
			7 => "日");

	function get_pair_Info()
	{
		global $con;
	    $query = "SELECT * FROM pair";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_pair_Info_by_ID($id)
	{
		global $con;
	    $query = "SELECT * FROM pair WHERE ID = $id";
	    $result = mysqli_query($con,$query);
	    $array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function get_pair_Info_desc_in_range($start,$end)
	{
		global $con;
		$offset = $start-1;
		$data_length = $end-$start+1;
	    $query = "SELECT * FROM pair ORDER BY ID desc LIMIT $data_length OFFSET $offset";
	    $result = mysqli_query($con,$query);
	    return $result;
	}

	function get_Num_of_pair_info()
	{
		global $con;
		$query = "SELECT * FROM pair";
	    $result = mysqli_query($con,$query);
	    return mysqli_num_rows($result);
	}

	function get_image($table,$pair_id)
	{
		global $con;
		if(strcmp($table,'companion')==0)
		{
			$query = "SELECT companion_ID FROM pair WHERE ID=$pair_id";
		}
		else if(strcmp($table,'student')==0)
		{
			$query = "SELECT student_table_ID FROM pair WHERE ID=$pair_id";
		}
		$result = mysqli_query($con,$query);
	    $row = mysqli_fetch_row($result);
	    $table_ID = $row[0];
		$query2 = "SELECT register_ID FROM $table WHERE ID=$table_ID";
		$result2 = mysqli_query($con,$query2);
		$row2 = mysqli_fetch_row($result2);
		$register_ID = $row2[0];
	    $query3 = "SELECT image FROM register WHERE ID=$register_ID";
		$result3 = mysqli_query($con,$query3);
		$row3 = mysqli_fetch_row($result3);
	    return $row3[0];
	}

	function add_pair_info($companion_ID,$student_ID,$subject,$day,$starting_time,$ending_time,$note)
	{
		global $con;
		$query = "INSERT INTO pair (companion_ID,student_table_ID,subject,day,starting_time,ending_time,note) values ($companion_ID,$student_ID,$subject,$day,'$starting_time','$ending_time','$note')";
		$result = mysqli_query($con,$query);
	}

	function update_pair_info($ID,$companion_ID,$student_ID,$subject,$day,$starting_time,$ending_time,$note)
	{
		global $con;
		$query = "UPDATE pair SET companion_ID=$companion_ID,student_table_ID=$student_ID,subject=$subject,day=$day,starting_time='$starting_time',ending_time='$ending_time',note='$note' WHERE ID = $ID";
		$result = mysqli_query($con,$query);
	}

	function delete_pair_info($id)
	{
		global $con;
		$query = "DELETE FROM pair WHERE ID = $id";
	    $result = mysqli_query($con,$query);
	}

	function get_all_pair_Info_by_companion_ID($companion_ID)
	{
		global $con;
		$query = "SELECT * FROM pair WHERE companion_ID = $companion_ID";
		$result = mysqli_query($con,$query);
	    return $result;
	}
?>
