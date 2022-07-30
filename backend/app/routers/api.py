from fastapi import APIRouter

router = APIRouter(
    tags=["API"],
    responses={404: {"description": "Not found"}},
)
