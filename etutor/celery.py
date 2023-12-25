from __future__ import absolute_import, unicode_literals
import os
from celery import Celery
os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'etutor.settings')
app = Celery('etutor',backend="amqp", broker='amqp://guest@localhost:5672//')

app.config_from_object('django.conf:settings')
app.conf.timezone = 'Asia/Taipei'

app.autodiscover_tasks()