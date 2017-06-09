CREATE TABLE tb_filespaths(
idfile INT NOT NULL,
despath VARCHAR(128) DEFAULT NULL,
dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT FK_filespaths_file FOREIGN KEY(idfile) REFERENCES tb_files(idfile)
);