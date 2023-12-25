from django.urls import path
from . import views
urlpatterns = [
    path("", views.index),
    path("leave_apply", views.leave_apply),
    path("review_apply", views.review_apply),
    # path("list", views.leave_list),
]