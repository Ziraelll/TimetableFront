from fastapi import FastAPI, Depends
from fastapi.staticfiles import StaticFiles
from .routers import pages

from .db import models, crud
from .db.database import engine
from .dependencies import get_db

models.Base.metadata.create_all(bind=engine)


app = FastAPI(title="Schedule")

app.mount("/static", StaticFiles(directory="static"), name="static")
app.include_router(pages.router)
