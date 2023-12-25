from django.db import models
from user.models import Companion
# Create your models here.

class ScoreRevision(models.Model):
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
    score_beginning_education = models.FloatField(verbose_name="教育訓練")
    score_attendence = models.FloatField(verbose_name="出席率")
    score_meeting_attendence = models.FloatField(verbose_name="例會出席")
    score_together = models.FloatField(verbose_name="相見歡")
    score_teaching1 = models.FloatField(verbose_name="教學表現1")
    score_teaching2 = models.FloatField(verbose_name="教學表現2")
    score_material = models.FloatField(verbose_name="自製教材")
    score_log = models.FloatField(verbose_name="教學記錄")
    score_late = models.FloatField(default=0,verbose_name="遲到")
    score_bonus1 = models.FloatField(default=0,verbose_name="加值分1")
    score_bonus2 = models.FloatField(default=0,verbose_name="加值分2")
    score_total = models.FloatField(verbose_name="總和")

    class Meta:
        managed = True
        verbose_name = u"評量分數"
        verbose_name_plural =u"評量分數"

    # def __str__(self):
    #     return companion.get_name