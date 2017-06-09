CREATE TABLE tb_productscourses(
idproduct INT NOT NULL,
idcourse INT NOT NULL,
dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct),
CONSTRAINT FOREIGN KEY(idcourse) REFERENCES tb_courses(idcourse)
);