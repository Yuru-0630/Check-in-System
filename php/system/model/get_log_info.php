<?php
	require_once("get_pair_info.php");

	function get_log_Info_by_ID($id)
	{
		global $con;
		$query = "SELECT * FROM log_companion WHERE ID = $id";
		$result = mysqli_query($con,$query);
		$array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function get_log_Info_by_pair_ID($pair_ID)
	{
		global $con;
		$query = "SELECT * FROM log_companion WHERE pair_ID = $pair_ID";
		$result = mysqli_query($con,$query);
		$array = mysqli_fetch_assoc($result);
	    return $array;
	}

	function add_log($log_ID,$computer_ID,$headset,$microphone,$camera,$tablet,$connection,$self_1,$self_2,$self_3,$self_4,$self_5,$student_1,$student_2,$student_3,$student_4,$student_5,$content,$method,$about_student,$to_student,$to_manager)
	{
		global $con;
		date_default_timezone_set('Asia/Taipei');
		$datetime = date("Y-m-d H:i:s");
		$query = "UPDATE log_companion SET computer_ID=$computer_ID,score_headset=$headset,score_microphone=$microphone,score_camera=$camera,score_tablet=$tablet,score_connection=$connection,score_self_1=$self_1,score_self_2=$self_2,score_self_3=$self_3,score_self_4=$self_4,score_self_5=$self_5,score_student_1=$student_1,score_student_2=$student_2,score_student_3=$student_3,score_student_4=$student_4,score_student_5=$student_5,content='$content',method='$method',about_student='$about_student',to_student='$to_student',to_manager='$to_manager',isCompleted=1,submit_time='$datetime' WHERE ID=$log_ID";
		mysqli_query($con,$query);
	}

	function upload_material($log_id,$name)
	{
		if($_FILES[$name]["name"]!=NULL)
		{
			$target_dir = "uploads/";
			$target_file = $target_dir.basename($_FILES[$name]["name"]);
			$upload_check = true;
			//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			$check = getimagesize($_FILES[$name]["tmp_name"]);
			if($check)
			{
				$upload_check = true;
			}
			else
			{
				$upload_check = false;
			}
			
			if (file_exists($target_file)) 
			{
			    //echo "該檔案已經存在，請再試一次";
			    $upload_check = false;
			} 
			if ($_FILES[$name]["size"] > 5000000) 
			{
			    //echo "檔案過大，請嘗試其他檔案";
			    $upload_check = false;
			}
			/*
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
			{
			    //echo "請上傳 JPG, JPEG, PNG 或是 GIF 檔";
			    $upload_check = false;
			}
			*/
			if($upload_check)
			{
			    if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) 
			    {
			        //echo "圖片上傳成功";
			        $file = $target_dir.basename( $_FILES[$name]["name"]);
			        global $con;
			        $query = "UPDATE log_companion SET material ='$file' WHERE ID = $log_id)";
			        mysqli_query($con,$query);
			    } 
			} 
			else
			{
			    //echo "請再試一次";
			    $file = "";
			}
		}
		return $upload_check;
	}
?>