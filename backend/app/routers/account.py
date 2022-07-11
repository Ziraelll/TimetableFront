from fastapi import APIRouter, Depends, HTTPException
from fastapi.responses import FileResponse

from ..db import schemas, models
from ..routers.security import get_current_user

router = APIRouter(
    tags=["user pages"],
    responses={404: {"description": "Not found"}},
)


async def get_current_active_user(current_user: models.User = Depends(get_current_user)):
    if not current_user.is_active:
        raise HTTPException(status_code=400, detail="Inactive user")
    return current_user


@router.get("/users/me/", response_model=schemas.User)
async def read_users_me(current_user: models.User = Depends(get_current_active_user)):
    return current_user


@router.get("/users/me/items/")
async def read_own_items(current_user: models.User = Depends(get_current_active_user)):
    return [{"item_id": "Foo", "owner": current_user.username}]

