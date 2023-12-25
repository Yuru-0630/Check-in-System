<!DOCTYPE html>
<html>
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
			require_once("../model/get_log_info.php");
			$check = 1;
			if(isset($_POST['log_ID']))
			{
			  $log_ID = $_POST['log_ID'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['computer']))
			{
			  $computer_ID = $_POST['computer'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['headset']))
			{
			  $headset = $_POST['headset'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['microphone']))
			{
			  $microphone = $_POST['microphone'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['camera']))
			{
			  $camera = $_POST['camera'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['tablet']))
			{
			  $tablet = $_POST['tablet'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['connection']))
			{
			  $connection = $_POST['connection'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['self_1']))
			{
			  $self_1 = $_POST['self_1'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['self_2']))
			{
			  $self_2 = $_POST['self_2'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['self_3']))
			{
			  $self_3 = $_POST['self_3'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['self_4']))
			{
			  $self_4 = $_POST['self_4'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['self_5']))
			{
			  $self_5 = $_POST['self_5'];
			}
			else
			{
			  $check = 0;
			}
			
			if(isset($_POST['student_1']))
			{
			  $student_1 = $_POST['student_1'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['student_2']))
			{
			  $student_2 = $_POST['student_2'];
			}
			else
			{
			  $check = 0;
			}
			//
			if(isset($_POST['student_3']))
			{
			  $student_3 = $_POST['student_3'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['student_4']))
			{
			  $student_4 = $_POST['student_4'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['student_5']))
			{
			  $student_5 = $_POST['student_5'];
			}
			else
			{
			  $check = 0;
			}
			//
			if(isset($_POST['content']))
			{
			  $content = $_POST['content'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['method']))
			{
			  $method = $_POST['method'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['about_student']))
			{
			  $about_student = $_POST['about_student'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['material']))
			{
			  $material = $_POST['material'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['to_student']))
			{
			  $to_student = $_POST['to_student'];
			}
			else
			{
			  $check = 0;
			}
			if(isset($_POST['to_manager']))
			{
			  $to_manager = $_POST['to_manager'];
			}
			else
			{
			  $check = 0;
			}
			if($check)
			{
				upload_material($log_id,'material');
				add_log($log_ID,$computer_ID,$headset,$microphone,$camera,$tablet,$connection,$self_1,$self_2,$self_3,$self_4,$self_5,$student_1,$student_2,$student_3,$student_4,$student_5,$content,$method,$about_student,$to_student,$to_manager);
				header("Location: ../views/to_log_list_page.php");
			}
			else
			{
				echo '<h1 class="float-left display-4 mr-4">Oops</h1>
			            <h4 class="pt-3">請檢查您的資料</h4>
			            <p class="text-muted"><a href="../views/to_log_list_page.php">回日誌管理</a></p>';
			}
			
		?>
		</div>
      </div>
    </div>
  </div>
</body>
</html>