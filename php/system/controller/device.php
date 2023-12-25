<?php
	require_once("../model/function_extended.php");
	$id = $_POST['id'];
	update_computer_isUsed($id);
	echo "第".$id."台狀態已改變";
?>