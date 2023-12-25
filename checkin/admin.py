from django.contrib import admin
from django.conf import settings
from .models import *
# Register your models here.

class ClassAdmin(admin.ModelAdmin):
	flag = "Class"
	# list_display = ('name','ID','title','activity_ID')
	# list_editable = ['title','activity_ID']
	# list_per_page = 50

admin.site.register(Class,ClassAdmin)


class Class_attendanceAdmin(admin.ModelAdmin):
	flag = "Class_attendance"

admin.site.register(Class_attendance,Class_attendanceAdmin)


class ActivityAdmin(admin.ModelAdmin):
	flag = "Activity"

admin.site.register(Activity,ActivityAdmin)


class Activity_attendanceAdmin(admin.ModelAdmin):
	flag = "Activity_attendance"

admin.site.register(Activity_attendance,Activity_attendanceAdmin)