from django.urls import path
from . import views
urlpatterns = [
    path("",views.index),
    path("index",views.index),
    path("search",views.search),
    path("search_result/<str:student_ID_number>",views.search_result),
    path("upload_file",views.upload_file),
]