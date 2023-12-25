<?php
	require_once("get_user_info.php");

	function confirm($username, $password)
	{
		global $con;
		$_username = mysqli_real_escape_string($con,$username);
		$query = "SELECT password FROM register WHERE username='$_username'";

		if ($result = mysqli_query($con,$query)) 
		{
			if ($row = mysqli_fetch_assoc($result)) 
			{ 
				if ($row['password'] == $password) 
				{ 
					return 1; 
				} 
				else
				{
					return 0; 
				}
			} 
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
?>