<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>數位學伴期末評分查詢系統</title>
  <link href="../style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mx-4">
          <div class="card-body p-4">
          <?php
            
            require_once('model.php');
            $student_ID_card_number = mysqli_real_escape_string($con,$_POST['student_ID_card_number']);
            $companion_ID = get_companion_ID_by_student_ID_card_number($student_ID_card_number);
            if ($companion_ID==-1)
            {
              echo '<h1 class="float-left display-4 mr-4">Oops</h1>
                      <h5 class="pt-3">不好意思，如果您是大學伴，請先檢查您的輸入，若還是無法查詢，請找助理協助，謝謝您。</h5>
                      <p class="text-muted"><a href="index.php">回上一頁</a></p>';
            }
            else
            {
              $level = get_level_by_companion_ID($companion_ID);
              if($level == -1)
              {
                echo '<h1 class="float-left display-4 mr-4">Oops</h1>
                      <h4 class="pt-3">不好意思，如果您是上學期的大學伴，請找助理協助。</h4>
                      <p class="text-muted"><a href="index.php">回上一頁</a></p>';
              }
              else
              {
                switch($level)
                {
                  case 'A':
                    echo '<h1 class="float-left display-4 mr-4">Bravo！</h1>
                        <h4 class="pt-3">您可以申請服務證明。請繼續保持喔~</h4>
                        <p class="text-muted"><a href="index.php">回上一頁</a></p>';
                    break;
                  case 'B':
                    echo '<h1 class="float-left display-4 mr-4">恭喜！</h1>
                        <h4 class="pt-3">您可以申請服務證明噢～</h4>
                        <p class="text-muted"><a href="index.php">回上一頁</a></p>';
                    break;
                  case 'C':
                    echo '<h1 class="float-left display-4 mr-4">Oops！</h1>
                        <h4 class="pt-3">不好意思，您可能需要找助理協助一下</h4>
                        <p class="text-muted"><a href="index.php">回上一頁</a></p>';
                    break;
                  default://包含D
                    echo '<h1 class="float-left display-4 mr-4">Oops！</h1>
                        <h4 class="pt-3">不好意思，您可能需要找助理協助一下</h4>
                        <p class="text-muted"><a href="index.php">回上一頁</a></p>';
                    break;
                }
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
