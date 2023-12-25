from django.db import models
from django.contrib.auth.models import AbstractUser

# Create your models here.

class User(AbstractUser):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    name = models.CharField(max_length=100,verbose_name="姓名")
    identity = models.PositiveIntegerField(default=0,verbose_name="身份") #1:admin,2:teacher,3:companion,4:student
    phone_number = models.CharField(default="",blank=True,max_length=20,verbose_name="電話號碼")
    photo = models.ImageField(upload_to="etutor/user",blank=True,default="etutor/user/none")
    # line_bot_token = models.CharField(default="",blank=True,max_length=100,verbose_name="LineBot權杖號碼")
    # is_checked = models.BooleanField(default=False,verbose_name="是否確認")

    class Meta:
        managed = True
        verbose_name = u"使用者"
        verbose_name_plural =u"使用者"

    def __str__(self):
        return self.name
    
class Department(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    name = models.CharField(max_length=100,verbose_name="名稱")

    class Meta:
        managed = True
        verbose_name = u"系所"
        verbose_name_plural =u"系所"

    def __str__(self):
        return self.name

class Partner_school(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    name = models.CharField(max_length=100,verbose_name="名稱")

    class Meta:
        managed = True
        verbose_name = u"夥伴學校"
        verbose_name_plural =u"夥伴學校"

    def __str__(self):
        return self.name

class Companion(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    User_id = models.PositiveIntegerField()
    # name = models.CharField(max_length=100,verbose_name="姓名")
    department_id = models.PositiveIntegerField(verbose_name="系所")
    grade = models.PositiveIntegerField(verbose_name="年級")
    student_ID_number = models.CharField(max_length=100,verbose_name="學號")
    student_ID_card_number = models.CharField(max_length=100,verbose_name="學生證號碼")
    isServing = models.BooleanField(default=True,verbose_name="是否服務中")
    note = models.TextField(default="",blank=True,verbose_name="備註")

    class Meta:
        managed = True
        verbose_name = u"大學伴"
        verbose_name_plural =u"大學伴"

    def get_name(self):
        return User.objects.get(id=self.User_id).name

    def __str__(self):
        return "Companion_"+str(self.id)

class Student(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    # User_id = models.PositiveIntegerField()
    name = models.CharField(max_length=100,verbose_name="姓名")
    partner_school_id = models.PositiveIntegerField(verbose_name="學校")
    # grade = models.PositiveIntegerField(verbose_name="年級")
    # sex = models.PositiveIntegerField(verbose_name="性別")
    # note = models.TextField(default="",blank=True,verbose_name="備註")
    isJoin = models.BooleanField(default=True,verbose_name="是否參加計畫")

    class Meta:
        managed = True
        verbose_name = u"小學伴"
        verbose_name_plural =u"小學伴"

    # def get_name(self):
    #     return User.objects.get(id=User_id).name

    def __str__(self):
        return "Student_"+str(self.id)

class Teacher(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    User_id = models.PositiveIntegerField()
    # name = models.CharField(max_length=100,verbose_name="姓名")
    partner_school_id = models.PositiveIntegerField(verbose_name="學校")
    isServing = models.BooleanField(default=True,verbose_name="是否服務中")
    note = models.TextField(default="",blank=True,verbose_name="備註")

    class Meta:
        managed = True
        verbose_name = u"帶班老師"
        verbose_name_plural =u"帶班老師"

    def get_name(self):
        return User.objects.get(id=User_id).name

    def __str__(self):
        return "Teacher_"+str(self.id)

class Schedule(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    Companion_id = models.PositiveIntegerField()
    # Student_id = models.PositiveIntegerField()
    day = models.PositiveIntegerField()
    # starting_time = models.TimeField(verbose_name="開始時間")
    # ending_time = models.TimeField(verbose_name="結束時間")
    