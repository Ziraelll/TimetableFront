import enum


class Status(enum.Enum):
    teacher = 'Учитель'
    student = 'Студент'
    school_student = 'Школьник'


class WeekType(enum.Enum):
    top = 'Верхняя'
    lower = 'Нижняя'
    always = 'Всегда'


class WeekDay(enum.Enum):
    monday = 'Понедельник'
    tuesday = 'Вторник'
    wednesday = 'Среда'
    thursday = 'Четверг'
    friday = 'Пятница'
    saturday = 'Суббота'
