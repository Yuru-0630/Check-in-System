from django.contrib import admin
from django.conf import settings
from .models import *
# Register your models here.

class UserAdmin(admin.ModelAdmin):
	flag = "User"
	list_display = ('id','name')
	# list_editable = ['title','activity_ID']
	# list_per_page = 50

admin.site.register(User,UserAdmin)

class DepartmentAdmin(admin.ModelAdmin):
	flag = "Department"

admin.site.register(Department,DepartmentAdmin)


class Partner_schoolAdmin(admin.ModelAdmin):
	flag = "Partner_school"
	list_display = ['id', 'name']

admin.site.register(Partner_school,Partner_schoolAdmin)


class CompanionAdmin(admin.ModelAdmin):
	flag = "Companion"

admin.site.register(Companion,CompanionAdmin)


class StudentAdmin(admin.ModelAdmin):
	flag = "Student"
	list_display = ['id', 'name', 'isJoin']

admin.site.register(Student,StudentAdmin)


class TeacherAdmin(admin.ModelAdmin):
	flag = "Teacher"

admin.site.register(Teacher,TeacherAdmin)