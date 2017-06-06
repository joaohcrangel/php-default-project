CREATE TABLE tb_instructors(
idinstructor INT NOT NULL AUTO_INCREMENT,
idperson INT NOT NULL,
desbiography TEXT NOT NULL,
idphoto INT NOT NULL,
dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT PRIMARY KEY(idinstructor),
CONSTRAINT FK_instructors_persons FOREIGN KEY (idperson) REFERENCES tb_persons(idperson),
CONSTRAINT FK_instructors_files FOREIGN KEY(idphoto) REFERENCES tb_files(idfile)
);