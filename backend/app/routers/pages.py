from fastapi import APIRouter
from fastapi.responses import FileResponse


router = APIRouter(
    tags=["pages"],
    responses={404: {"description": "Not found"}},
    default_response_class=FileResponse,
)


@router.get("/")
@router.get("/login")
@router.get("/index.html")
def get_login_page():
    return 'static/templates/LoginN.html'


@router.get("/groups")
def get_groups_page():
    return 'static/templates/groups.html'

