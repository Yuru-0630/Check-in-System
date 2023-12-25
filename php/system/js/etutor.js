function update_state(id)
{
  if(confirm("確定要改變電腦狀態?"))
  {
    $.ajax({
      type:'post',
      url:'../controller/device.php',
      data:{id:id},
      success:function(msg){
        alert(msg);
      }
    });
  }
  else
  {
    window.location="homepage.php";
  }
}

function delete_pair_info(id)
{
  if(confirm("確定要刪除?"))
  {
    window.location.href="../controller/delete_pair.php?id="+id;
  }
}

function delete_user(id,identity)
{
  if(confirm("確定要刪除?"))
  {
    window.location.href="../controller/delete_user.php?id="+id+"&identity="+identity;
  }
}

function delete_activity(id)
{
  if(confirm("確定要刪除?"))
  {
    window.location.href="../controller/delete_activity.php?id="+id;
  }
}

function delete_class(id)
{
  if(confirm("確定要刪除?"))
  {
    window.location.href="../controller/delete_class.php?id="+id;
  }
}

function delete_class_attendance_record(classID,id)
{
  if(confirm("確定要刪除?"))
  {
    window.location.href="../controller/attend.php?act=delete&id="+id+"&cID="+classID;
  }
}

function delete_activity_attendance_record(activityID,id)
{
  if(confirm("確定要刪除?"))
  {
    window.location.href="../controller/activity_attend.php?act=delete&id="+id+"&actID="+activityID;
  }
}

function change_pair_form()
{
  var id = document.getElementById("school").value;
  $.ajax({
      type:'post',
      url:'../controller/get_student_info.php',
      data:{id:id},
      success:function(data)
      {
        var obj = JSON.parse(data);
        var length = data.length;
        var s = document.getElementById("student");
        for(i=0;i<length;i++)
        {
          s.options[i] = new Option(obj[i][1],obj[i][0]);
        }
        s.length = length;
      }
    });
}

function show_pair_form_with_data($student_ID)
{
  var id = document.getElementById("school").value;
  $.ajax({
      type:'post',
      url:'../controller/get_student_info.php',
      data:{id:id},
      success:function(data)
      {
        var obj = JSON.parse(data);
        var length = data.length;
        var s = document.getElementById("student");
        for(i=0;i<length;i++)
        {
          s.options[i] = new Option(obj[i][1],obj[i][0]);
          if(obj[i][0]==$student_ID)
          {
            s.options[i].selected = true;
          }
        }
        s.length = length;
      }
    });
}

$('#companion_check_in_form').bind('submit', function(event){
    event.preventDefault();
    $.ajax({
      url: "../controller/class_check-in.php",
      data: $('#companion_check_in_form').serialize(),
      type: "POST",
      success:function(msg){ 
        if(msg==-1)
        {
          alertify.error("您今日無課程噢～");
        }
        else if(msg==2 || msg==4)
        {
          alertify.success("您已成功簽到！");
        }
        else if(msg==0)
        {
          alertify.error("此號碼尚未登錄，請找助理協助。");
        }
        else if(msg==9)
        {
          alertify.warning("您今日已經簽到過了～");
        }
        else
        {
          alertify.error("請檢查您的輸入");
        }
      },
      error:function(xhr){
        alertify.error('系統發生錯誤');
      },
      complete:function(){
        $('#student_ID_number').val('');
      },
    }); 
});

$('#activity_check_in_form').bind('submit', function(event){
    event.preventDefault();
    $.ajax({
      url: "../controller/activity_check-in.php",
      data: $('#activity_check_in_form').serialize(),
      type: "POST",
      success:function(msg){ 
        if(msg==-1)
        {
          alertify.error("您沒有參加或報名這場活動噢～");
        }
        else if(msg==1)
        {
          alertify.success("您已成功簽到！");
        }
        else if(msg==0)
        {
          alertify.error("此號碼尚未登錄，請找助理協助。");
        }
        else if(msg==9)
        {
          alertify.warning("您今日已經簽到過了～");
        }
        else
        {
          alertify.error("請檢查您的輸入");
        }
      },
      error:function(xhr){
        alertify.error('系統發生錯誤');
      },
      complete:function(){
        $('#student_ID_number').val('');
      },
    }); 
});

$(function(){
  $("#datetimepicker1").datetimepicker({
          format: "Y-m-d H:00:00",
          autoSize : true
  });
});

$(function(){
  $("#datetimepicker2").datetimepicker({
          format: "Y-m-d H:00:00",
          autoSize : true
  });
});
