<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>新增活動</title>
  <link href="../css/style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="clearfix">
		<?php
			require_once("../model/activity_info_operation.php");
			$check = 1;
			if(isset($_POST['name']))
			{
			  $name = $_POST['name'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['starting_time']))
			{
			  $starting_time = $_POST['starting_time'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['ending_time']))
			{
			  $ending_time = $_POST['ending_time'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['location']))
			{
			  $location = $_POST['location'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['description']))
			{
			  $description = $_POST['description'];
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
				add_activity($name,$starting_time,$ending_time,$location,$description,$note);
				add_all_companion_to_activity(get_newest_activity_Info()['ID']);
				header("Location: ../views/activity_page.php?i=1");
			}
			else
			{
				echo '<h1 class="float-left display-4 mr-4">Oops</h1>
			            <h4 class="pt-3">請檢查您的資料</h4>
			            <p class="text-muted"><a href="../views/activity_page.php?i=1">回活動列表</a></p>';
			}
			
		?>
		</div>
      </div>
    </div>
  </div>
</body>
</html>