from django.urls import path

from . import views
urlpatterns = [
    path("", views.index),
    path("index", views.index),
    path("activity_form",views.activity_form, name="activity_form"),
    path("formResponse",views.add_application),
]
