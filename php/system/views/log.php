<?php
	session_start();
	require_once("../model/get_log_info.php");
	$user_ID = $_SESSION['uID'];
	$user_identity = get_identity_by_register_ID($user_ID);
	if($user_identity==2)
	{
		if(isset($_GET['id']))
		{
			$log_ID = $_GET['id'];
		}
		else
		{
			$log_ID = 0;
		}
		$array = get_log_Info_by_ID($log_ID);
		echo '<!DOCTYPE html>
            <html>
            <head>
              <meta charset="utf-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <link rel="shortcut icon" href="../src/logo.png">
              <title>暨南大學數位學伴-後台管理系統</title>
              <link href="../css/style.css" rel="stylesheet">
              <link href="../vendors/css/chart.css" rel="stylesheet">
              <link href="../css/etutor.css" rel="stylesheet">
            </head>
            <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
              <header class="app-header navbar">
                <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <a href="../controller/sign-out.php" style="margin-right: 25px;">登出</a>
              </header>

              <div class="app-body">
                <div class="sidebar">
                  <nav class="sidebar-nav">
                    <ul class="nav">
                      <li class="nav-item">
                        <a class="nav-link" href="../views/homepage.php">
                          <img class="icon-modified" src="../src/icon/home.png">首頁
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="../views/user.php?i=1">
                          <img class="icon-modified" src="../src/icon/users.png">使用者
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="../views/pair.php?i=1">
                          <img class="icon-modified" src="../src/icon/pair.png">學伴配對
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="../views/attendance.php?i=1">
                          <img class="icon-modified" src="../src/icon/sign.png">簽到紀錄
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="log_manage_page.php?i=1">
                          <img class="icon-modified" src="../src/icon/log.png">日誌管理
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="../views/activity_page.php?i=1">
                          <img class="icon-modified" src="../src/icon/gear.png">活動管理
                        </a>
                      </li>
                      <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><img class="icon-modified" src="../src/icon/magnifying_glass.png">失物招領</a>
                        <ul class="nav-dropdown-items">
                          <li class="nav-item">
                            <a class="nav-link" href="../views/LF_Lost.php">
                              <img class="menu-sec-icon menu-sec-icon-spread" src="../src/icon/ptr_right.png">遺失登記
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="../views/LF_Found.php">
                              <img class="menu-sec-icon menu-sec-icon-spread" src="../src/icon/ptr_right.png">拾獲物品
                            </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </nav>
                  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
                </div>
                
                <main class="main">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../views/homepage.php">Home</a></li>
                    <li class="breadcrumb-item active">Log</li>
                  </ol>
                  <div class="container-fluid">
                    <div class="animated fadeIn">
                    	<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  日誌資料
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body">
					                大學伴系級：<br/>
					                大學伴姓名：<br/>
					                合作學校：<br/>
					                學生姓名：<br/>
					                課程時間：<br/>
					                日誌填寫時間：<br/>
					                </div>
					              </div>
			            		</div>
			            	</div>
            			</div>
                    	<div class="row">
           					<div class="col-sm-4 col-md-4">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                	設備評分結果
					                </div>
					                <div class="card-body">
										電腦編號 ： '.$array['computer_ID'].'<br/>
										耳機 ： '.$array['score_headset'].'<br/>
										麥克風 ： '.$array['score_microphone'].'<br/>
										視訊 ： '.$array['score_camera'].'<br/>
										手寫板 ： '.$array['score_tablet'].'<br/>
										連線狀況 ： '.$array['score_connection'].'<br/>
					                </div>
					              </div>
			            		</div>
			            	</div>
			            	<div class="col-sm-4 col-md-4">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                	教學自我評分結果
					                </div>
					                <div class="card-body">
										self_1 ： '.$array['score_self_1'].'<br/>
										self_2 ： '.$array['score_self_2'].'<br/>
										self_3 ： '.$array['score_self_3'].'<br/>
										self_4 ： '.$array['score_self_4'].'<br/>
										self_5 ： '.$array['score_self_5'].'<br/>
					                </div>
					              </div>
			            		</div>
			            	</div>
			            	<div class="col-sm-4 col-md-4">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                	給學生的評分結果
					                </div>
					                <div class="card-body">
										student_1 ： '.$array['score_student_1'].'<br/>
										student_2 ： '.$array['score_student_2'].'<br/>
										student_3 ： '.$array['score_student_3'].'<br/>
										student_4 ： '.$array['score_student_4'].'<br/>
										student_5 ： '.$array['score_student_5'].'<br/>
					                </div>
					              </div>
			            		</div>
			            	</div>
            			</div>

            			<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  教學進度與課程內容
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body">'.$array['content'].'
					                </div>
					              </div>
			            		</div>
			            	</div>
            			</div>

            			<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  教學流程與教學方法
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body">'.$array['method'].'
					                </div>
					              </div>
			            		</div>
			            	</div>
            			</div>

            			<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  學伴學習狀況與教學檢討
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body">'.$array['about_student'].'
					                </div>
					              </div>
			            		</div>
			            	</div>
            			</div>

            			<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  給學伴的話
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body">'.$array['to_student'].'</div>
					              </div>
			            		</div>
			            	</div>
            			</div>

            			<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  給助理及帶班老師的話
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body">'.$array['to_manager'].'</div>
					              </div>
			            		</div>
			            	</div>
            			</div>

            			<div class="row">
           					<div class="col-sm-12 col-md-12">
           						<div class="col-sm-12 col-md-12">
					              <div class="card">
					                <div class="card-header">
					                  教材下載
					                  <span class="badge badge-pill badge-danger float-right">'.$array['ID'].'</span>
					                </div>
					                <div class="card-body"><a href="'.$array['material'].'">下載連結</a></div>
					              </div>
			            		</div>
			            	</div>
            			</div>
                    </div>
			      </div>
			    </main>
			  </div>
			  <footer class="app-footer">
			    <span class="ml-auto"><a href="https://etutor.moe.gov.tw/edu_login.php">教育部數位學伴入口網</a></span>
			  </footer>

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