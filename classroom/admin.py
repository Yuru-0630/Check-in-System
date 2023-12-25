from django.contrib import admin
from .models import *

# Register your models here.
class TimetableAdmin(admin.ModelAdmin):
    flag = "Timetable"
    list_display = [field.name for field in Timetable._meta.get_fields()]
admin.site.register(Timetable,TimetableAdmin)

class Pairing_tableAdmin(admin.ModelAdmin):
    flag = "Pairing_table"
    list_display = ['id', 'timeGroup', 'partner_school', 'student', 'companion', 'subj']
admin.site.register(Pairing_table,Pairing_tableAdmin)

class SubstituteAdmin(admin.ModelAdmin):
    flag = "Substitute"
    list_display = [field.name for field in Substitute._meta.get_fields()]
admin.site.register(Substitute,SubstituteAdmin)

class MeetAdmin(admin.ModelAdmin):
    flag = "Meet"
    list_display = [field.name for field in Meet._meta.get_fields()]
admin.site.register(Meet,MeetAdmin)