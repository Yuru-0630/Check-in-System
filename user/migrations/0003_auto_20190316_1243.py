# Generated by Django 2.1.7 on 2019-03-16 12:43

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('user', '0002_auto_20190216_2359'),
    ]

    operations = [
        migrations.AlterField(
            model_name='user',
            name='photo',
            field=models.ImageField(blank=True, default='etutor/user/none', upload_to='etutor/user'),
        ),
    ]