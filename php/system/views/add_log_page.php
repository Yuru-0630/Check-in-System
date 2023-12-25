<?php
  session_start();
  require_once("../model/get_log_info.php");
  $user_ID = $_SESSION['uID'];
  $user_identity = get_identity_by_register_ID($user_ID);
  if($user_identity==4)
  {
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
                          <a class="nav-link" href="../views/self_info_page.php">
                            <img class="icon-modified" src="../src/icon/users.png">我的資料
                          </a>
                        </li>
                        
                        <li class="nav-item">
                          <a class="nav-link" href="to_log_list_page.php">
                            <img class="icon-modified" src="../src/icon/log.png">我的日誌
                          </a>
                        </li>';
                      /*
                        echo '<li class="nav-item nav-dropdown">
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
                        </li>';
                        */
                      echo '</ul>
                </nav>
                <button class="sidebar-minimizer brand-minimizer" type="button"></button>
              </div>
            <main class="main">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                <li class="breadcrumb-item active">Log</li>
              </ol>
              <!---->
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-7">
                    <div class="card mx-4">
                      <div class="card-body p-4">
                        <form method="POST" action="../controller/add_log.php" enctype="multipart/form-data">
                          <center><h1>教學日誌</h1></center>
                          <br/>';
                            $log_ID = $_POST['log_ID'];
                            echo '<input type="hidden" name="log_ID" value="'.$log_ID.'">
                              <div class="input-group mb-3">
                            <label><h5>設備狀態評分(1~5)</h5></label>
                          </div>
                          <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              電腦編號 ： &nbsp;&nbsp;
                            </div>
                            <select name="computer">';
                              
                            for($i=1;$i<=32;$i++)
                            {
                              echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        
                            echo '</select>
                          </div>
                          <div class="input-group mb-3">
                            耳機狀態：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="headset" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="headset" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="headset" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="headset" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="headset" value="5">
                            </div>
                          </div>

                          <div class="input-group mb-3">
                            麥克風狀態：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="microphone" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="microphone" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="microphone" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="microphone" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="microphone" value="5">
                            </div>
                          </div>

                          <div class="input-group mb-3">
                            視訊狀態：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="camera" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="camera" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="camera" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="camera" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="camera" value="5">
                            </div>
                          </div>

                          <div class="input-group mb-3">
                            手寫板狀態：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="tablet" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="tablet" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="tablet" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="tablet" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="tablet" value="5">
                            </div>
                          </div>

                          <div class="input-group mb-3">
                            網路連線狀態：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="connection" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="connection" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="connection" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="connection" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="connection" value="5">
                            </div>
                          </div>
                          <br/>
                          <div class="input-group mb-3">
                            <label><h5>教學自評</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="self_1" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="self_1" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="self_1" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="self_1" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="self_1" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="self_2" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="self_2" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="self_2" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="self_2" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="self_2" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="self_3" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="self_3" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="self_3" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="self_3" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="self_3" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="self_4" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="self_4" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="self_4" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="self_4" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="self_4" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="self_5" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="self_5" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="self_5" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="self_5" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="self_5" value="5">
                            </div>
                          </div>
                          <br/>
                          <div class="input-group mb-3">
                            <label><h5>給小學伴的分數</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="student_1" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="student_1" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="student_1" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="student_1" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="student_1" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="student_2" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="student_2" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="student_2" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="student_2" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="student_2" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="student_3" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="student_3" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="student_3" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="student_3" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="student_3" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="student_4" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="student_4" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="student_4" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="student_4" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="student_4" value="5">
                            </div>
                          </div>
                          <div class="input-group mb-3">
                            Q：&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="margin-right: 25px;">
                              一分 <input type="radio" name="student_5" value="1">
                            </div>
                            <div style="margin-right: 25px;">
                              二分 <input type="radio" name="student_5" value="2">
                            </div>
                            <div style="margin-right: 25px;">
                              三分 <input type="radio" name="student_5" value="3">
                            </div>
                            <div style="margin-right: 25px;">
                              四分 <input type="radio" name="student_5" value="4">
                            </div>
                            <div style="margin-right: 25px;">
                              五分 <input type="radio" name="student_5" value="5">
                            </div>
                          </div>
                          <br/>
                          <div class="input-group mb-3">
                            <label><h5>教學進度與課程內容（請條列並具體說明，200字內）:</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            <textarea name="content" rows="4" cols="60"></textarea>
                          </div>

                          <div class="input-group mb-3">
                            <label><h5>教學流程與教學方法（請按照順序排列並具體講解做法，500字內）:</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            <textarea name="method" rows="12" cols="60"></textarea>
                          </div>

                          <div class="input-group mb-3">
                            <label><h5>學伴學習狀況與教學檢討（請具體說明，500字內）:</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            <textarea name="about_student" rows="12" cols="60"></textarea>
                          </div>

                          <div class="input-group mb-3">
                            <label><h5>教材上傳 :</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            <input type="file" name="material"></textarea>
                          </div>

                          <div class="input-group mb-3">
                            <label><h5>給學伴的話（500字內）:</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            <textarea name="to_student" rows="12" cols="60"></textarea>
                          </div>

                          <div class="input-group mb-3">
                            <label><h5>給助理及帶班老師的話（500字內）:</h5></label>
                          </div>
                          <div class="input-group mb-3">
                            <textarea name="to_manager" rows="12" cols="60"></textarea>
                          </div>

                          <div class="input-group mb-12">
                            <div style="position: relative;left: 50%;margin-left: -65px;">
                              <input type="submit" class="btn btn-block btn-success" value="新增">
                            </div>
                            <div style="position: relative;left: 50%;margin-left: 15px;">
                              <input type="reset" class="btn btn-block btn-default" value="重置">
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!---->
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