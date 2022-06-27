from fastapi import FastAPI
from fastapi.staticfiles import StaticFiles
from .routers import pages

app = FastAPI(title="Schedule")

app.mount("/static", StaticFiles(directory="static"), name="static")
app.include_router(pages.router)
