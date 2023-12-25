from django.contrib import admin
from django.urls import path,include
from django.conf import settings
from django.conf.urls.static import static

urlpatterns = [
    path('admin/', admin.site.urls),
    path('user/', include('user.urls')),
    path('', include('forestage.urls')),
    path('backstage/', include('backstage.urls')),
    path('checkin/', include('checkin.urls')),
    path('score/', include('score.urls')),
    path('score_revision/', include('score_revision.urls')),
    path('leave/', include('leave.urls')),
    path('classroom/', include('classroom.urls')),
]

if settings.DEBUG == True:
    urlpatterns += static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)+static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
