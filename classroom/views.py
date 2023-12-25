from django.shortcuts import render
from django.http import HttpResponseRedirect
from django.conf import settings
from datetime import date
from .models import *
from user.models import Companion, Partner_school, Student, User
import pandas as pd
import json

class Table:
    def __init__(self, school_name):
        self.school_name = school_name
        self.rows = list()

    def add_row(self, row):
        self.rows.append(row)

class Row:
    def __init__(self, student_id, student_name, p1_companion_name, p1_subj, p2_companion_name, p2_subj, today_meet_code):
        self.student_id = student_id
        self.student_name = student_name
        self.p1_companion_name = p1_companion_name
        self.p1_subj = p1_subj
        self.p2_companion_name = p2_companion_name
        self.p2_subj = p2_subj
        self.today_meet_code = today_meet_code

def get_today_meet(school, student):
    today = date.today()
    weekday = today.isoweekday()
    timeTB = Timetable.objects.get(partner_school=school, weekday=weekday) # get today time group
    timeGroup = timeTB.timeGroup

    # if timeGroup = 0, href = 'None', else href = today timeGroup companion_meet_code 
    if timeGroup == 0:
        return 'None'
    else:
        pair = Pairing_table.objects.filter(timeGroup=timeGroup, partner_school=school, student=student) # get pair

    # check if substute
    sub = Substitute.objects.filter(pairing_table=pair[0], sub_date=today)
    if len(sub) > 0:
        meet = Meet.objects.filter(companion=sub[0].sub_companion)
    else:
        meet = Meet.objects.filter(companion=pair[0].companion)

    # check if null
    if len(meet) > 0:
        meet_code = meet[0].meet_code
    else:
        meet_code = 'None'

    return meet_code

def school_entrance(request):
    school_list = Partner_school.objects.all()
    dict_for_view = {
        "school_list" : school_list,
        "school_ids" : json.dumps([school.id for school in school_list]),
    }
    response = render(request, 'backstage/classroom/school_entrance.html', dict_for_view)
    return response

# Create your views here.
def classroom_entrance(request, school_id):
    tbs = list()
    school_list = Partner_school.objects.filter(id=school_id)
    
    # 建立基本配對表
    if len(school_list) == 0:
        response = HttpResponseRedirect("/classroom/")
        return response
    else:
        school = school_list[0]
        tb = Table(school_name=school.name)
        students = Student.objects.filter(partner_school_id = school.id)
        for student in students:
            pair1 = Pairing_table.objects.filter(partner_school=school, student=student, timeGroup=1)
            pair2 = Pairing_table.objects.filter(partner_school=school, student=student, timeGroup=2)

            if len(pair1) > 0 and len(pair2) > 0:
                today_meet_code = get_today_meet(school, student)
                row = Row(
                    student_id = student.id,
                    student_name = student.name,
                    p1_companion_name = pair1[0].companion.get_name(),
                    p1_subj = pair1[0].subj,
                    p2_companion_name = pair2[0].companion.get_name(),
                    p2_subj = pair2[0].subj,
                    today_meet_code = today_meet_code
                )
            elif len(pair1) == 0 and len(pair2) == 0:
                row = Row(
                    student_id = student.id,
                    student_name = student.name,
                    p1_companion_name = "",
                    p1_subj = "",
                    p2_companion_name = "",
                    p2_subj = "",
                    today_meet_code = "None"
                )
            elif len(pair1) == 0:
                row = Row(
                    student_id = student.id,
                    student_name = student.name,
                    p1_companion_name = "",
                    p1_subj = "",
                    p2_companion_name = pair2[0].companion.get_name(),
                    p2_subj = pair2[0].subj,
                    today_meet_code = "None"
                )
            else:
                row = Row(
                    student_id = student.id,
                    student_name = student.name,
                    p1_companion_name = pair1[0].companion.get_name(),
                    p1_subj = pair1[0].subj,
                    p2_companion_name = "",
                    p2_subj = "",
                    today_meet_code = "None"
                )
            tb.add_row(row)
        tbs.append(tb)

    dict_for_view = {
        "tbs": tbs,
    }
    response = render(request, 'backstage/classroom/classroom_entrance.html', dict_for_view)
    return response

def update_meet(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    meet_objs = Meet.objects.all()
    for meet_obj in meet_objs:
        meet_code = request.POST.get("meet_code_"+str(meet_obj.companion.id))
        if type(meet_code) == str:
            meet_code = meet_code.strip()

        if meet_code == "" or meet_code is None:
            meet_obj.meet_code = 'None'
        else:
            meet_obj.meet_code = meet_code
        meet_obj.save()

    response = HttpResponseRedirect("/backstage/classroom/meet/serving")
    return response


# def tmp_add_data(request):
#     message = "Temp Add Done"
#     # add_timeTB()
#     # add_pairs()
#     add_google_meet()
#     dict_for_view = {
#         "message" : message,
#     }
#     response = render(request, 'message.html', dict_for_view)
#     return response