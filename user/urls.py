from django.urls import path
from . import views
urlpatterns = [
    # path('sign_up',views.sign_up),
    # path('sign_up_check',views.sign_up_check),
    path('login',views.login),
    path('logout',views.logout),
    # path('update_profile',views.update_profile),
    path('add_companion',views.add_companion),
    path('delete_companion',views.delete_companion),
    path('update_companion',views.update_companion),
    path("update_schedule",views.update_schedule),
    path("get_all_serving_companions_of_one_department",views.get_all_serving_companions_of_one_department),
    path("stop_all_service",views.stop_all_service),
    path("cancel_all_schedule",views.cancel_all_schedule),
    path("assign_shift", views.assign_shift),
]
