<?php
  session_start();
  $uid = $_SESSION['uID'];
  require_once("../model/get_pair_info.php");
  $identity = get_identity_by_register_ID($uid);
  if($identity==2)
  {
    $id = $_GET['id'];
    $array = get_pair_Info_by_ID($id);
    $school_ID = get_school_ID_by_student_ID($array['student_table_ID']);
    echo '<!DOCTYPE html>
          <html>
          <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>新增學伴配對資料</title>
            <link href="../css/style.css" rel="stylesheet">
            <script type="text/javascript" src="../js/etutor.js"></script>
          </head>
          <script type="text/javascript">
            window.onload=function (){show_pair_form_with_data('.$array['student_table_ID'].');}
          </script>

          <body class="app flex-row align-items-center">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="card mx-4">
                    <div class="card-body p-4">
                      <form method="POST" action="../controller/update_pair_info.php" enctype="multipart/form-data">
                        <center><h1>修改學伴配對資料</h1></center>
                        <br/>
                        <div class="input-group mb-4" id="test">
                          <div class="input-group-prepend">
                            夥伴學校 ： &nbsp;&nbsp;
                          </div>
                          <select name="school" id="school" onchange="change_pair_form();">';
                          $result_school = get_all_school_info();
                          $num_school = get_Num_of_school_info();
                          $school_checked = array();
                          for($j=0;$j<$num_school;$j++)
                          {
                            if($j==$school_ID-1)
                            {
                              array_push($school_checked,"selected");
                            }
                            else
                            {
                              array_push($school_checked,"");
                            }
                          }
                          $i=0;
                          while($array_school = mysqli_fetch_assoc($result_school))
                          {
                            echo '<option value="'.$array_school['ID'].'" '.$school_checked[$i].">".$array_school['name']."</option>";
                            $i += 1;
                          }
                          echo '</select>
                          </div>

                        <div class="input-group mb-4">
                          <div class="input-group-prepend">
                            學生姓名 ： &nbsp;&nbsp;
                          </div>
                          <select name="student" id="student">
                          </select>
                        </div>

                        <div class="input-group mb-4">
                          <div class="input-group-prepend">
                            科目 ： &nbsp;&nbsp;
                          </div>
                          <select name="subject">';
                          for($i=1;$i<=count($subject);$i++)
                          {
                            if($array['subject']==$i)
                            {
                              echo '<option value="'.($i).'" selected>'.$subject[$i].'</option>';
                            }
                            else
                            {
                              echo '<option value="'.($i).'">'.$subject[$i].'</option>';
                            }
                          }
                          echo '</select>
                        </div>

                        <div class="input-group mb-4">
                          <div class="input-group-prepend">
                            星期 ： &nbsp;&nbsp;
                          </div>
                          <select name="day">';
                          for($i=1;$i<=count($day);$i++)
                          {
                            if($array['day']==$i)
                            {
                              echo '<option value="'.($i).'" selected>'.$day[$i].'</option>';
                            }
                            else
                            {
                              echo '<option value="'.($i).'">'.$day[$i].'</option>';
                            }
                          }
                          echo '</select>
                        </div>

                        <div class="input-group mb-4">
                          <div class="input-group-prepend">
                            開始時間 ： &nbsp;&nbsp;
                          </div>
                          <select name="starting_time_hour">';
                          echo $array['starting_time'];
                          $starting_time = explode(":", $array['starting_time']);
                          $ending_time = explode(":", $array['ending_time']);
                          for($i=15;$i<23;$i++)
                          {
                            if($starting_time[0]==$i)
                            {
                              echo '<option value="'.$i.'" selected>'.$i.'</option>';
                            }
                            else
                            {
                              echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                          }
                          echo '</select>
                          &nbsp;時&nbsp;
                          <select name="starting_time_min">';
                          for($i=0;$i<6;$i++)
                          {
                            if($starting_time[1][0]==$i)
                            {
                              echo '<option value="'.$i.'0" selected>'.$i.'0</option>';
                            }
                            else
                            {
                              echo '<option value="'.$i.'0">'.$i.'0</option>';
                            }
                          }
                          echo '</select>
                          &nbsp;分&nbsp;
                        </div>

                        <div class="input-group mb-4">
                          <div class="input-group-prepend">
                            結束時間 ： &nbsp;&nbsp;
                          </div>
                          <select name="ending_time_hour">';
                          for($i=15;$i<23;$i++)
                          {
                            if($ending_time[0]==$i)
                            {
                              echo '<option value="'.$i.'" selected>'.$i.'</option>';
                            }
                            else
                            {
                              echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                          }
                          echo '</select>
                          &nbsp;時&nbsp;
                          <select name="ending_time_min">';
                          for($i=0;$i<6;$i++)
                          {
                            if($ending_time[1][0]==$i)
                            {
                              echo '<option value="'.$i.'0" selected>'.$i.'0</option>';
                            }
                            else
                            {
                              echo '<option value="'.$i.'0">'.$i.'0</option>';
                            }
                          }
                          echo '</select>
                          &nbsp;分&nbsp;
                        </div>

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-user"></i></span>
                          </div>
                          <input type="text" class="form-control" name="companion_sID" placeholder="大學伴學號" value="'.get_student_ID_number_by_companion_ID($array['companion_ID']).'">
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-lock"></i></span>
                          </div>
                          <input type="password" class="form-control" name="note" placeholder="備註" value="'.$array['note'].'">
                        </div>
                        <input type="hidden" name="ID" value="'.$id.'">
                        <input type="submit" class="btn btn-block btn-success" value="修改">
                      </form>
                      <button type="button" class="btn btn-block btn-default" onclick="location.href=\'pair.php?i=1\'" style="margin-top: 8px;">取消</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </body>
            <script src="../vendors/js/jquery.min.js"></script>
            <script src="../vendors/js/bootstrap.min.js"></script>
            <script src="../vendors/js/popper.min.js"></script>
            <script src="../vendors/js/pace.min.js"></script>
            <script src="../vendors/js/Chart.min.js"></script>
            <script src="../js/app.js"></script>
            <script src="../js/views/main.js"></script>
            <script src="../js/etutor.js"></script>
          </html>';
  }
  else
  {
    header("Location: ../index.php");
  }
?>