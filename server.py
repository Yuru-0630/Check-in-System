from __future__ import absolute_import, unicode_literals
import os 
os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'etutor.settings')
# os.system("celery flower -A cloudcomputing & ")
os.system("celery -A etutor worker -B & ")
os.system("uwsgi --ini /etc/uwsgi9000.ini & ")
print("Server start!")