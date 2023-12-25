<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <link href="../css/style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="clearfix">
		<?php
			require_once("../model/get_pair_info.php");
			$check = 1;
			if(isset($_POST['ID']))
			{
			  $ID = $_POST['ID'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['companion_sID']))
			{
			  $companion_sID = $_POST['companion_sID'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['school']))
			{
			  $school_ID = $_POST['school'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['student']))
			{
			  $student_ID = $_POST['student'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['subject']))
			{
			  $subject = $_POST['subject'];
			}
			else
			{
			  $check = 0;
			}

			if(isset($_POST['day']))
			{
			  $day = $_POST['day'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['starting_time_hour']))
			{
			  $starting_time_hour = $_POST['starting_time_hour'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['starting_time_min']))
			{
			  $starting_time_min = $_POST['starting_time_min'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['ending_time_hour']))
			{
			  $ending_time_hour = $_POST['ending_time_hour'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['ending_time_min']))
			{
			  $ending_time_min = $_POST['ending_time_min'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['note']))
			{
			  $note = $_POST['note'];
			}
			else
			{
			  $note = "";
			}
			if($check)
			{
				$companion_ID = get_companion_ID_by_student_ID_number($companion_sID);
				if($companion_ID!=0)
				{
					$starting_time = $starting_time_hour.":".$starting_time_min.":00";
					$ending_time = $ending_time_hour.":".$ending_time_min.":00";
					update_pair_info($ID,$companion_ID,$student_ID,$subject,$day,$starting_time,$ending_time,$note);
					header("Location: ../views/pair.php?i=1");
				}
				else
				{
					echo '<h1 class="float-left display-4 mr-4">Oops</h1>
			            <h4 class="pt-3">無此學號</h4>
			            <p class="text-muted"><a href="../views/pair.php?i=1">回學伴配對表</a></p>';
				}
			}
			else
			{
				echo '<h1 class="float-left display-4 mr-4">Oops</h1>
			            <h4 class="pt-3">請檢查您的資料</h4>
			            <p class="text-muted"><a href="../views/pair.php?i=1">回學伴配對表</a></p>';
			}
			
		?>
		</div>
      </div>
    </div>
  </div>
</body>
</html>