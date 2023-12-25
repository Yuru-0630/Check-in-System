from django.contrib import admin
from .models import *

# Register your models here.
class Leave_applicationAdmin(admin.ModelAdmin):
	flag = "Leave_application"

admin.site.register(Leave_application,Leave_applicationAdmin)