from django.urls import path
from . import views
urlpatterns = [
    path("add_activity",views.add_activity),
    path("delete_activity",views.delete_activity),
    path("activity_checkin",views.activity_checkin),
    path("activity_manual_checkin",views.activity_manual_checkin),
]

urlpatterns += [
    path("generalAct_manual_checkin",views.generalAct_manual_checkin),
]

urlpatterns += [
    path("manual_add_today_class",views.manual_add_today_class),
    path("delete_class",views.delete_class),
    path("class_checkin",views.class_checkin),
    path("class_manual_checkin",views.class_manual_checkin),
    path("add_substitute_companion",views.add_substitute_companion),
]

# external user checkin
urlpatterns += [
    path("",views.index),
    path("external_user_checkin", views.external_user_checkin)
]