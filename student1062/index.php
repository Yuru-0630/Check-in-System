<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>學生資料登錄</title>
  <link href="../style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mx-4">
          <div class="card-body p-4">
            <form method="POST" action="controller.php" enctype="multipart/form-data">
              <input type="hidden" name="identity" value="s">
              <center><h1>學生登錄表單</h1></center>
              <br/>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-user"></i></span>
                </div>
                <input type="text" class="form-control" name="name" placeholder="姓名">
              </div>

              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  性別 ： &nbsp;&nbsp;
                </div>
                <select name="sex">
                  <option value="m">男</option>
                  <option value="f">女</option>
                </select>
              </div>
                
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  學校 ： &nbsp;&nbsp;
                </div>
                <select name="partner_school">
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
                  年級 ： &nbsp;&nbsp;
                </div>
                <select name="grade">
                  <option value="11">國小一年級</option>
                  <option value="12">國小二年級</option>
                  <option value="13">國小三年級</option>
                  <option value="14">國小四年級</option>
                  <option value="15">國小五年級</option>
                  <option value="16">國小六年級</option>
                  <option value="21">國中一年級</option>
                  <option value="22">國中二年級</option>
                  <option value="23">國中三年級</option>
                </select>
              </div>
              
              <input type="submit" class="btn btn-block btn-success" value="表單提交">
              <input type="reset" class="btn btn-block btn-default" value="重置">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
