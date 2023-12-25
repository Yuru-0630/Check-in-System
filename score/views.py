from django.shortcuts import render
from django.http import JsonResponse,HttpResponse,HttpResponseRedirect
import pandas as pd 
from .models import *
from user.models import *

# Create your views here.

def index(request):
	dict_for_view = {}
	response = render(request, 'backstage/score/index.html', dict_for_view)
	return response

def search(request):
	student_ID_number = request.POST.get("student_ID_number")
	return HttpResponseRedirect("/score/search_result/"+student_ID_number)

def search_result(request,student_ID_number):
	companion_objs = Companion.objects.filter(student_ID_number=student_ID_number)
	score = ""
	if len(companion_objs)==0:
		side_info = "Oops"
		title = "不好意思，如果您是大學伴，請先檢查您的輸入，若還是無法查詢，請找助理協助，謝謝您。"
	else:
		latest_semester = Score.objects.all().order_by("-id")[0].semester
		score_objs = Score.objects.filter(companion=companion_objs[0], semester=latest_semester)
		if len(score_objs) == 0:
			side_info = "Oops"
			title = "不好意思，如果您是 "+str(latest_semester)+" 的大學伴，請找助理協助。"
		else:
			# print(score_objs[0].score_total)
			if score_objs[0].score_total >= 80:
				side_info = "恭喜！"
				score = "您的" +str(latest_semester)+ "的成績是" + str(int(score_objs[0].score_total)) + "分。"
				title = "您可以申請 "+str(latest_semester)+" 服務證明。請繼續保持喔~"
			else:
				side_info = "Oops"
				score = "您的" +str(latest_semester)+ "的成績是" + str(int(score_objs[0].score_total)) + "分。"
				title = "不好意思，依照 "+str(latest_semester)+" 的評比，您可能無法申請服務證明。"

	dict_for_view = {
		"side_info":side_info,
		"score":score,
		"title" :title,
	}
	response = render(request, 'backstage/score/search.html', dict_for_view)
	return response

def upload_file(request):
	semester = request.POST.get("semester")
	f = request.FILES.get("score")
	file_name = f.name
	ext = file_name.split(".")[-1] 
	if ext == "csv" :
		df = pd.read_csv(f)
	elif ext == "xlsx" :
		df = pd.read_excel(f)
	else:
		HttpResponse("請檢查您的格式")

	df.columns = ["student_ID_number","name","attendence","beginning_education","other_activity","together","teaching","material","log","late","other","total","note"]
	for i in range(len(df)):
		# for j in range(len(fields)):
		# 	print(df[fields[j]].iloc[i])
		companion_objs = Companion.objects.filter(student_ID_number=str(df["student_ID_number"].iloc[i]).split(".")[0])
		if len(companion_objs) > 0:
			print(df.iloc[i])
			tmp = Score()
			tmp.semester = semester
			tmp.companion = companion_objs[0]
			# print(str(df["name"].iloc[i]))
			tmp.score_attendence = df["attendence"].iloc[i]
			tmp.score_beginning_education = df["beginning_education"].iloc[i]
			tmp.score_other_activity = df["other_activity"].iloc[i]
			tmp.score_together = df["together"].iloc[i]
			tmp.score_teaching = df["teaching"].iloc[i]
			tmp.score_material = df["material"].iloc[i]
			tmp.score_log = df["log"].iloc[i]
			if str(df["late"].iloc[i]) != "nan":
				tmp.score_late = df["late"].iloc[i]
			if str(df["other"].iloc[i]) != "nan":
				tmp.score_other = df["other"].iloc[i]
			tmp.score_total = df["total"].iloc[i]
			if str(df["note"].iloc[i]) != "nan":
				tmp.note = str(df["note"].iloc[i])
			tmp.save()
	return HttpResponseRedirect("/backstage/score/list")