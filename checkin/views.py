from django.shortcuts import render,render_to_response
from django.http import JsonResponse,HttpResponse,HttpResponseRedirect
from .models import *
from user.models import *
#from django.contrib.auth.models import User
from django.contrib.auth import authenticate
from django.contrib import auth
from django.conf import settings
import json , os 
from email.mime.text import MIMEText
from email.mime.application import MIMEApplication
from email.mime.multipart import MIMEMultipart
from smtplib import SMTP
import smtplib, secrets
from pathlib import Path
import datetime 
from etutor.celery import app
from datetime import date
from user.views import get_message_page
# Create your views here.

def add_activity(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    
    if request.POST.get("name") != "" and request.POST.get("name") is not None:
        name = str(request.POST.get("name"))
    else:
        return get_message_page(request,"請輸入名稱")

    if request.POST.get("starting_time") != "" and request.POST.get("starting_time") is not None:
        starting_time = request.POST.get("starting_time")
    else:
        return get_message_page(request,"請輸入開始時間")
    
    if request.POST.get("ending_time") != "" and request.POST.get("ending_time") is not None:
        ending_time = request.POST.get("ending_time")
    else:
        return get_message_page(request,"請輸入結束時間")

    if request.POST.get("location") != "" and request.POST.get("location") is not None:
        location = request.POST.get("location")
    else:
        return get_message_page(request,"請輸入活動地點")

    if request.POST.get("description") != "" and request.POST.get("description") is not None:
        description = request.POST.get("description")
    else:
        description = ""

    if request.POST.get("note") != "" and request.POST.get("note") is not None:
        note = request.POST.get("note")
    else:
        note = ""

    if request.POST.get("isGeneral") == "True":
        isGeneral = True
    elif request.POST.get("isGeneral") == "False":
        isGeneral = False

    new_activity = Activity()
    new_activity.name = name
    new_activity.starting_time = starting_time
    new_activity.ending_time = ending_time
    new_activity.location = location
    new_activity.description = description
    new_activity.note = note
    new_activity.isGeneral = isGeneral
    new_activity.save()


    if isGeneral:
        response = HttpResponseRedirect("/backstage/generalAct/list")
    else:
        companion_objs = Companion.objects.filter(isServing=True)
        for obj in companion_objs:
            tmp = Activity_attendance()
            tmp.Activity_id = new_activity.id
            tmp.User_id = obj.User_id
            tmp.save()
        response = HttpResponseRedirect("/backstage/activity/list")

    return response

def activity_checkin(request):
    check = True
    if request.GET.get("SIDCN") != "" and request.GET.get("SIDCN") is not None:
        student_ID_card_number = request.GET.get("SIDCN")
    else:
        check = False
    if check:
        if request.GET.get("Aid") != "" and request.GET.get("Aid") is not None:
            activity_id = int(request.GET.get("Aid"))
        else:
            check = False
    if check:
        companion_objs = Companion.objects.filter(student_ID_card_number=student_ID_card_number)
        if len(companion_objs) == 0:
            return JsonResponse({
                "isCheckedin" : False,
                "status" : "此號碼尚未登錄，請找助理協助。",
                "status_code" : 0, #0:error,1:success,2:warning
            })
        if not companion_objs[0].isServing:
            return JsonResponse({
                "isCheckedin" : False,
                "status" : "您這學期尚未登錄，請找助理協助",
                "status_code" : 0, 
            })
        companion_user_id = companion_objs[0].User_id
        attendance_objs = Activity_attendance.objects.filter(Activity_id=activity_id,User_id=companion_user_id)
        if len(attendance_objs) == 0:
            return JsonResponse({
                "isCheckedin" : False,
                "status" : "您今日無活動噢～",
                "status_code" : 2,
            })
        if attendance_objs[0].isCheckedin:
            return JsonResponse({
                "isCheckedin" : True,
                "status" : "您今日已經簽到過了～",
                "status_code" : 2,
            })
        attendance_objs[0].checkin_time = str(datetime.datetime.now())
        attendance_objs[0].isCheckedin = True
        attendance_objs[0].save()
        return JsonResponse({
            "isCheckedin" : True,
            "status" : "您已成功簽到！",
            "status_code" : 1,
        })
    else:
        return JsonResponse({
            "isCheckedin" : False,
            "status" : "請檢查您的輸入",
            "status_code" : 0,
        })

def activity_manual_checkin(request):
    check = True
    if request.GET.get("Uid") != "" and request.GET.get("Uid") is not None:
        User_id = int(request.GET.get("Uid"))
    else:
        check = False
    if check:
        if request.GET.get("Aid") != "" and request.GET.get("Aid") is not None:
            activity_id = int(request.GET.get("Aid"))
        else:
            check = False
    if check:
        tmp = Activity_attendance.objects.filter(Activity_id=activity_id,User_id=User_id)
        if len(tmp) > 0:
            tmp[0].isCheckedin = True
            tmp[0].checkin_time = str(datetime.datetime.now())
            tmp[0].save()

    response = HttpResponseRedirect("/backstage/activity/attendance?Aid="+str(activity_id))
    return response
    
def generalAct_manual_checkin(request):
    check = True
    if request.GET.get("id") != "" and request.GET.get("id") is not None:
        attendance_id = int(request.GET.get("id"))
    else:
        check = False
    if check:
        if request.GET.get("Aid") != "" and request.GET.get("Aid") is not None:
            activity_id = int(request.GET.get("Aid"))
        else:
            check = False
    if check:
        tmp = General_activity_attendance.objects.filter(id=attendance_id,Activity_id=activity_id)
        if len(tmp) > 0:
            tmp[0].isCheckedin = True
            tmp[0].checkin_time = str(datetime.datetime.now())
            tmp[0].save()
    response = HttpResponseRedirect("/backstage/generalAct/attendance?Aid="+str(activity_id))
    return response


def delete_activity(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    if request.GET.get("Aid") != "" and request.GET.get("Aid") is not None:
        activity_id = int(request.GET.get("Aid"))
    else:
        return get_message_page(request,"查無活動")
    activity_objs = Activity.objects.filter(id=activity_id)
    if len(activity_objs) == 0:
        return get_message_page(request,"查無活動")

    if(activity_objs[0].isGeneral):
        attendance_objs = General_activity_attendance.objects.filter(Activity_id=activity_id)
        response = HttpResponseRedirect("/backstage/generalAct/list")
    else:
        attendance_objs = Activity_attendance.objects.filter(Activity_id=activity_id)
        response = HttpResponseRedirect("/backstage/activity/list")    
    for obj in attendance_objs:
        obj.delete()

    activity_objs[0].delete()
    return response

@app.task
def add_today_class(day):
    # day = 1
    schedule_objs = Schedule.objects.filter(day=day)
    if len(schedule_objs) == 0:
        return False
    # 避免重複
    class_objs = Class.objects.filter(date=str(datetime.datetime.now()).split(" ")[0], day=day)
    if len(class_objs) > 0:
        print("add_today_class duplicate")
        return True
    new_class = Class()
    new_class.day = day
    new_class.date = str(datetime.datetime.now()).split(" ")[0]
    new_class.save()
    for obj in schedule_objs:
        if(len(Companion.objects.filter(id=obj.Companion_id, isServing=True)) > 0):
            tmp = Class_attendance()
            tmp.Class_id = new_class.id
            tmp.Companion_id = obj.Companion_id
            tmp.save()
    return True

def manual_add_today_class(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    if request.GET.get("day") != "" and request.GET.get("day") is not None:
        day = int(request.GET.get("day"))
    else:
        return get_message_page(request,"請檢查您的輸入")
    class_objs = Class.objects.filter(date=str(datetime.datetime.now()).split(" ")[0], day=day)
    if len(class_objs) > 0:
        return get_message_page(request,"課程 " + str(datetime.datetime.now()).split(" ")[0] + " 已被創建過")
    schedule_objs = Schedule.objects.filter(day=day)
    # if len(schedule_objs) == 0:
    #     return get_message_page(request,"今日無人上課")
    new_class = Class()
    new_class.day = day
    new_class.date = str(datetime.datetime.now()).split(" ")[0]
    new_class.save()
    for obj in schedule_objs:
        if(len(Companion.objects.filter(id=obj.Companion_id, isServing=True)) > 0):
            tmp = Class_attendance()
            tmp.Class_id = new_class.id
            tmp.Companion_id = obj.Companion_id
            tmp.save()
    return HttpResponseRedirect("/backstage/class/list")
    
    

def delete_class(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    if request.GET.get("Cid") != "" and request.GET.get("Cid") is not None:
        class_id = int(request.GET.get("Cid"))
    else:
        return get_message_page(request,"查無活動")
    class_objs = Class.objects.filter(id=class_id)
    if len(class_objs) == 0:
        return get_message_page(request,"查無活動")

    attendance_objs = Class_attendance.objects.filter(Class_id=class_id)
    for obj in attendance_objs:
        obj.delete()

    class_objs[0].delete()
    response = HttpResponseRedirect("/backstage/class/list")
    return response

def class_checkin(request):
    check = True
    if request.GET.get("SIDCN") != "" and request.GET.get("SIDCN") is not None:
        student_ID_card_number = request.GET.get("SIDCN")
    else:
        check = False
    if check:
        if request.GET.get("Cid") != "" and request.GET.get("Cid") is not None:
            class_id = int(request.GET.get("Cid"))
        else:
            check = False
    if check:
        companion_objs = Companion.objects.filter(student_ID_card_number=student_ID_card_number)
        if len(companion_objs) == 0:
            return JsonResponse({
                "isCheckedin" : False,
                "status" : "此號碼尚未登錄，請找助理協助。",
                "status_code" : 0, #0:error,1:success,2:warning
            })
        if not companion_objs[0].isServing:
            return JsonResponse({
                "isCheckedin" : False,
                "status" : "您這學期尚未登錄，請找助理協助",
                "status_code" : 0, 
            })
        attendance_objs = Class_attendance.objects.filter(Class_id=class_id,Companion_id=companion_objs[0].id)
        if len(attendance_objs) == 0:
            return JsonResponse({
                "isCheckedin" : False,
                "status" : "您今日無活動噢～",
                "status_code" : 2,
            })
        if attendance_objs[0].isCheckedin:
            return JsonResponse({
                "isCheckedin" : True,
                "status" : "您今日已經簽到過了～",
                "status_code" : 2,
            })
        attendance_objs[0].checkin_time = str(datetime.datetime.now())
        attendance_objs[0].isCheckedin = True
        attendance_objs[0].save()
        return JsonResponse({
            "isCheckedin" : True,
            "status" : "您已成功簽到！",
            "status_code" : 1,
        })
    else:
        return JsonResponse({
            "isCheckedin" : False,
            "status" : "請檢查您的輸入",
            "status_code" : 0,
        })
def class_manual_checkin(request):
    check = True
    if request.GET.get("cid") != "" and request.GET.get("cid") is not None:
        companion_id = int(request.GET.get("cid"))
    else:
        check = False
    if check:
        if request.GET.get("Cid") != "" and request.GET.get("Cid") is not None:
            class_id = int(request.GET.get("Cid"))
        else:
            check = False
    if check:
        tmp = Class_attendance.objects.filter(Class_id=class_id,Companion_id=companion_id)
        if len(tmp) > 0:
            tmp[0].isCheckedin = True
            tmp[0].checkin_time = str(datetime.datetime.now())
            tmp[0].save()

    response = HttpResponseRedirect("/backstage/class/attendance?Cid="+str(class_id))
    return response

def add_substitute_companion(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    print(request.POST.get("class_id"),request.POST.get("companion_id"))
    if request.POST.get("companion_id") != "" and request.POST.get("companion_id") is not None:
        companion_id = int(request.POST.get("companion_id"))
    else:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    if request.POST.get("class_id") != "" and request.POST.get("class_id") is not None:
        class_id = int(request.POST.get("class_id"))
    else:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    # 避免重複
    class_att_objs = Class_attendance.objects.filter(Class_id=class_id, Companion_id=companion_id)
    if len(class_att_objs) > 0:
        return get_message_page(request,"該大學伴已存在課程名單中")
    tmp = Class_attendance()
    tmp.Class_id = class_id
    tmp.Companion_id = companion_id
    tmp.save()
    response = HttpResponseRedirect("/backstage/class/attendance?Cid="+str(class_id))
    return response

# external user checkin
def index(request):
    dict_for_view = {}
    response = render(request, 'backstage/class/external_checkin.html', dict_for_view)
    return response

def external_user_checkin(request):
    check = True
    # check input data
    if request.POST.get("checkin_class_date") != "" and request.POST.get("checkin_class_date") is not None:
        # class_date = date.fromisoformat(request.POST.get("checkin_class_date")) # isoformat='YYYY-MM-DD', fromisoformat() New in version python3.7 
        request_class_date = list(map(int, request.POST.get("checkin_class_date").split('-')))
        class_date = date(request_class_date[0], request_class_date[1], request_class_date[2])
        # 只可簽到當日課程
        if class_date != date.today():
            check = False
            info = "課程不可跨日簽到，如需補簽請找助理協助，謝謝。"
    else:
        check = False
    if request.POST.get("checkin_stuID") != "" and request.POST.get("checkin_stuID") is not None:
        stuID = request.POST.get("checkin_stuID")
    else:
        check = False
    # check data exist
    if check:
        companion_objs = Companion.objects.filter(student_ID_number=stuID)
        class_objs = Class.objects.filter(date=class_date)

        if len(companion_objs) > 0:
            companion_obj = companion_objs[0]
        else:
            check = False
            info = "學號 [ " + stuID + " ] 不在課程 [ " + str(class_date) + " ] 名單中，請先檢查您的輸入，若還是無法請找助理協助，謝謝。"

        if len(class_objs) > 0:
            class_obj = class_objs[0]
        else:
            check = False
            info = "課程 [ " + str(class_date) + " ] 不存在請確認好上課日期再次輸入，若還是無法請找助理協助，謝謝。"
    # checkin
    if check:
        class_att_objs = Class_attendance.objects.filter(Class_id=class_obj.id,Companion_id=companion_obj.id)
        if len(class_att_objs) > 0 and class_att_objs[0].isCheckedin == True:
            check = False
            title = "Oops！簽到失敗。"
            info = "[ " + stuID + " " + companion_obj.get_name() + " ] 在課程 [ " + str(class_date) + " ] 已經簽到過囉，" 
            info += "簽到時間 [ " + class_att_objs[0].checkin_time.strftime("%Y-%m-%d %H:%M") + " ]，如有疑問請找助理協助，謝謝。"
        elif len(class_att_objs) > 0:
            class_att_objs[0].isCheckedin = True
            class_att_objs[0].checkin_time = str(datetime.datetime.now())
            class_att_objs[0].save()
            title = "簽到成功！"
            info = "[ 課程 " + str(class_date) + " ] " + stuID + " " + companion_obj.get_name()
        else:
            check = False
            title = "Oops！簽到失敗。"
            info = "學號 [ " + stuID + " ] 不在課程 [ " + str(class_date) + " ] 名單中，請先檢查您的輸入，若還是無法請找助理協助，謝謝。"
    else:
        title = "Oops！簽到失敗。"
    
    dict_for_view = {
        "check": check,
        "title": title,
        "info": info, 
    }
    response = render(request, 'backstage/class/external_checkin_result.html', dict_for_view)
    return response