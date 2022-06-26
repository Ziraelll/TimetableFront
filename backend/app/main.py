import os
from fastapi import FastAPI
from fastapi.responses import FileResponse
from fastapi.staticfiles import StaticFiles

app = FastAPI(title="Schedule")

app.mount("/static", StaticFiles(directory="static"), name="static")


@app.get("/", response_class=FileResponse)
def read_root():
    return FileResponse('static/templates/LoginN.html')


@app.get("/suka")
def read_root():
    return os.listdir('.')
