<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="src/logo.png">
  <title>暨南大學數位學伴-後台管理系統</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="vendors/css/chart.css" rel="stylesheet">
</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <h1>Login</h1>
              <p class="text-muted">登入您的帳號</p>
              <form method="POST" action="controller/login.php" enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="username" placeholder="帳號">
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="password"  placeholder="密碼">
                </div>
                <div class="row">
                  <div class="col-6">
                    <input type="submit" class="btn btn-primary px-3" value="登入" style="margin-left: 10px;">
                  </div>
              </form>
                  <div class="col-6 text-right">
                    <button type="button" class="btn btn-link px-0" onclick="alert('可以找助理協助噢～');">忘記密碼？</button>
                  </div>
                </div>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Sign Up</h2>
                <br/><br/>
                <p>第一次加入暨南大學數位學伴計畫？</p>
                  <button type="button" class="btn btn-primary active mt-3" onclick="location.href='views/signup_page.php?identity=t'">帶班老師註冊</button>
                  <button type="button" class="btn btn-primary active mt-3" onclick="location.href='views/signup_page.php?identity=c'">大學伴註冊</button>
                  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="vendors/js/jquery.min.js"></script>
  <script src="vendors/js/bootstrap.min.js"></script>
  <script src="vendors/js/popper.min.js"></script>
  <script src="vendors/js/pace.min.js"></script>
  <script src="vendors/js/Chart.min.js"></script>
  <script src="js/app.js"></script>
  <script src="js/views/main.js"></script>

</body>
</html>