from django.db import models

# Create your models here.

class Category(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    title = models.CharField(default="New_category",max_length=300)

    class Meta:
        managed = True
        verbose_name = u"分類"
        verbose_name_plural =u"分類"

    def __str__(self):
        return self.title

class App(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    Category_id = models.PositiveIntegerField(default=0)
    name = models.CharField(default="New_app",max_length=300)
    display_name = models.CharField(default="New_app",max_length=300)
    icon = models.CharField(default="subject",max_length=100)
    isDropdown = models.BooleanField(default=True)
    isPublic = models.BooleanField(default=False)

    class Meta:
        managed = True
        verbose_name = u"應用程式"
        verbose_name_plural =u"應用程式"

    def __str__(self):
        return self.name

    verbose_name = "應用程式"
    display_field_name = ["name","Icon","isDropdown"]

class App_dropdown_item(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    App_id = models.PositiveIntegerField()
    title = models.CharField(default="New_item",max_length=300)
    icon = models.CharField(default="subject",max_length=100)
    link = models.CharField(default="#",max_length=300,verbose_name="URL")
    
    class Meta:
        managed = True
        verbose_name = u"應用程式子項目"
        verbose_name_plural =u"應用程式子項目"

    def __str__(self):
        return self.title

    verbose_name = "應用程式子項目"
    display_field_name = ["應用程式編號","標題","Icon","超連結"]

class Permission(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    App_id = models.PositiveIntegerField()
    User_id = models.PositiveIntegerField()

    class Meta:
        managed = True
        verbose_name = u"應用程式權限"
        verbose_name_plural =u"應用程式權限"

    def __str__(self):
        return "Permission_"+str(self.id)

    verbose_name = "應用程式權限"
    display_field_name = ["編號","應用程式編號","使用者編號"]