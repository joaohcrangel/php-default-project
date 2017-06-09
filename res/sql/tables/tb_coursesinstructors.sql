CREATE TABLE tb_coursesinstructors(
idcourse INT NOT NULL,
idinstructor INT NOT NULL,
dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT fk_coursesinstructors_courses FOREIGN KEY(idcourse) REFERENCES tb_courses(idcourse),
CONSTRAINT fk_coursesinstructors_instructors FOREIGN KEY(idinstructor) REFERENCES tb_instructors(idinstructor)
);