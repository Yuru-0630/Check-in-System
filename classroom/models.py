from django.db import models
from user.models import Companion, Partner_school, Student

# Create your models here.
class Timetable(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    partner_school = models.ForeignKey(Partner_school, on_delete=models.CASCADE, verbose_name="夥伴學校")
    weekday = models.CharField(max_length=1,verbose_name="星期")
    timeGroup = models.PositiveIntegerField(verbose_name="時間組別")

    class Meta:
        managed = True
        verbose_name = u"夥伴學校課程表"
        verbose_name_plural =u"夥伴學校課程表"

    def __str__(self):
        return "Timetable_"+str(self.id)

class Pairing_table(models.Model):
    id = models.AutoField(primary_key=True, verbose_name="編號")
    timeGroup = models.PositiveIntegerField(verbose_name="時間組別")
    partner_school = models.ForeignKey(Partner_school, on_delete=models.CASCADE, verbose_name="夥伴學校")
    student = models.ForeignKey(Student, on_delete=models.CASCADE, verbose_name="小學伴")
    companion = models.ForeignKey(Companion, on_delete=models.CASCADE, verbose_name="大學伴") # 當對應 fk 資料被刪，就一起刪
    subj = models.CharField(max_length=5, verbose_name="科目")

    class Meta:
        managed = True
        verbose_name = u"配對表"
        verbose_name_plural = u"配對表"

    def __str__(self):
        return "Pairing_table_"+str(self.id)

class Substitute(models.Model):
    id = models.AutoField(primary_key=True, verbose_name="編號")
    pairing_table = models.ForeignKey(Pairing_table, on_delete=models.CASCADE, verbose_name="配對表")
    # pairing_table_id = models.PositiveIntegerField(verbose_name="代課配對")
    sub_date = models.DateField(verbose_name="代課日期")
    sub_companion = models.ForeignKey(Companion, on_delete=models.CASCADE, verbose_name="代課大學伴")

    class Meta:
        managed = True
        verbose_name = u"代課紀錄"
        verbose_name_plural = u"代課紀錄"
    
    def __str__(self):
        return "Substitute_"+str(self.id)

class Meet(models.Model):
    id = models.AutoField(primary_key=True, verbose_name="編號")
    companion = models.ForeignKey(Companion, on_delete=models.CASCADE, verbose_name="大學伴")
    meet_code = models.CharField(max_length=100, default="None", verbose_name="會議代碼")

    class Meta:
        managed = True
        verbose_name = u"會議室"
        verbose_name_plural = u"會議室"

    def __str__(self):
        return "Meet_"+str(self.id)