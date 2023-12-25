from django.db import models

# Create your models here.

class Class(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    day = models.PositiveIntegerField()
    date = models.DateField(verbose_name="日期")
    # starting_time = models.TimeField(verbose_name="開始時間")
    # ending_time = models.TimeField(verbose_name="結束時間")
    note = models.TextField(default="",blank=True,verbose_name="備註")

    class Meta:
        managed = True
        verbose_name = u"課程"
        verbose_name_plural =u"課程"

    def __str__(self):
        return "Class_"+str(self.id)

class Class_attendance(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    Class_id = models.PositiveIntegerField()
    Companion_id = models.PositiveIntegerField()
    checkin_time = models.DateTimeField(auto_now_add=True,verbose_name="簽到時間")
    isCheckedin = models.BooleanField(default=False)

    class Meta:
        managed = True
        verbose_name = u"課程出席紀錄"
        verbose_name_plural =u"課程出席紀錄"

    def __str__(self):
        return "Class_attendance_"+str(self.id)

class Activity(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    name = models.CharField(max_length=100,verbose_name="活動名稱")
    starting_time = models.DateTimeField(verbose_name="開始時間")
    ending_time = models.DateTimeField(verbose_name="結束時間")
    location = models.CharField(max_length=100,verbose_name="地點")
    description = models.TextField(default="",blank=True,verbose_name="活動簡介")
    note = models.TextField(default="",blank=True,verbose_name="備註")
    isGeneral = models.BooleanField(default=False,verbose_name="活動類型")

    class Meta:
        managed = True
        verbose_name = u"大學伴活動"
        verbose_name_plural =u"大學伴活動"

    def __str__(self):
        return "Activity_"+str(self.id)

# Activity for etutor companion
class Activity_attendance(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    Activity_id = models.PositiveIntegerField()
    User_id = models.PositiveIntegerField()
    checkin_time = models.DateTimeField(auto_now_add=True,verbose_name="簽到時間")
    isCheckedin = models.BooleanField(default=False)

    class Meta:
        managed = True
        verbose_name = u"大學伴活動出席紀錄"
        verbose_name_plural =u"大學伴活動出席紀錄"

    def __str__(self):
        return "Activity_attendance_"+str(self.id)

class General_activity_attendance(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    department_id = models.PositiveIntegerField(verbose_name="系所")
    grade = models.PositiveIntegerField(verbose_name="年級")
    student_ID_number = models.CharField(max_length=100,verbose_name="學號")
    name = models.CharField(max_length=100,verbose_name="姓名")
    Activity_id = models.PositiveIntegerField(verbose_name="活動編號")
    apply_time = models.DateTimeField(auto_now_add=True,verbose_name="報名時間")
    isCheckedin = models.BooleanField(default=False)
    checkin_time = models.DateTimeField(null=True,verbose_name="簽到時間")

    class Meta:
        managed = True
        verbose_name = u"一般活動出席紀錄"
        verbose_name_plural = u"一般活動出席紀錄"

    def __str__(self):
        return "General_activity_attandance"+str(self.id)