<?php
  session_start();
  require_once("../model/activity_info_operation.php");
  $user_identity = get_identity_by_register_ID($_SESSION['uID']);
  if($user_identity==2)
  {
    $index_page = $_GET['i'];
    $activity_id = $_GET['id'];
    $array_activity = get_all_Info_by_ID("activity",$activity_id);
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
                      <a class="nav-link" href="log.php?i=1">
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
                  <li class="breadcrumb-item"><a href="activity_page.php?i=1">Activity</a></li>
                  <li class="breadcrumb-item active">'.$array_activity['name'].'</li>
                </ol>

                <div class="container-fluid">
                  <div class="card">
                    <div class="card-header">
                      '.$array_activity['name'].' 出席列表
                    </div>
                    <div class="card-body">
                      <a href="activity_check_in_page.php?id='.$activity_id.'">簽到系統</a>
                      <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>參與人姓名</th>
                            <th class="text-center">狀態</th>
                            <th class="text-center">簽到時間</th>
                            <th class="text-center">操作</th>
                          </tr>
                        </thead>
                        <tbody>';

        $participant_index = 1;
	/*
	$data_length_one_page=25;
        $num_of_data = get_Num_of_Info_with_ID("activity_attendance",$activity_id);
        $num_of_page = (int)($num_of_data/$data_length_one_page);
        if($num_of_data%$data_length_one_page!=0)
        {
          $num_of_page++;
        }
	*/
        $attendance_array_list = get_activity_attendance_Info_list_in_range($activity_id,1+($index_page-1)*$data_length_one_page,$data_length_one_page+($index_page-1)*$data_length_one_page);
        for($i=0;$i<count($attendance_array_list);$i++)
        {
          echo '<tr>
                  <td>'.$participant_index.'</td>
                  <td>'.get_companion_Info_by_register_ID($attendance_array_list[$i]['participant_register_ID'])['name'].'</td>
                  <td class="text-center">
                    <span class="badge badge-';
                    if($attendance_array_list[$i]['participant_state']==0)
                    {
                      echo 'danger">未簽到';
                    }
                    else if($attendance_array_list[$i]['participant_state']==1)
                    {
                      echo 'primary">已簽到';
                    }
                    echo '</span>
                  </td>
                  <td class="text-center">'.$attendance_array_list[$i]['time_sign_in'].'</td>
                  <td class="text-center">';
                  if($attendance_array_list[$i]['participant_state']==0)
                    {
                      echo '<button onclick="location.href=\'../controller/activity_attend.php?act=signin&id='.$attendance_array_list[$i]['ID'].'&actID='.$activity_id.'\'">手動簽到</button>';
                    }
                    echo '<button onclick="delete_activity_attendance_record('.$activity_id.','.$attendance_array_list[$i]['ID'].');">刪除</button>
                  </td>
                </tr>';
          $participant_index += 1;
        }
          echo '</tbody>
            </table>
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
