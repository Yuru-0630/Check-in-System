# Generated by Django 2.2.16 on 2021-06-01 05:08

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('classroom', '0004_auto_20210601_0302'),
    ]

    operations = [
        migrations.RenameField(
            model_name='timetable',
            old_name='day',
            new_name='weekday',
        ),
    ]