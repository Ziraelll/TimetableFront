FROM python:3.10.5-slim-buster

# set env variables
ENV PYTHONDONTWRITEBYTECODE 1
ENV PYTHONUNBUFFERED 1

# install dependencies
RUN mkdir /app
WORKDIR /app
#RUN apk update
RUN pip install --upgrade pip
ADD requirements.txt /app
RUN pip install -r requirements.txt
RUN pip install --upgrade pip

ADD . /app
EXPOSE 5000
ENTRYPOINT ["python", "-m", "uvicorn", "--host", "0.0.0.0", "--port", "5000", "--reload", "--log-config", "log.conf","app.main:app"]
