from django.contrib import admin
from .models import *
# Register your models here.


class CategoryAdmin(admin.ModelAdmin):
	flag = "Category"

admin.site.register(Category,CategoryAdmin)


class AppAdmin(admin.ModelAdmin):
	flag = "App"

admin.site.register(App,AppAdmin)

class App_dropdown_itemAdmin(admin.ModelAdmin):
	flag = "App_dropdown_item"

admin.site.register(App_dropdown_item,App_dropdown_itemAdmin)

class PermissionAdmin(admin.ModelAdmin):
	flag = "Permission"

admin.site.register(Permission,PermissionAdmin)
