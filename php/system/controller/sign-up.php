<!DOCTYPE html>
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
        <div class="clearfix">
          <?php
            require_once('../model/signup.php');
            $identity = $_POST['identity'];
            if(isset($_POST['name']))
            {
              $name = $_POST['name'];
            }
            else
            {
              $name = "";
            }
            if(isset($_POST['username']))
            {
              $username = $_POST['username'];
            }
            else
            {
              $username = "";
            }
            if(isset($_POST['password']))
            {
              $password = $_POST['password'];
            }
            else
            {
              $password = "";
            }
            if(isset($_POST['password_r']))
            {
              $password_r = $_POST['password_r'];
            }
            else
            {
              $password_r = "";
            }
            if($identity=='t')
            {
              if(isset($_POST['school']))
              {
                $school_ID = $_POST['school'];
              }
              else
              {
                $school_ID = 0;
              }
            }
            else if($identity=='c')
            {
              if(isset($_POST['student_ID_number']))
              {
                $student_ID_number = $_POST['student_ID_number'];
              }
              else
              {
                $student_ID_number = "";
              }
              if(isset($_POST['student_ID_card_number']))
              {
                $student_ID_card_number = $_POST['student_ID_card_number'];
              }
              else
              {
                $student_ID_card_number = "";
              }
              if(isset($_POST['department']))
              {
                $department = $_POST['department'];
              }
              else
              {
                $department = "";
              }
              if(isset($_POST['grade']))
              {
                $grade = $_POST['grade'];
              }
              else
              {
                $grade = "";
              }
            }
            
            if(confirm_password($password , $password_r))
            {
              if(!check_user_exist($username))
              {
                if($identity=='c')
                {
                  companion_register($username,$password,$name,$department,$grade,$student_ID_number,$student_ID_card_number);
                }
                else if($identity=='t')
                {
                  teacher_register($username,$password,$name,$school_ID);
                }
                
                echo '<h1 class="float-left display-4 mr-4">恭喜</h1>
                    <h4 class="pt-3">您已成功註冊</h4>
                    <p class="text-muted"><a href="../index.php">回上一頁</a>登入</p>';
              }
              else
              {
                echo '<h1 class="float-left display-4 mr-4">Oops</h1>
                    <h4 class="pt-3">該使用者名稱已經被使用</h4>
                    <p class="text-muted"><a href="../views/signup_page.php">回上一頁</a>使用其他名稱</p>';
              }
            }
            else
            {
              echo '<h1 class="float-left display-4 mr-4">Oops</h1>
                    <h4 class="pt-3">請確認輸入的密碼</h4>
                    <p class="text-muted"><a href="../views/signup_page.php">回上一頁</a>並檢查您輸入的密碼</p>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>