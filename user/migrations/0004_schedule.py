# Generated by Django 2.1.7 on 2019-03-16 16:22

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('user', '0003_auto_20190316_1243'),
    ]

    operations = [
        migrations.CreateModel(
            name='Schedule',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False, verbose_name='編號')),
                ('Companion_id', models.PositiveIntegerField()),
                ('day', models.PositiveIntegerField()),
            ],
        ),
    ]
