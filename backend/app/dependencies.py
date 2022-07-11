from sqlalchemy.orm import Session
from passlib.context import CryptContext
from fastapi.security import OAuth2PasswordBearer

from .db import models
from .db.database import SessionLocal, engine

SECRET_KEY = '31028ef563ac67c4cd871440fd7bc38a7b142063e70893c487043db2302cc0b8'
ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_MINUTES = 30

pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")
oauth2_scheme = OAuth2PasswordBearer(tokenUrl="token")

models.Base.metadata.create_all(bind=engine)


def get_password_hash(password):
    return pwd_context.hash(password)


def get_db() -> Session:
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()


