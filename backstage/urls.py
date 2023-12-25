from django.urls import path

from . import views as backstage_views
urlpatterns = [
    path("",backstage_views.index),
    path("index",backstage_views.index),
    path("login",backstage_views.login_page),
    path("signup",backstage_views.signup_page),
    # path("profile",backstage_views.profile),
    # path("user",backstage_views.companion_page),
    path("user/companion/<str:isServing>",backstage_views.companion_page),
    path("user/schedule",backstage_views.schedule_page),
    path("user/assign",backstage_views.assign_page),
    
    path("activity",backstage_views.activity_list_page),
    path("activity/list",backstage_views.activity_list_page),
    path("activity/attendance",backstage_views.activity_attendance_page),
    path("activity/checkin",backstage_views.activity_checkin_page),
    
    path("generalAct/list",backstage_views.generalAct_list_page),
    path("generalAct/attendance",backstage_views.generalAct_attendance_page),    
    
    path("class",backstage_views.class_list_page),
    path("class/list",backstage_views.class_list_page),
    path("class/attendance",backstage_views.class_attendance_page),
    path("class/checkin",backstage_views.class_checkin_page),
    
    path("salary", backstage_views.salary_list_page),
    path("salary/list", backstage_views.salary_list_page),
    path("salary/show", backstage_views.show_salary),
    
    # path("score/list",backstage_views.redirect_to_score_list_page),
    # path("score/list/<str:semester>",backstage_views.score_list_page),

    path("score_revision/list",backstage_views.redirect_to_score_revision_list_page),
    path("score_revision/list/<str:semester>",backstage_views.score_revision_list_page),
    
    path("classroom/meet/<str:isServing>",backstage_views.meet_page),

    # path("leave", backstage_views.leave_list_page),
    # path("leave/list", backstage_views.leave_list_page),
]
