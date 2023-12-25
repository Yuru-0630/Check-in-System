<?php 
	require_once("../model/get_user_info.php");
	$id = $_POST['id'];
	$result = get_all_student_by_school_ID($id);
	$data = array(); 
	while($array = mysqli_fetch_assoc($result))
	{
		array_push($data,[$array['ID'],$array['name']]);
	}
	echo json_encode($data);

?>
