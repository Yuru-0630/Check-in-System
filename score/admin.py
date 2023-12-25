from django.contrib import admin
from django.conf import settings
from .models import *
# Register your models here.

class ScoreAdmin(admin.ModelAdmin):
	flag = "Score"
	# list_display = ('name','ID','title','activity_ID')
	# list_editable = ['title','activity_ID']
	# list_per_page = 50

admin.site.register(Score,ScoreAdmin)