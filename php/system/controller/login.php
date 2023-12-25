<?php
	session_start();
?>
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
        		require_once('../model/login.php');
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

    				if(confirm($username,$password))
    				{
    					$_SESSION['uID'] = get_register_ID($username);
    					header('Location: ../views/homepage.php');
              exit();
    				}
    				else
    				{
    					echo '<h1 class="float-left display-4 mr-4">Oops</h1>
    	          		<h4 class="pt-3">無此帳號或密碼不符</h4>
    	          		<p class="text-muted">請<a href="../index.php">回上一頁</a>並檢查您輸入的帳號或密碼</p>';
    				}
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>