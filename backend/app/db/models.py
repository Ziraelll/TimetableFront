from sqlalchemy import Boolean, Column, Integer, String, Date, Time, Enum, ForeignKey, Table
from sqlalchemy.orm import relationship

from .database import Base
from . import enums


class User(Base):
    __tablename__ = "users"

    user_id = Column(Integer, primary_key=True, index=True)

    last_name = Column(String, nullable=False)
    first_name = Column(String, nullable=False)
    patronymic = Column(String)

    short_name = Column(String, nullable=False)

    username = Column(String, unique=True, index=True)
    email = Column(String, unique=True, index=True)
    hashed_password = Column(String, nullable=False)

    group_id = Column(Integer, ForeignKey("groups.group_id"))
    department = Column(String, ForeignKey("departments.department_name"))
    status = Column(Enum(enums.Status), nullable=False)

    is_active = Column(Boolean, default=True, nullable=False)

    group = relationship("Group", back_populates="students")


class Group(Base):
    __tablename__ = "groups"

    group_id = Column(Integer, primary_key=True, index=True)
    group_name = Column(String, nullable=False)
    division = Column(String, ForeignKey("divisions.division"))
    visible = Column(Boolean, default=True, nullable=False)


class Department(Base):
    __tablename__ = "departments"

    department_name = Column(String, primary_key=True)


class Classroom(Base):
    __tablename__ = "classrooms"

    room_id = Column(Integer, primary_key=True, index=True)
    room_number = Column(String, nullable=False)
    building = Column(String, ForeignKey("divisions.division"), nullable=False)
    visible = Column(Boolean, default=True, nullable=False)

    division = relationship("Division", back_populates="classrooms")


class Division(Base):
    __tablename__ = "divisions"

    division = Column(String, primary_key=True)
    full_name = Column(String, nullable=False)
    address = Column(String, nullable=False)


class Week(Base):
    __tablename__ = "weeks"

    week_id = Column(Integer, primary_key=True, index=True)
    week_type = Column(Enum(enums.WeekType), nullable=False)
    start_date = Column(Date, nullable=False)
    end_date = Column(Date, nullable=False)


class LessonName(Base):
    __tablename__ = "lessons"

    lesson_name = Column(String, primary_key=True)


class LessonTime(Base):
    __tablename__ = "lesson_time"

    lesson_number = Column(Integer, primary_key=True, index=True)
    start_time = Column(Time, nullable=False)
    end_time = Column(Time, nullable=False)


groups_schedule_association_table = Table(
    'groups_schedule_association', Base.metadata,
    Column('lesson_id', ForeignKey('schedule.lesson_id'), primary_key=True),
    Column('group_id', ForeignKey('groups.group_id'), primary_key=True)
)


teachers_schedule_association_table = Table(
    'teachers_schedule_association', Base.metadata,
    Column('lesson_id', ForeignKey('schedule.lesson_id'), primary_key=True),
    Column('teacher_id', ForeignKey('users.user_id'), primary_key=True)
)


class Lesson(Base):
    __tablename__ = "schedule"

    lesson_id = Column(Integer, primary_key=True, index=True)
    week_day = Column(Enum(enums.WeekDay), nullable=False)
    week_type = Column(Enum(enums.WeekType), nullable=False)
    lesson_number = Column(Integer, ForeignKey("lesson_time.lesson_number"), nullable=False)
    lesson_name = Column(String, ForeignKey("lessons.lesson_name"), nullable=False)
    classroom_id = Column(Integer, ForeignKey("classrooms.room_id"), nullable=False)
    date = Column(Date, nullable=False)

    time = relationship("LessonTime")
    groups = relationship("Group", secondary=groups_schedule_association_table)
    classroom = relationship("Classroom")
    teachers = relationship("User", secondary=teachers_schedule_association_table)
