<?php
  session_start();
  require_once("../model/get_user_info.php");
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
                  <li class="breadcrumb-item active">User</li>
                </ol>

                <div class="container-fluid">

                  <div class="animated fadeIn">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-header">
                            使用者清單
                          </div>
                          <div class="card-body">
                            <ul class="horizontal-bars">
                              <li class="legend">
                                <span class="badge badge-pill badge-success"></span>
                                <small>應屆學生</small> &nbsp;
                                <span class="badge badge-pill badge-light"></span>
                                <small>歷屆學生</small> &nbsp;
                                <span class="badge badge-pill badge-info"></span>
                                <small>應屆大學伴</small> &nbsp;
                                <span class="badge badge-pill badge-secondary"></span>
                                <small>歷屆大學伴</small> &nbsp;
                              </li>
                            </ul>
                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                              <thead class="thead-light">
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">照片</th>
                                  <th>使用者名稱</th>
                                  <th>身份</th>
                                  <th>學校/系所</th>
                                  <th>年級</th>
                                  <th class="text-center">學號</th>
                                  <th class="text-center">學生證號碼</th>
                                  <th class="text-center">操作</th>
                                </tr>
                              </thead>
                              <tbody>';
			/*
                        $data_length_one_page=25;
                        $index_page = $_GET['i'];
                        $num_of_data = get_Num_of_register_info();
                        $num_of_page = (int)($num_of_data/$data_length_one_page);
                        if($num_of_data%$data_length_one_page!=0)
                        {
                          $num_of_page++;
                        }
                        $result = get_register_Info_desc_in_range(1+($index_page-1)*$data_length_one_page,$data_length_one_page+($index_page-1)*$data_length_one_page);
			*/
			$result = get_all_register_Info();
                        while($array_register = mysqli_fetch_assoc($result))
                        {
                          if($array_register['identity']==5)
                          {
                            $student_Info = get_student_Info_by_register_ID($array_register['ID']);
                            echo '<tr>
                                  <td class="text-center">'.$array_register['ID'].'</td>
                                  <td class="text-center">
                                    <div class="avatar">
                                      <a href="update_image_page.php?id='.$array_register['ID'].'">
                                        <img src="../src/'.$array_register['image'].'" class="img-avatar">
                                      </a>
                                      <span class="avatar-status badge-';
                              if($student_Info['state'])
                              {
                                echo 'success';
                              }      
                              else
                              {
                                echo 'light';
                              }
                              echo '"></span>
                                    </div>
                                  </td>
                                  <td>
                                    <div>'.$student_Info['name'].'</div>
                                  </td>
                                  <td>
                                    <div>'.$identity[5].'</div>
                                  </td>
                                  <td>'.get_school_Name($student_Info['school_ID']).'</td>
                                  <td>'.$grade[$student_Info['grade']].'</td>
                                  <td class="text-center"></td>
                                  <td class="text-center"></td>
                                  <td class="text-center">';
                                  if($array_register['state']==0)
                                  {
                                    echo '<button onclick="location.href=\'../controller/user_confirm.php?id='.$array_register['ID'].'\'">確認</button>';
                                  }
                            echo '<button onclick="delete_user('.$array_register['ID'].",".$array_register['identity'].');">刪除</button>
                            </td>
                                </tr>';
                          }
                          else if($array_register['identity']==4)
                          {
                            $array = get_companion_Info_by_register_ID($array_register['ID']);
                            echo '<tr>
                                  <td class="text-center">'.$array_register['ID'].'</td>
                                  <td class="text-center">
                                    <div class="avatar">
                                      <a href="update_image_page.php?id='.$array_register['ID'].'">
                                        <img src="../src/'.$array_register['image'].'" class="img-avatar">
                                      </a>
                                      <span class="avatar-status badge-';
                                if($array['isServing'])
                                {
                                  echo 'info';
                                }      
                                else
                                {
                                  echo 'secondary';
                                }
                                echo '"></span>
                                    </div>
                                  </td>
                                  <td>
                                    <div>'.$array['name'].'</div>
                                  </td>
                                  <td>
                                    <div>'.$identity[4].'</div>
                                  </td>
                                  <td>'.get_department_Info_by_ID($array['department_ID']).'</td>
                                  <td>'.$grade[$array['grade']].'</td>
                                  <td class="text-center">'.$array['student_ID_number'].'</td>
                                  <td class="text-center">'.$array['student_ID_card_number'].'</td>
                                  <td class="text-center">';
                                  if($array_register['state']==0)
                                  {
                                    echo '<button onclick="location.href=\'../controller/user_confirm.php?id='.$array_register['ID'].'\'">確認</button>';
                                  }
                                  echo '<button onclick="delete_user('.$array_register['ID'].",".$array_register['identity'].');">刪除</button>
                                  </td>
                                  </tr>';
                          }
                          
                        }

                        echo '</tbody>
                            </table>
                            <br/>';
			/*
                        echo '<ul class="pagination justify-content-center">';
                        require_once("../model/function_extended.php");
                        paging("user.php",$index_page,$num_of_page);
                        echo '</ul>';
			*/
                       echo '</div>
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
