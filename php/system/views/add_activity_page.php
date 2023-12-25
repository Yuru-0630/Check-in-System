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
          <link href="../css/etutor.css" rel="stylesheet">
          <link href="../vendors/css/chart.css" rel="stylesheet">
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.18/jquery.datetimepicker.css">
          <script src="//code.jquery.com/jquery-1.9.1.js"></script>
          <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.18/jquery.datetimepicker.full.min.js"></script>
          <script src="../js/etutor.js"></script>
        </head>
        
        <body class="app flex-row align-items-center">
          
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card mx-4">
                  <div class="card-body p-4">
                    <form method="POST" action="../controller/add_activity.php" enctype="multipart/form-data">
                      <center><h1>新增活動資料</h1></center>
                      <br/>
                      <div class="input-group mb-4" id="test">
                        <div class="input-group-prepend">
                          活動名稱 ： &nbsp;&nbsp;
                        </div>
                        <input type="text" class="form-control" name="name" placeholder="活動名稱">
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          開始時間 ： &nbsp;&nbsp;
                        </div>
                        <input type="text" id="datetimepicker1" class="form-control" name="starting_time" placeholder="開始時間" >
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          結束時間 ： &nbsp;&nbsp;
                        </div>
                        <input type="text" id="datetimepicker2" class="form-control" name="ending_time" placeholder="結束時間">
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          地點 ： &nbsp;&nbsp;
                        </div>
                        <input type="text" class="form-control" name="location" placeholder="地點">
                      </div>

                      <div class="input-group mb-3">
                        <label>活動簡述：</label>
                      </div>
                      <div class="input-group mb-3">
                        <textarea name="description" rows="2" cols="60"></textarea>
                      </div>

                      <div class="input-group mb-3">
                        <label>備註：</label>
                      </div>
                      <div class="input-group mb-3">
                        <textarea name="note" rows="2" cols="60"></textarea>
                      </div>

                      <input type="submit" class="btn btn-block btn-success" value="新增">
                    </form>
                    <button type="button" class="btn btn-block btn-default" onclick="location.href=\'activity_page.php?i=1\'" style="margin-top: 8px;">取消</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
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