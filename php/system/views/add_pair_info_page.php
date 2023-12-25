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
          <title>新增學伴配對資料</title>
          <link href="../css/style.css" rel="stylesheet">
          <script type="text/javascript" src="../js/etutor.js"></script>

        </head>
        <script type="text/javascript">
          window.onload=function (){change_pair_form();}
        </script>

        <body class="app flex-row align-items-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card mx-4">
                  <div class="card-body p-4">
                    <form method="POST" action="../controller/add_pair_info.php" enctype="multipart/form-data">
                      <center><h1>新增學伴配對資料</h1></center>
                      <br/>
                      <div class="input-group mb-4" id="test">
                        <div class="input-group-prepend">
                          夥伴學校 ： &nbsp;&nbsp;
                        </div>
                        <select name="school" id="school" onchange="change_pair_form();">
                          <option value="1">力行國小</option>
                          <option value="2">都達國小</option>
                          <option value="3">中寮數位機會中心</option>
                          <option value="4">仁愛國小</option>
                          <option value="5">法治國小</option>
                          <option value="6">瑞峰國中</option>
			  <option value="7">魚池禮拜堂</option>
                        </select>
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
                        <select name="subject">
                          <option value="1">國語</option>
                          <option value="2">英文</option>
                          <option value="3">數學</option>
                        </select>
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          星期 ： &nbsp;&nbsp;
                        </div>
                        <select name="day">
                          <option value="1">一</option>
                          <option value="2">二</option>
                          <option value="3">三</option>
                          <option value="4">四</option>
                          <option value="5">五</option>
                        </select>
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          開始時間 ： &nbsp;&nbsp;
                        </div>
                        <select name="starting_time_hour">
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                        </select>
                        &nbsp;時&nbsp;
                        <select name="starting_time_min">
                          <option value="00">00</option>
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                          <option value="50">50</option>
                        </select>
                        &nbsp;分&nbsp;
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          結束時間 ： &nbsp;&nbsp;
                        </div>
                        <select name="ending_time_hour">
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                        </select>
                        &nbsp;時&nbsp;
                        <select name="ending_time_min">
                          <option value="0">00</option>
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                          <option value="50">50</option>
                        </select>
                        &nbsp;分&nbsp;
                      </div>

                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="icon-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="companion_sID" placeholder="大學伴學號">
                      </div>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="note" placeholder="備註">
                      </div>
                      <input type="submit" class="btn btn-block btn-success" value="新增">
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
?>
