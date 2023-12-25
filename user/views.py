from django.shortcuts import render,render_to_response
from django.http import JsonResponse,HttpResponse,HttpResponseRedirect
from .models import *
from classroom.models import Meet
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
from user.Shift import Shift
import pandas as pd
import numpy as np
import random
import copy
from backstage.views import get_base_dict_for_view

# Create your views here.

def get_message_page(request,message):
    dict_for_view = {
        "message" : message,
    }
    response = render(request, 'message.html', dict_for_view)
    return response

def send_mail(sender,password,receivers,subject,content):
    emails = [elem.strip().split(',') for elem in receivers]
    msg = MIMEMultipart()
    msg["Subject"] = subject
    msg["From"] = sender
    msg["To"] = ','.join(receivers)

    msg.preamble = 'Multipart massage.\n'
    part = MIMEText(content)
    msg.attach(part)

    tmp_sender = sender.split("@")
    if tmp_sender[1] == "gmail.com":
        smtp = smtplib.SMTP("smtp.gmail.com:587")
    elif tmp_sender[1] == "ncnu.edu.tw":
        smtp = smtplib.SMTP("smtp.ncnu.edu.tw:25")
    smtp.ehlo()
    if tmp_sender[1] == "gmail.com":
        smtp.starttls()
    smtp.login(sender, password)
        
    smtp.sendmail(msg['From'], emails , msg.as_string())

# def task_sign_up(username,password,email):
#     tmp_objs = User.objects.all()  #只進一次資料庫
#     while True:
#         tmp_code = secrets.token_urlsafe()
#         check = True
#         for obj in tmp_objs:
#             if obj.authentication_key == tmp_code:
#                 check = False
#                 break
#         if check:
#             break

#     #phone_number = request.POST.get("phone_number")
#     new_user = User.objects.create_user(username=username,password=password)
#     new_user.authentication_key = tmp_code
#     new_user.email = email
#     new_user.is_active = False
#     new_user.save()

#     User_id = new_user.id

#     mail_content = "感謝您申請 Etutor 服務帳號"
#     mail_content += "確認連結："+settings.HOST_NAME+"/user/sign_up_check?key="+tmp_code
#     send_mail(settings.SENDER,settings.PASSWORD,[email],"Etutor 服務帳號申請確認",mail_content)
    
# def sign_up(request):
#     # add_connect_log(request,"user.sign_up")
#     username = request.POST.get("username")
#     tmp = User.objects.filter(username=username)
#     if len(tmp) > 0:
#         return get_message_page(request,"此帳號已經被使用")
#     password = request.POST.get("password")
#     password_check = request.POST.get("password_check")
#     if password != password_check:
#         return get_message_page(request,"請確認您的密碼")

#     email = request.POST.get("email")
#     # task_sign_up.delay(username,password,email)
#     task_sign_up(username,password,email)
#     return get_message_page(request,"感謝您申請 Etutor 服務帳號，請至信箱進行確認。")




# def sign_up_check(request):
#     # add_connect_log(request,"user.sign_up_check")
#     if request.GET.get("key") is None:
#         return get_message_page(request,"請確認您的網址")
#     else:
#         key = request.GET.get("key") 
#         user_objs = User.objects.filter(authentication_key=key)
#     if len(user_objs) == 0:
#         return get_message_page(request,"請確認您的網址")
#     else:
#         user_obj = user_objs[0]
#         user_obj.is_active = True
#         user_obj.save()
#         get_all_permission(user_obj.id)
#         dict_for_view = {}
#         response = render(request, 'signup_check.html', dict_for_view)
#         return response


def login(request):
    # add_connect_log(request,"user.login")
    if request.method == 'POST':
        username = request.POST['username']
        password = request.POST['password']
        user = auth.authenticate(username=username, password=password)
        if user is not None:
            if user.is_active:
                auth.login(request,user)
                return HttpResponseRedirect('/backstage/index')
    return get_message_page(request,"登入失敗")

def logout(request):
    # add_connect_log(request,"user.logout")
    auth.logout(request)
    return HttpResponseRedirect('/backstage/login') #toThankPage

# def update_profile(request):
#     if not request.user.is_authenticated:
#         response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
#         return response
#     if not request.user.is_active:
#         response = HttpResponseRedirect("/page_not_found")#頁面可換
#         return response
#     if request.POST.get("line_notify_token") is not None :
#         tmp = User.objects.get(id=request.user.id)
#         tmp.line_bot_token = request.POST.get("line_notify_token") 
#         tmp.save()
#     return HttpResponseRedirect('/backstage/profile') #toThankPage

def add_companion(request):
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
    if request.POST.get("department_id") != "" and request.POST.get("department_id") is not None:
        department_id = int(request.POST.get("department_id"))
    else:
        return get_message_page(request,"請選擇系所")
    if request.POST.get("grade") != "" and request.POST.get("grade") is not None:
        grade = int(request.POST.get("grade"))
    else:
        return get_message_page(request,"請選擇年級")
    if request.POST.get("student_ID_number") != "" and request.POST.get("student_ID_number") is not None:
        student_ID_number = str(request.POST.get("student_ID_number"))
    else:
        return get_message_page(request,"請輸入學號")
    if request.POST.get("student_ID_card_number") != "" and request.POST.get("student_ID_card_number") is not None:
        student_ID_card_number = str(request.POST.get("student_ID_card_number"))
    else:
        return get_message_page(request,"請輸入學生證號碼")

    # if request.FILES.get("photo") is not None:
    #     photo = request.FILES.get("photo")

    if request.POST.get("note") != "" and request.POST.get("note") is not None:
        note = str(request.POST.get("note"))
    else:
        note = ""
    
    new_user = User.objects.create_user(username="s"+student_ID_number,password="s"+student_ID_number)
    new_user.email = ""
    new_user.is_active = False
    new_user.name = name
    new_user.identity = 3
    # new_user.photo = photo
    new_user.save()

    new_companion = Companion()
    new_companion.User_id = new_user.id
    new_companion.department_id = department_id
    new_companion.grade = grade
    new_companion.student_ID_number = student_ID_number
    new_companion.student_ID_card_number = student_ID_card_number
    new_companion.isServing = True
    new_companion.note = note
    new_companion.save()

    new_meet = Meet()
    new_meet.companion = new_companion
    new_meet.save()

    response = HttpResponseRedirect("/backstage/user/companion/serving")
    return response

def delete_companion(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    
    if request.GET.get("Cid") != "" and request.GET.get("Cid") is not None:
        companion_id = int(request.GET.get("Cid"))
    else:
        return get_message_page(request,"查無大學伴")

    companion_objs = Companion.objects.filter(id=companion_id)
    if len(companion_objs) == 0:
        return get_message_page(request,"查無大學伴")
    else:
        companion_obj = companion_objs[0]
        User_id = companion_obj.User_id
        tmp = User.objects.filter(id=User_id)
        if len(tmp) > 0:
            tmp = tmp[0]
            if tmp.photo != "" and tmp.photo is not None:
                if Path(tmp.photo.path).is_file():
                    os.remove(tmp.photo.path)
            tmp.delete()
        for schedule in Schedule.objects.filter(Companion_id=companion_obj.id):
            schedule.delete()
        companion_obj.delete()

        response = HttpResponseRedirect("/backstage/user/companion/serving")
        return response
    
def update_companion(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    companion_objs = Companion.objects.all()
    for obj in companion_objs:
        check = True
        if request.POST.get("companion_id_"+str(obj.id)) != "" and request.POST.get("companion_id_"+str(obj.id)) is not None:
            tmp = User.objects.get(id=obj.User_id)
            tmp.name = str(request.POST.get("name_"+str(obj.id)))
        else:
            check = False
        if request.POST.get("department_id_"+str(obj.id)) != "" and request.POST.get("department_id_"+str(obj.id)) is not None:
            obj.department_id = int(request.POST.get("department_id_"+str(obj.id)))
        else:
            check = False
            # return get_message_page(request,"請選擇系所")
        if request.POST.get("grade_"+str(obj.id)) != "" and request.POST.get("grade_"+str(obj.id)) is not None:
            obj.grade = int(request.POST.get("grade_"+str(obj.id)))
        else:
            check = False
            # return get_message_page(request,"請選擇年級")
        if request.POST.get("student_ID_number_"+str(obj.id)) != "" and request.POST.get("student_ID_number_"+str(obj.id)) is not None:
            obj.student_ID_number = str(request.POST.get("student_ID_number_"+str(obj.id)))
        else:
            check = False
            # return get_message_page(request,"請輸入學號")
        if request.POST.get("student_ID_card_number_"+str(obj.id)) != "" and request.POST.get("student_ID_card_number_"+str(obj.id)) is not None:
            obj.student_ID_card_number = str(request.POST.get("student_ID_card_number_"+str(obj.id)))
        else:
            check = False
            # return get_message_page(request,"請輸入學生證號碼")
        
        if str(request.POST.get("isServing_"+str(obj.id))) == "on":
            obj.isServing = True
        else:
            obj.isServing = False

        # if request.FILES.get("photo_"+str(obj.id)) is not None:
        #     photo = request.FILES.get("photo_"+str(obj.id))

        if request.POST.get("note_"+str(obj.id)) != "" and request.POST.get("note_"+str(obj.id)) is not None:
            obj.note = str(request.POST.get("note_"+str(obj.id)))
        else:
            obj.note = ""
        if check:
            obj.save()
            tmp.save()
    response = HttpResponseRedirect("/backstage/user/companion/serving")
    return response

def update_schedule(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    companion_objs = Companion.objects.filter(isServing=True)
    for companion in companion_objs:
        checkExist = False
        if request.POST.get("companion_id_"+str(companion.id)) != "" and request.POST.get("companion_id_"+str(companion.id)) != None:
            schedule_objs = Schedule.objects.filter(Companion_id=companion.id)
            for i in range(1,6):
                if request.POST.get("day"+str(i)+"_"+str(companion.id)) == "on":
                    check = False
                    for obj in schedule_objs:
                        if obj.day == i:
                            check = True
                            break
                    if not check:
                        tmp = Schedule()
                        tmp.Companion_id = companion.id
                        tmp.day = i
                        tmp.save()
                else:
                    for obj in schedule_objs:
                        if obj.day == i:
                            obj.delete()
                            break
    response = HttpResponseRedirect("/backstage/user/schedule")
    return response
        
            
def get_all_serving_companions_of_one_department(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    if request.GET.get("department_id") != "" and request.GET.get("department_id") is not None:
        department_id = int(request.GET.get("department_id"))
    else:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    
    companion_objs = Companion.objects.filter(isServing=True,department_id=department_id)
    if len(companion_objs) == 0:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    
    companion_list = []
    for obj in companion_objs:
        name = ""
        tmp = User.objects.filter(id=obj.User_id)
        if len(tmp) > 0:
            name = tmp[0].name
        companion_list.append({
            "id" : obj.id,
            "name" : name,
        })
    return JsonResponse({"companion_list":companion_list})
    
def stop_all_service(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response

    companion_objs = Companion.objects.filter(isServing=True)
    for obj in companion_objs:
        obj.isServing = False
        obj.save()
    response = HttpResponseRedirect("/backstage/user/companion/not_serving")
    return response

def cancel_all_schedule(request):
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    
    companion_objs = Companion.objects.filter(isServing=True) # get who served
    # everyone cancel
    for companion in companion_objs:
        schedule_objs = Schedule.objects.filter(Companion_id=companion.id) # find that one
        for obj in schedule_objs: # cancel scheduled plan
            obj.delete()
    response = HttpResponseRedirect("/backstage/user/schedule")
    return response

def assign_shift(request):
    # add_connect_log(request,"backstage.index")
    if not request.user.is_authenticated:
        response = HttpResponseRedirect(settings.BACKSTAGE_ROOT+"/login")
        return response
    if not request.user.is_superuser:
        response = HttpResponseRedirect("/page_not_found")#頁面可換
        return response
    extend_breadcrumb_items_array = ["user","assgin_result"]
    dict_for_view = get_base_dict_for_view(request,extend_breadcrumb_items_array)

    # 參數接收
    Shift.opt_subj_score = int(request.POST.get("opt-subj"))*10
    Shift.opt_limit_score = int(request.POST.get("opt-limit"))*10
    Shift.opt_assign_score = int(request.POST.get("opt-assign"))*10

    # 檔案接收
    f_kidSchool = request.FILES.get("f_kidSchool")
    f_kidMate = request.FILES.get("f_kidMate")
    f_uniMate = request.FILES.get("f_uniMate")

    # 資料建立
    if f_kidSchool.name.split('.')[-1] == 'csv':
        df_kidSchool = pd.read_csv(f_kidSchool)
    elif f_kidSchool.name.split('.')[-1] == 'xlsx':
        df_kidSchool = pd.read_excel(f_kidSchool)
    df_kidSchool.columns = ["name", "edu stage", "day", "startTime", "endTime", "subj"]
    
    if f_kidMate.name.split('.')[-1] == 'csv':
        df_kidMate = pd.read_csv(f_kidMate)
    elif f_kidMate.name.split('.')[-1] == 'xlsx':
        df_kidMate = pd.read_excel(f_kidMate)
    df_kidMate.columns = ["edu stage", "school", "name"]
    
    if f_uniMate.name.split('.')[-1] == 'csv':
        df_uniMate = pd.read_csv(f_uniMate)
    elif f_uniMate.name.split('.')[-1] == 'xlsx':
        df_uniMate = pd.read_excel(f_uniMate)
    df_uniMate.columns = ["stuID", "name", "status", "available time", "subject", "limit", "assign"]
    
    info_kidSchool = Shift.create_school_info(df_kidSchool)
    info_kidMate = Shift.create_kidMate_info(df_kidMate)
    info_uniMate = Shift.create_uniMate_info(df_uniMate)

    # 排班
    best_shift = ga_for_shift(info_kidSchool, info_kidMate, info_uniMate)
    # 取得結果
    df_shift = best_shift.get_result()
    best_shift.get_uniMate_status()
    list_shift = list()

    for idx in df_shift.index:
        tmp = {
            "kidSchool": df_shift["kidSchool"][idx],
            "kidMate": df_shift["kidMate"][idx],
            "time": df_shift["time"][idx],
            "subj": df_shift["subj"][idx],
            "uniMate": df_shift["uniMate"][idx],
        }
        list_shift.append(tmp)
    
    for err in best_shift.error:
        if best_shift.error[err] == []:
            best_shift.error[err] = None

    dict_for_view.update({
        'isFit': best_shift.isFit,
        'shift': list_shift,
        'nameErr': best_shift.error['nameErr'],
        'assignErr': best_shift.error['assignErr'],
        'fitErr': best_shift.error['fitErr'],
        'limitErr': best_shift.error['limitErr'],
        "noKidErr": best_shift.error['noKidErr'],
    })
    response = render(request, 'backstage/user/assign_result.html',dict_for_view)
    return response

# Ga 基本設定
def ga_for_shift(info_kidSchool, info_kidMate, info_uniMate):

    genes = list()

    # 根據 kidMate 科目需求建立基本基因模型 (gene)
    for kidID in range(len(info_kidMate)):
        for subj in info_kidMate[kidID]['subjs']:
            tmp = {
                'kidID': kidID,
                'subj': subj,
            }
            genes.append(tmp)

    # 依據 uniMate 可以的時間 (avaTimes) 建立大學伴花名冊 (uniPool)
    uniPool = list()
    for uniID in range(len(info_uniMate)):
        for time in info_uniMate[uniID]['avaTimes']:
            tmp = {
                'uniID': uniID,
                'time': time,
            }
            uniPool.append(tmp)

    print("num_ind: ", len(genes)*70)
    best_ind = ga_generate_best_ind(genes, uniPool,max_iteration_time=200, num_ind=len(genes)*70)

    return best_ind 

# GA 產生最佳解
def ga_generate_best_ind(genes, uniPool, 
                            num_ind = 1000, 
                            max_iteration_time = 500,
                            survival_rate = 0.3,
                            prob_mutation = 0.01,
                            num_gene_to_mutate = 1):

    # 初始群體
    group = list()
    for i in range(num_ind): # 產生 num_individual 個 Shift
        group.append(Shift(random.sample(uniPool, len(genes)))) # 不重複抽樣
        # group.append(Shift(np.random.choice(uniPool, len(genes)))) # shift[i].comb = 從 uniPool 重複抽樣 gene 個

    # 演化
    best_fitness = 0
    best_individual = None
    for generation in range(max_iteration_time):

        # print("[", generation, "]", end=" ")
        # count fitness
        list_fitness = list()
        total_fitness = 0
        for ind in group:
            ind_fitness = ind.get_fitness(genes)
            list_fitness.append(ind_fitness)
            if(ind_fitness > best_fitness):
                best_fitness = ind_fitness
                best_ind = ind

        # print(best_fitness)
        if best_fitness == 1:
            break

        # Selection
        new_group = list()
        num_survivor = int(num_ind*survival_rate)
        
        # 取 fitness 大的前 num_survivor 個
        count = 0
        for indID in np.argsort(list_fitness)[::-1]:
            if(count == num_survivor):
                break
            new_group.append(group[indID])
            count += 1

        # Crossover
        pool = copy.deepcopy(new_group)
        for _ in range(num_ind - num_survivor):
            
            new_ind = Shift([]) # 建一個新人
            parents = random.sample(pool, 2) # 從 new_group 隨機取 2 (不重複) crossover
            
            # (Crossover) rand parents comb 重組成 new_ind
            for i in range(len(parents[0].comb)):
                choice = random.randrange(2)
                new_ind.comb.append(parents[choice].comb[i])
            new_group.append(new_ind)
        group = copy.deepcopy(new_group)
        
        # Mutation
        mut_ind = random.sample(group, int(num_ind*prob_mutation)) # 突變的個體
        genePool = [i for i in range(len(genes))]
        for ind in mut_ind:
            mutate_genes = random.sample(genePool, num_gene_to_mutate)
            for geneID in mutate_genes:
                ind.comb[geneID] = random.sample(uniPool, 1)[0]

    return best_ind