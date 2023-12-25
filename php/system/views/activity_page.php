<?php
  session_start();
  require_once("../model/activity_info_operation.php");
  $user_identity = get_identity_by_register_ID($_SESSION['uID']);
  if($user_identity==2)
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
            <link href="../css/etutor.css" rel="stylesheet">
            <link href="../vendors/css/chart.css" rel="stylesheet">
            <script src="../js/etutor.js"></script>
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
                  <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                  <li class="breadcrumb-item active">Activity</li>
                </ol>

                <div class="container-fluid">
                  <div class="card">
                    <div class="card-header">
                      活動列表
                    </div>
                    <div class="card-body">
                      <a href="add_activity_page.php">新增活動</a>
                      <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>活動名稱</th>
                            <th class="text-center">開始時間</th>
                            <th class="text-center">結束時間</th>
                            <th>地點</th>
                            <th class="text-center">活動簡述</th>
                            <th class="text-center">檔案連結</th>
                            <th>備註</th>
                            <th class="text-center">操作</th>
                          </tr>
                        </thead>
                        <tbody>';
        $data_length_one_page=1000;
        $index_page = $_GET['i'];
        $num_of_data = get_Num_of_Info("activity");
        $num_of_page = (int)($num_of_data/$data_length_one_page);
        if($num_of_data%$data_length_one_page!=0)
        {
          $num_of_page++;
        }
        $result = get_Info_desc_in_range("activity",1+($index_page-1)*$data_length_one_page,$data_length_one_page+($index_page-1)*$data_length_one_page);
        while($array = mysqli_fetch_assoc($result))
        {
          echo '<tr>
                  <td>'.$array['ID'].'</td>
                  <td>'.$array['name'].'</td>
                  <td class="text-center">'.$array['starting_time'].'</td>
                  <td class="text-center">'.$array['ending_time'].'</td>
                  <td>'.$array['location'].'</td>
                  <td class="text-center">'.$array['description'].'</td>
                  <td class="text-center">'.$array['file_url'].'</td>
                  <td>'.$array['note'].'</td>
                  <td class="text-center"><button onclick="location.href=\'activity_attendance_page.php?i=1&id='.$array['ID'].'\'">查看</button>
                  <button onclick="delete_activity('.$array['ID'].');">刪除</button></td>
                </tr>';
        }
          echo '</tbody>
            </table>
            <nav>
              <ul class="pagination justify-content-center">';
          require_once("../model/function_extended.php");
          paging("attendance.php",$index_page,$num_of_page);
          
          echo '</ul>
              </nav>
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

  </body>
  </html>';
  }
?>
