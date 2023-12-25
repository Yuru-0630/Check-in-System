<?php
  session_start();
  require_once("../model/get_log_info.php");
  $user_ID = $_SESSION['uID'];
  $user_identity = get_identity_by_register_ID($user_ID);
  $string="";
  $num_list=0;
  if($user_identity==4)
  {
    if($companion_Info = get_companion_Info_by_register_ID($user_ID))
    {
      $companion_ID = $companion_Info['ID'];
      $result = get_all_pair_Info_by_companion_ID($companion_ID);
      while($array = mysqli_fetch_assoc($result))
      {
        if($log_info = get_log_Info_by_pair_ID($array['ID']))
        {
          if(!$log_info['isCompleted'])
          {
            $companion_info = get_companion_Info_by_ID($array['companion_ID']);
            $student_info = get_student_Info_by_ID($array['student_table_ID']);
            $string = $string.'<tr>
                    <td class="text-center">'.$array['ID'].'</td>
                    <td class="text-center">
                      <div class="avatar">
                        <img src="../src/'.get_image('companion',$array['ID']).'" class="img-avatar">
                      </div>
                    </td>
                    <td>
                      <div>'.$companion_info['name'].'</div>
                      <div class="small text-muted">
                        <span>'.get_department_Info_by_ID($companion_info['department_ID']).'</span> | '.$grade[$companion_info['grade']].'
                      </div>
                    </td>
                    <td>'.$subject[$array['subject']].'</td>
                    <td>'.$day[$array['day']].'</td>
                    <td>'.$array['starting_time'].' ~ '.$array['ending_time'].'</td>
                    <td class="text-center">
                      <div class="avatar">
                        <img src="../src/'.get_image('student',$array['ID']).'" class="img-avatar">
                      </div>
                    </td>
                    <td>
                      <div>'.$student_info['name'].'</div>
                      <div class="small text-muted">
                        <span>'.get_school_Name($student_info['school_ID']).'</span> | '.$grade[$student_info['grade']].'
                      </div>
                    </td>
                    <td>
                      <form method="POST" action="add_log_page.php" enctype="multipart/form-data"> 
                        <input type="hidden" name="log_ID" value="'.$log_info['ID'].'">
                        <input type="submit" value="填寫日誌">
                      </form>
                    </td>
                  </tr>';
            $num_list += 1;
          }
        }
      }
      
      
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
                      <li class="breadcrumb-item"><a href="../views/homepage.php">Home</a></li>
                      <li class="breadcrumb-item active">Log</li>
                    </ol>
                    <div class="container-fluid">
                      <div class="animated fadeIn">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card">
                              <div class="card-header">
                                待填寫日誌
                              </div>
                              <div class="card-body">
                                <table class="table table-responsive-sm table-hover table-outline mb-0">
                                  <thead class="thead-light">
                                    <tr>
                                      <th class="text-center">#</th>
                                      <th></th>
                                      <th>大學伴</th>
                                      <th>科目</th>
                                      <th>星期</th>
                                      <th>時間</th>
                                      <th></th>
                                      <th>學生</th>
                                      <th>操作</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                echo $string;
                echo '</tbody>
                  </table>
                  <br/>
                  </div>';
                  if($num_list==0)
                  {
                    echo "<center><h4>目前沒有需要填寫的日誌</h4></center>";
                  }
                echo '</div>
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
  }
?>