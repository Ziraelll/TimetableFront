import datetime

from pydantic import BaseModel

import enums


class UserBase(BaseModel):
    last_name: str
    first_name: str
    patronymic: str
    email: str
    username: str


class UserCreate(UserBase):
    password: str


class User(UserBase):
    user_id: int
    is_active: bool
    short_name: str
    group_id: int
    department: str
    status: enums.Status

    class Config:
        orm_mode = True


class Token(BaseModel):
    access_token: str
    token_type: str


class TokenData(BaseModel):
    username: str | None = None


class GroupBase(BaseModel):
    group_name: str
    division: str


class GroupCreate(GroupBase):
    pass


class Group(GroupBase):
    group_id: int
    visible: bool

    class Config:
        orm_mode = True


class Department(BaseModel):
    department_name: str

    class Config:
        orm_mode = True


class ClassroomBase(BaseModel):
    room_number: str
    building: str


class ClassroomCreate(ClassroomBase):
    pass


class Classroom(ClassroomBase):
    room_id: int
    visible: bool

    class Config:
        orm_mode = True


class Division(BaseModel):
    division: str
    full_name: str
    address: str

    class Config:
        orm_mode = True


class WeekBase(BaseModel):
    week_type: enums.WeekType
    start_date: datetime.time
    end_date: datetime.time


class WeekCreate(WeekBase):
    pass


class Week(WeekBase):
    week_id: int

    class Config:
        orm_mode = True


class LessonName(BaseModel):
    lesson_name: str

    class Config:
        orm_mode = True


class LessonTime(BaseModel):
    lesson_number: int
    start_time: datetime.time
    end_time: datetime.time

    class Config:
        orm_mode = True


class LessonBase(BaseModel):
    week_day: enums.WeekDay
    week_type: enums.WeekType
    lesson_number: int
    lesson_name: str
    classroom_id: int
    date: datetime.date


class LessonCreate(LessonBase):
    pass


class Lesson:
    lesson_id: int

    class Config:
        orm_mode = True
