# Generated by Django 2.1.7 on 2019-03-16 12:52

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('checkin', '0003_auto_20190316_1243'),
    ]

    operations = [
        migrations.RenameField(
            model_name='activity_attendance',
            old_name='ischecked',
            new_name='isCheckedin',
        ),
        migrations.RenameField(
            model_name='class_attendance',
            old_name='ischecked',
            new_name='isCheckedin',
        ),
    ]
