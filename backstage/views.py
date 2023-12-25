from django.shortcuts import render,render_to_response
from django.http import JsonResponse,HttpResponse,HttpResponseRedirect
from .models import *
from user.models import *
from checkin.models import *
from score.models import *
from score_revision.models import *
from classroom.models import *
# from leave.models import *
from django.urls import reverse

from django.contrib.auth import authenticate
from django.contrib import auth
from django.conf import settings
import json , os 
import math
from datetime import datetime, timedelta


def get_extend_breadcrumb_items(items_array):
    extend_breadcrumb_items = []
    for i in range(len(items_array)):
        tmp_string = ""
        for j in range(i+1):
            tmp_string += "/"+items_array[j]
        extend_breadcrumb_items.append({
            "title" : items_array[i],
            "link" : settings.BACKSTAGE_ROOT+tmp_string,
            "isActive" : False,
        })
    extend_breadcrumb_items[-1]["isActive"] = True
    return extend_breadcrumb_items

### 設定一次，全部通用
def get_breadcrumb_menu():
    menu = [
        {
            "title" : "Dashboard", 
            "link" : "#",
        }
    ]

    return menu

def get_side_nav(request):
    category = [{
        'title': 'etutor', 
        'app': [{
                'name': '簽到系統', 
                'icon': 'border_color', 
                'isDropdown': True, 
                'item': [
                    {
                        'title': '課程', 
                        'link': '/backstage/class/list', 
                        'icon': 'local_library'
                    }, 
                    {
                        'title': '大學伴活動', 
                        'link': '/backstage/activity/list', 
                        'icon': 'directions_bike'
                    },
                    {
                        'title': '公開活動', 
                        'link': '/backstage/generalAct/list', 
                        'icon': 'directions_bike'
                    },
                    {
                        'title': '大學伴獎助金輸出', 
                        'link': '/backstage/salary/list', 
                        'icon': 'attach_money'
                    }
                ]
            }, 
            {
                'name': '人員管理', 
                'icon': 'people', 
                'isDropdown': True, 
                'item': [
                    {
                        'title': '大學伴', 
                        'link': '/backstage/user/companion/serving', 
                        'icon': 'person'
                    }, 
                    {
                        'title': '排班列表', 
                        'link': '/backstage/user/schedule', 
                        'icon': 'schedule'
                    },
                    {
                        'title': '自動排班', 
                        'link': '/backstage/user/assign',  
                        'icon': 'event_note'
                    }
                ]
            },
            # {
            #     'name': '請假系統',
            #     'icon': 'assignment',
            #     'isDropdown': False,
            #     'item': [
            #         {
            #             'title': '請假管理',
            #             'link': '/backstage/leave/list',
            #             'icon': 'assignment_ind'
            #         }
            #     ]
            # },
            {
                'name': '線上教室管理', 
                'icon': 'devices', 
                'isDropdown': True, 
                'item': [
                    {
                        'title': '會議室管理', 
                        'link': '/backstage/classroom/meet/serving', 
                        'icon': 'videocam'
                    }
                ]
            }, 
            {
                'name': '期末評比', 
                'icon': 'subject', 
                'isDropdown': False, 
                'item': [
                    {
                        'title': '期末評比', 
                        'link': '/backstage/score_revision/list', 
                        # 'link': '/backstage/score/list', 
                        'icon': 'subject'
                    }
                ]
            }]
        }]
        
    side_nav = {
        "category" : category,
    }

    return side_nav


def get_base_dict_for_view(request,extend_breadcrumb_items_array):
    extend_breadcrumb_items = get_extend_breadcrumb_items(extend_breadcrumb_items_array)
    dict_for_view = {
        "BACKSTAGE_ROOT" : settings.BACKSTAGE_ROOT,
        "extend_breadcrumb_items" : extend_breadcrumb_items,
        "breadcrumb_menu" : get_breadcrumb_menu(),
        "side_nav" : get_side_nav(request),
    }
    return dict_for_view
###

def response_404_page(request):
    dict_for_view = {}
    response = render(request, '404.html',dict_for_view)
    return response

def response_500_page(request):
    dict_for_view = {}
    response = render(request, '500.html',dict_for_view)
    return response

def login_page(request):
    # add_connect_log(request,"backstage.login_page")
    dict_for_view = {}
    response = render(request, 'backstage/login.html',dict_for_view)
    return response

def signup_page(request):
    # add_connect_log(request,"backstage.signup_page")
    dict_for_view = {}
    response = render(request, 'backstage/signup.html',dict_for_view)
    return response

def index(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    extend_breadcrumb_items_array = ["index"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    response = render(request, 'backstage/index.html',dict_for_view)
    return response

# def profile(request):
#     # add_connect_log(request,"backstage.index")
#     if not request.user.is_authenticated:
#         response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
#         return response
#     if not request.user.is_superuser:
#         response = HttpResponseRedirect("/page_not_found")#頁面可換
#         return response

#     extend_breadcrumb_items_array = ["profile"]
#     dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)
#     dict_for_view.update({
#         "authentication_key" : request.user.authentication_key,
#         "line_notify_token" : request.user.line_bot_token,
#     })
#     response = render(request, 'backstage/profile.html',dict_for_view)
#     return response

def get_partner_school_name_by_id(partner_school_id):
    tmp = Partner_school.objects.filter(id=partner_school_id)
    if len(tmp) == 0:
        return "查無學校"
    else:
        return tmp[0].name

def get_department_name_by_id(department_id):
    tmp = Department.objects.filter(id=department_id)
    if len(tmp) == 0:
        return "查無單位"
    else:
        return tmp[0].name

def get_identity_obj(identity,user_id):
    if identity == 2:
        tmp = Teacher.objects.filter(User_id=user_id)
        if len(tmp) == 0:
            return None
        else:
            return tmp[0]
    elif identity == 3:
        tmp = Companion.objects.filter(User_id=user_id)
        if len(tmp) == 0:
            return None
        else:
            return tmp[0]
    elif identity == 4:
        tmp = Student.objects.filter(User_id=user_id)
        if len(tmp) == 0:
            return None
        else:
            return tmp[0]
    else:
        return None

def get_user_name(user_id):
    name = ""
    tmp = User.objects.filter(id=user_id)
    if len(tmp) > 0:
        name = tmp[0].name
    return name

def get_grade_objs():
    grade_objs = []
    IDs = [11,12,13,14,15,16,21,22,23,31,32,33,41,42,43,44,45,46,47,51,52,53,54,61,62,63,64,65,66,67,68]
    NAMEs = [
        "小學一年級",
        "小學二年級",
        "小學三年級",
        "小學四年級",
        "小學五年級",
        "小學六年級",
        "國中一年級",
        "國中二年級",
        "國中三年級",
        "高中一年級",
        "高中二年級",
        "高中三年級",
        "大學一年級",
        "大學二年級",
        "大學三年級",
        "大學四年級",
        "大學五年級",
        "大學六年級",
        "大學七年級",
        "研究所一年級",
        "研究所二年級",
        "研究所三年級",
        "研究所四年級",
        "博士班一年級",
        "博士班二年級",
        "博士班三年級",
        "博士班四年級",
        "博士班五年級",
        "博士班六年級",
        "博士班七年級",
        "博士班八年級",
    ]

    for i in range(len(IDs)):
        grade_objs.append({
            "id" : IDs[i],
            "name" : NAMEs[i],
        })
    return grade_objs

def decode_grade(grade):
    dictionary = {
        11:"小學一年級",
        12:"小學二年級",
        13:"小學三年級",
        14:"小學四年級",
        15:"小學五年級",
        16:"小學六年級",
        21:"國中一年級",
        22:"國中二年級",
        23:"國中三年級",
        31:"高中一年級",
        32:"高中二年級",
        33:"高中三年級",
        41:"大學一年級",
        42:"大學二年級",
        43:"大學三年級",
        44:"大學四年級",
        45:"大學五年級",
        46:"大學六年級",
        47:"大學七年級",
        51:"研究所一年級",
        52:"研究所二年級",
        53:"研究所三年級",
        54:"研究所四年級",
        61:"博士班一年級",
        62:"博士班二年級",
        63:"博士班三年級",
        64:"博士班四年級",
        65:"博士班五年級",
        66:"博士班六年級",
        67:"博士班七年級",
        68:"博士班八年級",
    } 
    
    return dictionary[grade]

def decode_sex(sex):
    dictionary = {
        1 : "女",
        2 : "男",
    }
    return dictionary[sex]

def decode(day):
    if day > 7 or day < 1:
        return "無"
    dictionary = {
        1 : "一",
        2 : "二",
        3 : "三",
        4 : "四",
        5 : "五",
        6 : "六",
        7 : "日",
    }
    return dictionary[day]

def get_companion_department():
    department_objs = [
        {
            "id" : 49,
            "name" : "中國語文學系",
        },
        {
            "id" : 50,
            "name" : "外國語文學系",
        },
        {
            "id" : 51,
            "name" : "社會政策與社會工作學系",
        },
        {
            "id" : 52,
            "name" : "公共行政與政策學系",
        },
        {
            "id" : 53,
            "name" : "歷史學系",
        },
        {
            "id" : 54,
            "name" : "東南亞學系",
        },
        {
            "id" : 55,
            "name" : "華語文教學碩士學位學程",
        },
        {
            "id" : 56,
            "name" : "非營利組織經營管理碩士學位學程",
        },
        {
            "id" : 57,
            "name" : "原鄉發展跨領域學士學位學程原住民專班",
        },
        {
            "id" : 59,
            "name" : "國際企業學系",
        },
        {
            "id" : 60,
            "name" : "經濟學系",
        },
        {
            "id" : 61,
            "name" : "資訊管理學系",
        },
        {
            "id" : 62,
            "name" : "財務金融學系",
        },
        {
            "id" : 63,
            "name" : "觀光休閒與餐旅管理學系",
        },
        {
            "id" : 67,
            "name" : "土木工程學系",
        },
        {
            "id" : 68,
            "name" : "資訊工程學系",
        },
        {
            "id" : 69,
            "name" : "電機工程學系",
        },
        {
            "id" : 70,
            "name" : "應用化學系",
        },
        {
            "id" : 72,
            "name" : "應用材料及光電工程學系",
        },
        {
            "id" : 75,
            "name" : "國際文教與比較教育學系",
        },
        {
            "id" : 76,
            "name" : "教育政策與行政學系",
        },
        {
            "id" : 77,
            "name" : "諮商心理與人力資源發展學系",
        },
        {
            "id" : 78,
            "name" : "管院學士班",
        },
        {
            "id" : 79,
            "name" : "教院學士班",
        },
        {
            "id" : 117,
            "name" : "課程教學與科技研究所",
        },
    ]
    return department_objs

def companion_page(request,isServing):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    if isServing == "not_serving":
        companion_objs = Companion.objects.filter(isServing=False)
        isServing = False
    elif isServing == "serving":
        companion_objs = Companion.objects.filter(isServing=True)
        isServing = True
    else:
        return HttpResponseRedirect("/backstage/user/companion/serving")

    extend_breadcrumb_items_array = ["user","companion"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)
    
    companion_list = []
    for companion_obj in companion_objs:
        tmp = {
            "id" : companion_obj.id,
            "name" : get_user_name(companion_obj.User_id),
            "department_id" : companion_obj.department_id,
            "department" : get_department_name_by_id(companion_obj.department_id),
            "grade_id" : companion_obj.grade,
            "grade" : decode_grade(companion_obj.grade),
            "student_ID_number" : companion_obj.student_ID_number,
            "student_ID_card_number" : companion_obj.student_ID_card_number,
            "isServing" : companion_obj.isServing,
            "note" : companion_obj.note,
        }
        companion_list.append(tmp)
    # department_objs = Department.objects.all()
    department_objs = get_companion_department()
    grade_objs = get_grade_objs()[12:23]
    dict_for_view.update({
        "companion_list" : companion_list,
        "department_objs" : department_objs,
        "grade_objs" : grade_objs,
        "isServing" : isServing,
    })
        
    response = render(request, 'backstage/user/companion.html',dict_for_view)
    return response

def schedule_page(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["user","schedule"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    tmp_companion_objs = Companion.objects.filter(isServing=True)
    companion_objs = []
    for obj in tmp_companion_objs:
        day = [False for i in range(5)]
        schedule_objs = Schedule.objects.filter(Companion_id=obj.id)
        for s in schedule_objs:
            day[s.day-1] = True
        companion_objs.append({
            "id" : obj.id,
            "name" : get_user_name(obj.User_id),
            "day1" : day[0],
            "day2" : day[1],
            "day3" : day[2],
            "day4" : day[3],
            "day5" : day[4],
        })
        

    dict_for_view.update({
        "companion_objs" : companion_objs,
    })
    response = render(request, 'backstage/user/schedule.html',dict_for_view)
    return response

def assign_page(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["user","assign"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    response = render(request, 'backstage/user/assign.html',dict_for_view)
    return response

def activity_list_page(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["activity","list"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    activity_objs = Activity.objects.filter(isGeneral=False)
    dict_for_view.update({
        "activity_objs" : activity_objs,
    })

    response = render(request, 'backstage/activity/list.html',dict_for_view)
    return response

def activity_attendance_page(request):
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
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    activity_objs = Activity.objects.filter(id=activity_id)
    if len(activity_objs) == 0:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    extend_breadcrumb_items_array = ["activity","attendance"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    participant_objs = []
    attendance_objs = Activity_attendance.objects.filter(Activity_id=activity_id)
    for obj in attendance_objs:
        user_objs = User.objects.filter(id=obj.User_id)
        if len(user_objs) == 0:
            tmp_name = ""
        else:
            tmp_name = user_objs[0].name
        if obj.isCheckedin : 
            checkin_time = obj.checkin_time
        else:
            checkin_time = ""
        participant_objs.append({
            "name" : tmp_name,
            "User_id" : obj.User_id,
            "isCheckedin" : obj.isCheckedin,
            "checkin_time" : checkin_time,
        })

    dict_for_view.update({
        "activity" : activity_objs[0],
        "participant_objs" : participant_objs,
    })

    response = render(request, 'backstage/activity/attendance.html',dict_for_view)
    return response

def activity_checkin_page(request):
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
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    activity_objs = Activity.objects.filter(id=activity_id)
    if len(activity_objs) == 0:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    dict_for_view = {
        "activity" : activity_objs[0],
    }
    response = render(request, 'backstage/activity/checkin.html',dict_for_view)
    return response

def generalAct_list_page(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["activity","list"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    activity_objs = Activity.objects.filter(isGeneral=True)
    dict_for_view.update({
        "activity_objs" : activity_objs,
    })

    response = render(request, 'backstage/generalAct/list.html',dict_for_view)
    return response

def generalAct_attendance_page(request):
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
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    activity_objs = Activity.objects.filter(id=activity_id)
    if len(activity_objs) == 0:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    extend_breadcrumb_items_array = ["activity","attendance"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    participant_objs = []
    attendance_objs = General_activity_attendance.objects.filter(Activity_id=activity_id)
    for obj in attendance_objs:
        if obj.isCheckedin : 
            checkin_time = obj.checkin_time
        else:
            checkin_time = ""

        participant_objs.append({
            "attendance_id" : obj.id,
            "department" : get_department_name_by_id(obj.department_id),
            "grade" : decode_grade(obj.grade),
            "student_ID_number" : obj.student_ID_number,
            "name" : obj.name,
            "apply_time" : obj.apply_time,
            "isCheckedin" : obj.isCheckedin,
            "checkin_time" : checkin_time,
        })

    dict_for_view.update({
        "activity" : activity_objs[0],
        "participant_objs" : participant_objs,
    })

    response = render(request, 'backstage/generalAct/attendance.html',dict_for_view)
    return response

def class_list_page(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["class","list"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    tmp_class_objs = Class.objects.all()
    class_objs = []
    for obj in tmp_class_objs:
        class_objs.append({
            "id" : obj.id,
            "date" : obj.date,
            "day" : decode(obj.day),
            "note" : obj.note,
        })
    dict_for_view.update({
        "class_objs" : class_objs,
    })

    response = render(request, 'backstage/class/list.html',dict_for_view)
    return response

def class_attendance_page(request):
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
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    class_objs = Class.objects.filter(id=class_id)
    if len(class_objs) == 0:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    extend_breadcrumb_items_array = ["class","attendance"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    companion_list = []
    attendance_objs = Class_attendance.objects.filter(Class_id=class_id)
    for obj in attendance_objs:
        companion_objs = Companion.objects.filter(id=obj.Companion_id)
        if len(companion_objs) > 0:
            companion_id = companion_objs[0].id
            companion_User_id = companion_objs[0].User_id
            department_name = get_department_name_by_id(companion_objs[0].department_id)
            grade = decode_grade(companion_objs[0].grade)
            user_objs = User.objects.filter(id=companion_User_id)
            if len(user_objs) == 0:
                companion_name = ""
            else:
                companion_name = user_objs[0].name
            if obj.isCheckedin : 
                checkin_time = obj.checkin_time
            else:
                checkin_time = ""

            companion_list.append({
                "id" : companion_id,
                "name" : companion_name,
                "department" : department_name,
                "grade" : grade,
                "User_id" : companion_User_id,
                "isCheckedin" : obj.isCheckedin,
                "checkin_time" : checkin_time,
            })
    department_objs = get_companion_department()
    dict_for_view.update({
        "class" : class_objs[0],
        "class_day" : decode(class_objs[0].day),
        "companion_list" : companion_list,
        "department_objs" : department_objs,
    })

    response = render(request, 'backstage/class/attendance.html',dict_for_view)
    return response

def class_checkin_page(request):
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
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    class_objs = Class.objects.filter(id=class_id)
    if len(class_objs) == 0:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    dict_for_view = {
        "class" : class_objs[0],
        "class_day" : decode(class_objs[0].day),
    }
    response = render(request, 'backstage/class/checkin.html',dict_for_view)
    return response

# def redirect_to_score_list_page(request):
#     latest_semester = Score.objects.all().order_by("-id")[0].semester
#     response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/score/list/"+latest_semester)
#     return response

# def score_list_page(request,semester):
#     # add_connect_log(request,"backstage.index")
#     if not request.user.is_authenticated:
#         response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
#         return response
#     if not request.user.is_superuser:
#         response = HttpResponseRedirect("/page_not_found")#頁面可換
#         return response
#     extend_breadcrumb_items_array = ["class","attendance"]
#     dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    
#     if semester != None and semester != "":
#         latest_semester = semester
#         semester_score_objs = Score.objects.filter(semester=semester)
#         if len(semester_score_objs)==0:
#             latest_semester = Score.objects.all().order_by("-id")[0].semester
#             semester_score_objs = Score.objects.filter(semester=latest_semester)
#     else:
#         latest_semester = Score.objects.all().order_by("-id")[0].semester
#         semester_score_objs = Score.objects.filter(semester=latest_semester)
        

#     score_objs = []
#     for obj in semester_score_objs:
#         score_objs.append({
#             "semester": obj.semester,
#             "name": obj.companion.get_name,
#             "student_ID_number" : obj.companion.student_ID_number,
#             "attendence" : obj.score_attendence,
#             "beginning_education": obj.score_beginning_education,
#             "other_activity" : obj.score_other_activity,
#             "together" : obj.score_together,
#             "teaching": obj.score_teaching,
#             "material" : obj.score_material,
#             "log" : obj.score_log,
#             "late": obj.score_late,
#             "other" : obj.score_other,
#             "total": obj.score_total,
#             "note":obj.note,
#         })
#     dict_for_view.update({
#         "semester" : latest_semester,
#         "score_objs" : score_objs
#     })
#     response = render(request, 'backstage/score/list.html', dict_for_view)
#     return response

def redirect_to_score_revision_list_page(request):
    if ScoreRevision.objects.exists() == True:
        latest_semester = ScoreRevision.objects.all().order_by("-id")[0].semester
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/score_revision/list/"+latest_semester)
    else :
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/score_revision/list/1092")

    return response

def score_revision_list_page(request,semester):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["class","attendance"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    
    if semester != None and semester != "":
        latest_semester = semester
        semester_score_objs = ScoreRevision.objects.filter(semester=semester)
        if len(semester_score_objs)==0:
            latest_semester = "1092"
        else : 
            latest_semester = ScoreRevision.objects.all().order_by("-id")[0].semester
        semester_score_objs = ScoreRevision.objects.filter(semester=latest_semester)
    else:
        latest_semester = ScoreRevision.objects.all().order_by("-id")[0].semester
        semester_score_objs = ScoreRevision.objects.filter(semester=latest_semester)
        

    score_objs = []
    for obj in semester_score_objs:
        score_objs.append({
            "semester": obj.semester,
            "name": obj.companion.get_name,
            "student_ID_number" : obj.companion.student_ID_number,
            "attendence" : obj.score_attendence,
            "beginning_education": obj.score_beginning_education,
            "meeting_attendence" : obj.score_meeting_attendence,
            "together" : obj.score_together,
            "teaching1": obj.score_teaching1,
            "teaching2": obj.score_teaching2,
            "material" : obj.score_material,
            "log" : obj.score_log,
            "late": obj.score_late,
            "bonus1" : obj.score_bonus1,
            "bonus2" : obj.score_bonus2,
            "total": obj.score_total,
        })
    dict_for_view.update({
        "semester" : latest_semester,
        "score_objs" : score_objs
    })
    response = render(request, 'backstage/score_revision/list.html', dict_for_view)
    return response

def salary_list_page(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["salary", "list"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)
    if 'startDate' in request.POST:  
        startDate = datetime.strptime(request.POST.get('startDate'), "%Y-%m-%d")
        endDate = datetime.strptime(request.POST.get('endDate'), "%Y-%m-%d")
    else:
        startDate = datetime.now() - timedelta(days=7)
        endDate = datetime.now()
    salary_list = list()
    companion_objs = Companion.objects.filter(isServing=True)
    for companion_obj in companion_objs:
        class_att_objs = Class_attendance.objects.filter(Companion_id=companion_obj.id , isCheckedin=1, checkin_time__range=[startDate, endDate+timedelta(days=1)])
        salary_list.append({
            "stuID":companion_obj.student_ID_number,
            "name":get_user_name(companion_obj.User_id),
            "classTimes":len(class_att_objs),
            "hours":len(class_att_objs)*3,
            "comp_id":companion_obj.id,
        })
    dict_for_view.update({
        "startDate":startDate.strftime('%Y-%m-%d'),
        "endDate":endDate.strftime('%Y-%m-%d'),
        "salary_list":salary_list,
    })
    response = render(request, 'backstage/salary/list.html',dict_for_view)
    return response

def show_salary(request):
    startDate = datetime.strptime(request.POST.get('startDate'), "%Y-%m-%d")
    endDate = datetime.strptime(request.POST.get('endDate'), "%Y-%m-%d")
    salary_list = list()
    for comp in request.POST:
        if comp == 'csrfmiddlewaretoken' or comp == 'startDate' or comp == 'endDate': continue
        comp_id = comp[5:]
        # class_att_objs = Class_attendance.objects.filter(Companion_id=comp_id , isCheckedin=1, checkin_time__gte=startDate, checkin_time__lte=endDate)
        class_att_objs = Class_attendance.objects.filter(Companion_id=comp_id , isCheckedin=1, checkin_time__range=[startDate, endDate+timedelta(days=1)])
        checkin_time_list = [
            {
                "date":obj.checkin_time.strftime('%Y-%m-%d'),
                "time":obj.checkin_time.strftime('%H:%M:%S')

            } 
            for obj in class_att_objs
        ]
        companion_obj = Companion.objects.filter(id=comp_id)[0]
        salary_list.append({
            "stuID":companion_obj.student_ID_number,
            "name":get_user_name(companion_obj.User_id),
            "checkin_time_list":checkin_time_list,
            "hours":len(class_att_objs)*3,
        })
    dict_for_view = {
        "salary_list":salary_list,
    }
    response = render(request, 'backstage/salary/result.html',dict_for_view)
    return response

def meet_page(request,isServing):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    if isServing == "not_serving":
        companion_objs = Companion.objects.filter(isServing=False)
        isServing = False
    elif isServing == "serving":
        companion_objs = Companion.objects.filter(isServing=True)
        isServing = True
    else:
        return HttpResponseRedirect("/backstage/classroom/meet/serving")

    extend_breadcrumb_items_array = ["classroom","meet"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)
    
    companion_list = []
    for companion_obj in companion_objs:
        meet_obj = Meet.objects.get(companion=companion_obj)
        tmp = {
            "id" : companion_obj.id,
            "name" : get_user_name(companion_obj.User_id),
            "student_ID_number" : companion_obj.student_ID_number,
            "isServing" : companion_obj.isServing,
            "meet_code" : meet_obj.meet_code if meet_obj.meet_code != 'None' else "",
        }
        companion_list.append(tmp)
    dict_for_view.update({
        "companion_list" : companion_list,
        "isServing" : isServing,
    })
        
    response = render(request, 'backstage/classroom/meet.html',dict_for_view)
    return response

# def leave_list_page(request):
#     if not request.user.is_authenticated:
#         response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
#         return response
#     if not request.user.is_superuser:
#         response = HttpResponseRedirect("/page_not_found")#頁面可換
#         return response
#     extend_breadcrumb_items_array = ["leave","list"]
#     dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)
    
#     leave_objs = Leave_application.objects.all()
#     dict_for_view.update({
#         "leave_objs" : leave_objs,
#     })
    
#     response = render(request, 'backstage/leave/list.html',dict_for_view)
#     return response