from django.shortcuts import render
from django.http import JsonResponse,HttpResponse,HttpResponseRedirect
import pandas as pd 
from .models import *
from user.models import *
from django.contrib import messages

# Create your views here.

def index(request):
	dict_for_view = {}
	response = render(request, 'backstage/score_revision/index.html', dict_for_view)
	return response

def search(request):
	student_ID_number = request.POST.get("student_ID_number")
	return HttpResponseRedirect("/score_revision/search_result/"+student_ID_number)

def search_result(request,student_ID_number):
	companion_objs = Companion.objects.filter(student_ID_number=student_ID_number)
	score = ""
	if len(companion_objs)==0:
		side_info = "Oops"
		title = "不好意思，如果您是大學伴，請先檢查您的輸入，若還是無法查詢，請找助理協助，謝謝您。"
	else:
		latest_semester = ScoreRevision.objects.all().order_by("-id")[0].semester
		score_objs = ScoreRevision.objects.filter(companion=companion_objs[0], semester=latest_semester)
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
	response = render(request, 'backstage/score_revision/search.html', dict_for_view)
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

	df.columns = ["student_ID_number","name","attendence","beginning_education","meeting_attendence","together","teaching1", "teaching2","material","log","late","bonus1","bonus2","total"]
	while (df["attendence"].isnull().any() or df["beginning_education"].isnull().any() or df["meeting_attendence"].isnull().any() or df["together"].isnull().any() or df["teaching1"].isnull().any() or df["teaching2"].isnull().any() or df["material"].isnull().any() or df["log"].isnull().any() or df["total"].isnull().any()):
		messages.add_message(request, messages.ERROR, '請檢查學伴成績是否都有輸入')
		break
	else :
		for i in range(len(df)):
			companion_objs = Companion.objects.filter(student_ID_number=str(df["student_ID_number"].iloc[i]).split(".")[0])
			if len(companion_objs) > 0:
				print(df.iloc[i])
				tmp = ScoreRevision()
				if semester == "":
					messages.add_message(request, messages.ERROR, '請輸入學期編號')
					break
				else :
					tmp.semester = semester
				tmp.companion = companion_objs[0]
				tmp.score_attendence = df["attendence"].iloc[i]
				tmp.score_beginning_education = df["beginning_education"].iloc[i]
				tmp.score_meeting_attendence = df["meeting_attendence"].iloc[i]
				tmp.score_together = df["together"].iloc[i]
				tmp.score_teaching1 = df["teaching1"].iloc[i]
				tmp.score_teaching2 = df["teaching2"].iloc[i]
				tmp.score_material = df["material"].iloc[i]
				tmp.score_log = df["log"].iloc[i]
				if str(df["late"].iloc[i]) != "nan":
					tmp.score_late = df["late"].iloc[i]
				if str(df["bonus1"].iloc[i]) != "nan":
					tmp.score_bonus1 = df["bonus1"].iloc[i]
				if str(df["bonus2"].iloc[i]) != "nan":
					tmp.score_bonus2 = df["bonus2"].iloc[i]    
				tmp.score_total = df["total"].iloc[i]
				tmp.save()
	return HttpResponseRedirect("/backstage/score_revision/list")
