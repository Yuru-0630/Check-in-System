from django.db import models

# Create your models here.
class Leave_application(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    applicant_name = models.CharField(max_length=30,verbose_name="申請人姓名")
    applicant_kidSchool = models.CharField(max_length=20,verbose_name="申請人負責學校")
    leave_type = models.CharField(max_length=50,verbose_name="申請假別")
    leave_reason = models.CharField(max_length=100,verbose_name="請假原因")
    leave_date = models.DateField(verbose_name="請假日期")
    sub_name = models.CharField(max_length=30,verbose_name="代課姓名")
    sub_kidSchool = models.CharField(max_length=20,verbose_name="代課負責學校")
    apply_dateTime = models.DateTimeField(auto_now_add=True,verbose_name="申請提交時間")

    class Meta:
        managed = True
        verbose_name = u"請假申請表"
        verbose_name_plural =u"請假申請表"

    def __str__(self):
        return "Leave_application_"+str(self.id)