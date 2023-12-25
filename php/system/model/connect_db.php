<?php
	$host = 'localhost';
	$username = 'etutor';
	$password = 'etutor';
	$db = 'etutor';
	$con = mysqli_connect($host, $username, $password, $db) or die('Error with MySQL connection'); 
	mysqli_query($con,"SET NAMES utf8");
?>