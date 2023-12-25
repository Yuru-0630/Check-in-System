from django.db import models
from user.models import Companion
# Create your models here.

class Score(models.Model):
    id = models.AutoField(primary_key=True,verbose_name="編號")
    companion = models.ForeignKey(
        Companion,
        # related_name='%(class)s_compID',
        null=False,
        on_delete=models.CASCADE,
        # on_delete = models.SET_NULL,
        verbose_name="大學伴編號"
    )
    semester = models.CharField(max_length=10,verbose_name="學期") #ex. 1081
    score_beginning_education = models.FloatField(verbose_name="期初教育訓練")
    score_attendence = models.FloatField(verbose_name="出席率")
    score_other_activity = models.FloatField(verbose_name="其他活動")
    score_together = models.FloatField(verbose_name="相見歡")
    score_teaching = models.FloatField(verbose_name="教學")
    score_material = models.FloatField(verbose_name="教材")
    score_log = models.FloatField(verbose_name="教學記錄")
    score_late = models.FloatField(default=0,verbose_name="遲到")
    score_other = models.FloatField(default=0,verbose_name="其他")
    score_total = models.FloatField(verbose_name="總和")
    note = models.TextField(default="",blank=True,verbose_name="備註")

    class Meta:
        managed = True
        verbose_name = u"評量分數"
        verbose_name_plural =u"評量分數"

    # def __str__(self):
    #     return companion.get_name