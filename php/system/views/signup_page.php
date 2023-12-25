<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign-up</title>
  <link href="../css/style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mx-4">
          <div class="card-body p-4">
            <form method="POST" action="../controller/sign-up.php" enctype="multipart/form-data">
              <center><h1>註冊表單</h1></center>
              <br/>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-user"></i></span>
                </div>
                <input type="text" class="form-control" name="name" placeholder="姓名">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-user"></i></span>
                </div>
                <input type="text" class="form-control" name="username" placeholder="帳號">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-lock"></i></span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="密碼">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-lock"></i></span>
                </div>
                <input type="password" class="form-control" name="password_r" placeholder="密碼確認">
              </div>
              <?php
              $identity = $_GET['identity'];
              echo '<input type="hidden" name="identity" value="'.$identity.'">';
              if($identity=='c')
              {
                echo '<div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="text" class="form-control" name="student_ID_number" placeholder="學號">
                      </div>

                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="text" class="form-control" name="student_ID_card_number" placeholder="學生證號碼">
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          科系 ： &nbsp;&nbsp;
                        </div>
                        <select name="department">
                          <option value="49">中國語文學系</option>
                          <option value="50">外國語文學系</option>
                          <option value="51">社會政策與社會工作學系</option>
                          <option value="52">公共行政與政策學系</option>
                          <option value="53">歷史學系</option>
                          <option value="54">東南亞學系</option>
                          <option value="57">原鄉發展跨領域學士學位學程原住民專班</option>

                          <option value="59">國際企業學系</option>
                          <option value="60">經濟學系</option>
                          <option value="61">資訊管理學系</option>
                          <option value="62">財務金融學系</option>
                          <option value="63">觀光休閒與餐旅管理學系</option>

                          <option value="67">土木工程學系</option>
                          <option value="68">資訊工程學系</option>
                          <option value="69">電機工程學系</option>
                          <option value="70">應用化學系</option>
                          <option value="72">應用材料及光電工程學系</option>

                          <option value="75">國際文教與比較教育學系</option>
                          <option value="76">教育政策與行政學系</option>
                          <option value="77">諮商心理與人力資源發展學系</option>

                        </select>
                      </div>

                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          年級 ： &nbsp;&nbsp;
                        </div>
                        <select name="grade">
                          <option value="41">大學部一年級</option>
                          <option value="42">大學部二年級</option>
                          <option value="43">大學部三年級</option>
                          <option value="44">大學部四年級</option>
                          <option value="51">研究所一年級</option>
                          <option value="52">研究所二年級</option>
                        </select>
                      </div>';
              }
              else if($identity=='t')
              {
                echo '<div class="input-group mb-4">
                        <div class="input-group-prepend">
                          服務學校 ： &nbsp;&nbsp;
                        </div>
                        <select name="school">
                          <option value="1">力行國小</option>
                        </select>
                      </div>';
              }
              ?>
              

              <input type="submit" class="btn btn-block btn-success" value="創建帳號">
            </form>
            <button type="button" class="btn btn-block btn-default" onclick="location.href='../index.php'" style="margin-top: 8px;">取消</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>