<?php
  session_start();
  require_once("../model/get_user_info.php");
  $user_identity = get_identity_by_register_ID($_SESSION['uID']);
  if(2<=$user_identity && $user_identity<=5)
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
                      <a class="nav-link" href="homepage.php">
                        <img class="icon-modified" src="../src/icon/home.png">首頁
                      </a>
                    </li>';
  }
  if($user_identity==2)
  {
    echo '<li class="nav-item">
            <a class="nav-link" href="user.php?i=1">
              <img class="icon-modified" src="../src/icon/users.png">使用者
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pair.php?i=1">
              <img class="icon-modified" src="../src/icon/pair.png">學伴配對
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="attendance.php?i=1">
              <img class="icon-modified" src="../src/icon/sign.png">簽到紀錄
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="log_manage_page.php?i=1">
              <img class="icon-modified" src="../src/icon/log.png">日誌管理
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="activity_page.php?i=1">
              <img class="icon-modified" src="../src/icon/gear.png">活動管理
            </a>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
              <img class="icon-modified" src="../src/icon/magnifying_glass.png">失物招領
            </a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="LF_Lost.php">
                  <img class="menu-sec-icon menu-sec-icon-spread" src="../src/icon/ptr_right.png">遺失登記
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="LF_Found.php">
                  <img class="menu-sec-icon menu-sec-icon-spread" src="../src/icon/ptr_right.png">拾獲物品
                </a>
              </li>
            </ul>
          </li>';
  }
  else if(3<=$user_identity && $user_identity<=5)
  {
    echo '<li class="nav-item">
            <a class="nav-link" href="self_info_page.php">
              <img class="icon-modified" src="../src/icon/users.png">我的資料
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="to_log_list_page.php">
              <img class="icon-modified" src="../src/icon/log.png">我的日誌
            </a>
          </li>';
    /*     
    echo  '<li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
              <img class="icon-modified" src="../src/icon/magnifying_glass.png">失物招領
            </a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="LF_Lost.php">
                  <img class="menu-sec-icon menu-sec-icon-spread" src="../src/icon/ptr_right.png">遺失登記
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="LF_Found.php">
                  <img class="menu-sec-icon menu-sec-icon-spread" src="../src/icon/ptr_right.png">拾獲物品
                </a>
              </li>
            </ul>
          </li>';
    */
  }
  if(2<=$user_identity && $user_identity<=5)
  {
    echo '</ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>
      
      <main class="main">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
        </ol>';
  }
  require_once("../model/function_extended.php");
  if($user_identity==2)
  {
    echo '<h2 style="margin-left: 30px;margin-bottom: 25px;margin-top:10px;">目前可用功能：</h2>
            <div class="container-fluid">
              <div class="animated fadeIn">
              <p>
              1. 1062大學伴資料登錄。<br/>
              2. 1062學生資料登錄。<br/>
              3. 刪除 大學伴/學生資料<br/>
              4. 大學伴註冊與管理員確認。<br/>
              5. 新增/修改/刪除 學伴配對。<br/>
              6. 新增/刪除/查看 課程簽到紀錄。新增課程時會自動將該天大學伴列為待簽到人員。<br/>
              7. 學生證簽到/手動簽到/手動刪除 課程學伴簽到紀錄。<br/>
              8. 新增/刪除/查看 活動簽到紀錄。新增活動時會自動將所有大學伴列為待簽到人員。<br/>
              9. 學生證簽到/手動簽到/手動刪除 活動參與人簽到紀錄。<br/>
              </p>
              </div>
            </div>';
    echo '<h2 style="margin-left: 30px;margin-bottom: 25px;margin-top:10px;">設備清單</h2>
          <div class="container-fluid">
            <div class="animated fadeIn">
              <div class="row">';
          show_list_of_peripheral();
          echo '<div class="col-md-3 col-sm-6">
                  <div class="social-box">
                    <img src="../src/icon/computer_icon.png" class="peripheral_img">
                    <div>
                      <font size="7">test</font>
                    </div>
                    <ul>
                      <li>
                        <strong>89k</strong>
                        <span>使用中</span>
                      </li>
                      <li>
                        <strong>459</strong>
                        <span>備品</span>
                      </li>
                    </ul>
                    <div class="card-body">
                      <div class="progress progress-xs mt-3 mb-0">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="160" aria-valuemin="0" aria-valuemax="200"></div>
                      </div>
                    </div>
                    <div class="peripheral_sum">總共：234</div>
                  </div>
                </div>

              </div>
            </div>
          </div>';
    echo '<h2 style="margin-left: 30px;margin-bottom: 10px;margin-top: 60px;">電腦使用情況</h2>
          <div class="container-fluid">
            <div class="animated fadeIn">
              <div class="row">'; 
      show_computer_isUsed(32);
      echo '</div>
          </div>
        </div>';
  }
  else if(3<=$user_identity && $user_identity<=5)
  {
    echo '這裡以後可以放活動資訊或其他提醒訊息，還有使用的電腦登記';
  }
  if(2<=$user_identity && $user_identity<=5)
  {
    echo '</main>
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
  else
  {
    echo '<!DOCTYPE html>
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
                  <div class="clearfix"><h1 class="float-left display-4 mr-4">Oops</h1>
                      <h4 class="pt-3">您已登出或是尚未登入</h4>
                      <p class="text-muted">請<a href="../index.php">回登入頁</a>並重新登入</p>
                      </div>
                    </div>
                  </div>
                </div>
              </body>
              </html>';
  }
?>