from django.shortcuts import render
from django.http import HttpResponseRedirect
from django.conf import settings
from datetime import date

from leave.models import Leave_application

# Create your views here.

def index(request):
    dict_for_view = {}
    response = render(request, 'backstage/leave/index.html', dict_for_view)
    return response

def leave_apply(request):
    check = True
    request_leave_date = list(map(int, request.POST.get("leave_date").split('-')))
    leave_date = date(request_leave_date[0], request_leave_date[1], request_leave_date[2])
    daterange = (leave_date-date.today()).days
    if daterange < 0:
        check = False
        info = "請確認日期輸入是否正確，謝謝。"

    if check:
        if daterange < 3:
            check = False
            title = "Oops！申請送出失敗。"
            info = "請假須於三天前提出申請，謝謝。"
        else:
            title = "已收到您的申請！"
            info = ""
            add_leave_apply(request)
    else:
        title = "Oops！申請送出失敗。"

    dict_for_view = {
        "check": check,
        "title": title,
        "info": info, 
    }
    response = render(request, 'backstage/leave/result.html', dict_for_view)
    return response

def add_leave_apply(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    applicant_name = request.POST.get("applicant_name")
    applicant_kidSchool = request.POST.get("applicant_kidSchool")
    leave_type= request.POST.get("leave_type")
    leave_reason = request.POST.get("leave_reason")
    leave_date = request.POST.get("leave_date")
    sub_name = request.POST.get("sub_name")
    sub_kidSchool = request.POST.get("sub_kidSchool")

    new_leave = Leave_application()
    new_leave.applicant_name = applicant_name
    new_leave.applicant_kidSchool = applicant_kidSchool
    new_leave.leave_type = leave_type
    new_leave.leave_reason = leave_reason
    new_leave.leave_date = leave_date
    new_leave.sub_name = sub_name
    new_leave.sub_kidSchool = sub_kidSchool
    new_leave.save()

# def leave_list(request):
#     response = HttpResponseRedirect("/backstage/leave")
#     return response

def review_apply(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    
    response = HttpResponseRedirect("/backstage/leave")
    return response