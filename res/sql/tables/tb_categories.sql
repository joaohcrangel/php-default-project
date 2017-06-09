CREATE TABLE tb_categories(
idcategory INT NOT NULL AUTO_INCREMENT,
idcategoryfather INT DEFAULT NULL,
descategory VARCHAR(128) NOT NULL,
dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT PRIMARY KEY(idcategory),
CONSTRAINT FK_categories_categories_categoryfather FOREIGN KEY(idcategoryfather) REFERENCES tb_categories(idcategory)
);