# Generated by Django 2.2.16 on 2021-05-31 05:44

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    initial = True

    dependencies = [
        ('user', '0004_schedule'),
    ]

    operations = [
        migrations.CreateModel(
            name='Meet',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False, verbose_name='編號')),
                ('stuID', models.PositiveIntegerField(verbose_name='大學伴學號')),
                ('meet_code', models.CharField(max_length=100, verbose_name='會議代碼')),
            ],
            options={
                'verbose_name': '會議室',
                'verbose_name_plural': '會議室',
                'managed': True,
            },
        ),
        migrations.CreateModel(
            name='Pairing_table',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False, verbose_name='編號')),
                ('timeSet_code', models.CharField(max_length=5, verbose_name='時間組別')),
                ('kid_school', models.CharField(max_length=20, verbose_name='小學伴學校')),
                ('kid_name', models.CharField(max_length=30, verbose_name='小學伴姓名')),
                ('subj', models.CharField(max_length=5, verbose_name='科目')),
                ('uniCompanion', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='user.Companion', verbose_name='大學伴')),
            ],
            options={
                'verbose_name': '配對表',
                'verbose_name_plural': '配對表',
                'managed': True,
            },
        ),
        migrations.CreateModel(
            name='Timetable',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False, verbose_name='編號')),
                ('school', models.CharField(max_length=20, verbose_name='小學伴學校')),
                ('day', models.CharField(max_length=1, verbose_name='星期')),
                ('timeSet_code', models.CharField(max_length=5, verbose_name='時間組別')),
            ],
            options={
                'verbose_name': '小學伴校方課程表',
                'verbose_name_plural': '小學伴校方課程表',
                'managed': True,
            },
        ),
        migrations.CreateModel(
            name='Substitute',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False, verbose_name='編號')),
                ('sub_date', models.DateField(verbose_name='代課日期')),
                ('pairing_table', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='classroom.Pairing_table', verbose_name='配對表')),
                ('sub_uniCompanion', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='user.Companion', verbose_name='代課大學伴')),
            ],
            options={
                'verbose_name': '代課紀錄',
                'verbose_name_plural': '代課紀錄',
                'managed': True,
            },
        ),
    ]
