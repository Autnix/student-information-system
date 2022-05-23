create table faculty
(
    id            int auto_increment
        primary key,
    faculty_name  varchar(255) null,
    head_lecturer int          null
);

create table department
(
    id              int auto_increment
        primary key,
    department_name varchar(255) null,
    faculty         int          not null,
    head_lecturer   int          null,
    constraint department_faculty_id_fk
        foreign key (faculty) references faculty (id)
            on update cascade on delete cascade
);

create table lecturer
(
    id                int auto_increment
        primary key,
    lecturer_fullname varchar(255)                          null,
    email             varchar(255)                          not null,
    faculty_id        int                                   null,
    department_id     int                                   null,
    lecturer_password text                                  null,
    created_at        timestamp default current_timestamp() null,
    constraint lecturer_department_id_fk
        foreign key (department_id) references department (id)
            on update cascade on delete cascade,
    constraint lecturer_faculty_id_fk
        foreign key (faculty_id) references faculty (id)
            on update cascade on delete cascade
);

alter table department
    add constraint department_lecturer_id_fk
        foreign key (head_lecturer) references lecturer (id)
            on update cascade on delete cascade;

alter table faculty
    add constraint faculty_lecturer_id_fk
        foreign key (head_lecturer) references lecturer (id)
            on update cascade on delete cascade;

create table lessons
(
    id                   int auto_increment
        primary key,
    lesson_code          varchar(20)    not null,
    lesson_name          varchar(255)   not null,
    akts                 int default 0  null,
    total_attendance     int default 14 null,
    mandatory_attendance int default 7  null,
    lecturer             int            not null,
    constraint lessons_lecturer_id_fk
        foreign key (lecturer) references lecturer (id)
            on update cascade on delete cascade
);

create table exams
(
    id        int auto_increment
        primary key,
    exam_name varchar(255)  not null,
    ratio     int default 0 null,
    lesson_id int           null,
    constraint exams_lessons_id_fk
        foreign key (lesson_id) references lessons (id)
            on update cascade on delete cascade
);

create table semesters
(
    id            int auto_increment
        primary key,
    semester_name varchar(255)                          not null,
    created_at    timestamp default current_timestamp() null
);

create table students
(
    number           int           not null
        primary key,
    student_fullname varchar(255)  null,
    student_ssn      varchar(255)  null,
    advisor          int           null,
    semester         int default 1 null,
    student_password text          null,
    faculty_id       int           null,
    department_id    int           null,
    constraint students_department_id_fk
        foreign key (department_id) references department (id)
            on update cascade on delete cascade,
    constraint students_faculty_id_fk
        foreign key (faculty_id) references faculty (id)
            on update cascade on delete cascade,
    constraint students_lecturer_id_fk
        foreign key (advisor) references lecturer (id)
            on update cascade on delete cascade
);

create table attendances
(
    student_number int           not null,
    lesson_id      int           not null,
    absence        int default 0 null,
    primary key (student_number, lesson_id),
    constraint attendances_lessons_id_fk
        foreign key (lesson_id) references lessons (id)
            on update cascade on delete cascade,
    constraint attendances_students_number_fk
        foreign key (student_number) references students (number)
            on update cascade on delete cascade
);

create table exam_notes
(
    student_number int            not null,
    exam_id        int            not null,
    note           int default -1 null,
    primary key (student_number, exam_id),
    constraint exam_notes_exams_id_fk
        foreign key (exam_id) references exams (id)
            on update cascade on delete cascade,
    constraint exam_notes_students_number_fk
        foreign key (student_number) references students (number)
            on update cascade on delete cascade
);

create table student_lessons
(
    student_number int not null,
    lesson_id      int not null,
    semester_id    int not null,
    primary key (student_number, lesson_id, semester_id),
    constraint student_lessons_lessons_id_fk
        foreign key (lesson_id) references lessons (id)
            on update cascade on delete cascade,
    constraint student_lessons_semesters_id_fk
        foreign key (semester_id) references semesters (id)
            on update cascade on delete cascade,
    constraint student_lessons_students_number_fk
        foreign key (student_number) references students (number)
            on update cascade on delete cascade
);