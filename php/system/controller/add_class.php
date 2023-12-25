<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>新增課程簽到表</title>
  <link href="../css/style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="clearfix">
		<?php
			require_once("../model/attendance_info_operation.php");
			$check = 1;
			if(isset($_POST['day']))
			{
			  $class_day = $_POST['day'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['starting_time']))
			{
			  $tmp = explode(" ",$_POST['starting_time']);
			  $class_date = $tmp[0];
			  $starting_time = $tmp[1];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['ending_time']))
			{
			  $tmp2 = explode(" ",$_POST['ending_time']);
			  $ending_time = $tmp2[1];

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
				add_class($class_date,$class_day,$starting_time,$ending_time,$note);
				add_companion_to_class(get_newest_class_Info()['ID']);
				header("Location: ../views/attendance.php?i=1");
			}
			else
			{
				echo '<h1 class="float-left display-4 mr-4">Oops</h1>
			            <h4 class="pt-3">請檢查您的資料</h4>
			            <p class="text-muted"><a href="../views/attendance.php?i=1">回課程列表</a></p>';
			}
			
		?>
		</div>
      </div>
    </div>
  </div>
</body>
</html>