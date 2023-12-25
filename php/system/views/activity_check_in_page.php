<?php
  session_start();
  require_once("../model/activity_info_operation.php");
  $user_identity = get_identity_by_register_ID($_SESSION['uID']);
  if($user_identity==2)
  {
  	$activity_id = $_GET['id'];
    $array_activity = get_all_Info_by_ID("activity",$activity_id);
  	echo '<!DOCTYPE html>
		<html>
		<head>
		  <meta charset="utf-8">
		  <meta http-equiv="X-UA-Compatible" content="IE=edge">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="shortcut icon" href="../src/logo.png">
		  <title>'.$array_activity['name'].' 活動簽到系統</title>
		  <script src="../vendors/js/alertify.min.js"></script>
		  <link href="../vendors/css/alertify.min.css" rel="stylesheet">
		  <link href="../vendors/css/alertify_themes/default.min.css" rel="stylesheet">
		  <link href="../vendors/css/alertify_themes/semantic.min.css" rel="stylesheet">
		  <link href="../vendors/css/alertify_themes/bootstrap.min.css" rel="stylesheet">
		  <link href="../css/style.css" rel="stylesheet">
		  <link href="../css/etutor.css" rel="stylesheet">
		  <link href="../vendors/css/chart.css" rel="stylesheet">
		</head>
		<body>
			<header class="app-header navbar">
				&nbsp;&nbsp;&nbsp;&nbsp;'.$array_activity['name'].' 活動簽到系統
			<a href="../index.php" style="margin-right: 25px;">登入後台</a>
			</header>
			<main class="main">
				<div class="container-fluid">
					<div class="animated fadeIn">
					<br/><br/>
						<div class="row">
							<div class="col-lg-12">
							  <div class="card">
							    <div class="card-header">
							      <i class="fa fa-edit"></i>請感應學生證
							    </div>
							    <div class="card-body collapse show" id="collapseExample">
							      <form method="post" id="activity_check_in_form" class="form-horizontal">
							      	<input type="hidden" name="activity_id" value="'.$activity_id.'">
							        <div class="form-group">
							          <label class="col-form-label" for="prependedInput">學生證號碼</label>
							          <div class="controls">
							            <div class="input-prepend input-group">
							              <div class="input-group-prepend">
							                <span class="input-group-text">@</span>
							              </div>
							              <input type="tel" id="student_ID_number" name="student_ID_number" class="form-control" autofocus>
							            </div>
							          </div>
							        </div>
							      </form>
							    </div>
							  </div>
							</div>
							<!--/.col-->
						</div>
						<!--/.row-->
					</div>
				</div>
			</main>
			<script src="../vendors/js/jquery.min.js"></script>
		  <script src="../vendors/js/bootstrap.min.js"></script>
		  <script src="../vendors/js/popper.min.js"></script>
		  <script src="../vendors/js/pace.min.js"></script>
		  <script src="../vendors/js/Chart.min.js"></script>
		  <script src="../js/app.js"></script>
		  <script src="../js/views/main.js"></script>
		  <script src="../js/etutor.js"></script>
		</body>
		</html>';
	}
?>