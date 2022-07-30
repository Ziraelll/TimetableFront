from fastapi import FastAPI
from fastapi.staticfiles import StaticFiles
from .routers import api, pages, account, security

from .db import models
from .db.database import engine

models.Base.metadata.create_all(bind=engine)


app = FastAPI(title="Schedule")

app.mount("/static", StaticFiles(directory="static"), name="static")
app.include_router(api.router, prefix='/api/v1')
app.include_router(pages.router)
app.include_router(security.router)
app.include_router(account.router)
