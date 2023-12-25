from django.urls import path
from . import views
urlpatterns = [
    path('', views.school_entrance),
    path('<str:school_id>', views.classroom_entrance),
    path('update_meet', views.update_meet),
    # path('tmp', views.tmp_add_data),
]