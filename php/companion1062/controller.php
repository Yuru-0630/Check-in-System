<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>大學伴資料登錄</title>
  <link href="../style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="clearfix">
          <?php
            require_once('model.php');
            $identity = $_POST['identity'];
            $check = 1;
            if(isset($_POST['name']))
            {
              $name = $_POST['name'];
            }
            else
            {
              $check = 0;
            }
            if($identity=='c')
            {
              if(isset($_POST['student_ID_number']))
              {
                $student_ID_number = $_POST['student_ID_number'];
              }
              else
              {
                $check = 0;
              }
              if(isset($_POST['student_ID_card_number']))
              {
                $student_ID_card_number = $_POST['student_ID_card_number'];
              }
              else
              {
                $check = 0;
              }
              if(isset($_POST['department']))
              {
                $department = $_POST['department'];
              }
              else
              {
                $check = 0;
              }
              if(isset($_POST['grade']))
              {
                $grade = $_POST['grade'];
              }
              else
              {
                $check = 0;
              }
            }

            if($identity=='c')
            {
              companion1062_register($name,$department,$grade,$student_ID_number,$student_ID_card_number);
              if($check)
              {
                echo '<h1 class="float-left display-4 mr-4">感謝您</h1>
                    <h4 class="pt-3">您已成功完成資料登錄</h4>
                    <p class="text-muted"><a href="index.php">回上一頁</a></p>';
              }
              
              else
              {
                echo '<h1 class="float-left display-4 mr-4">Oops</h1>
                      <h4 class="pt-3">不好意思，請確認您輸入的資料</h4>
                      <p class="text-muted"><a href="index.php">回上一頁</a></p>';
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
