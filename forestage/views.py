from django.shortcuts import render,render_to_response
from django.http import JsonResponse,HttpResponse,HttpResponseRedirect
from .models import *
from checkin.models import *
import datetime
# Create your views here.

def index(request):
    dict_for_view = {}
    response = render(request, '404.html',dict_for_view)
    return response

def page_404(request):
    dict_for_view = {}
    response = render(request, '404.html',dict_for_view)
    return response

def page_500(request):
    dict_for_view = {}
    response = render(request, '500.html',dict_for_view)
    return response

def activity_form(request):
    if request.GET.get("Aid") != "" and request.GET.get("Aid") is not None:
        activity_id = request.GET.get("Aid")
    else:
        return HttpResponseRedirect("/index")
    activity_obj = Activity.objects.filter(id=activity_id)
    if len(activity_obj) > 0:
        ending_time = activity_obj[0].ending_time
    else:
        return HttpResponseRedirect("/index")
    # check act_form avaliable
    if ending_time < datetime.datetime.now():
        activity_name = activity_obj[0].name
        msg = "活動已結束!"
        return render(request, 'forestage/formResponse.html',locals())        
    dict_for_view = {
        "activity" : activity_obj[0],
    }
    response = render(request, 'forestage/activity_form.html',dict_for_view)
    return response

def add_application(request):
    if request.method == 'POST':
        new_appli = General_activity_attendance()
        new_appli.department_id = request.POST.get("department")
        new_appli.grade = request.POST.get("grade")
        new_appli.student_ID_number = request.POST.get("student_ID_number")
        new_appli.name = request.POST.get("Name")
        new_appli.Activity_id = request.POST.get("activity_id")
        new_appli.save()
        msg = "活動報名成功!我們已經收到您回覆的表單。"
        activity_name = request.POST.get("activity_name")
        response = render(request, "forestage/formResponse.html", locals()) # return result
    else:
        response = HttpResponseRedirect("activity_form")# redirect
    return response