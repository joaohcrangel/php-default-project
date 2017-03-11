CREATE PROCEDURE sp_personsadresses_save(
pidperson INT,
pidadress INT
)
BEGIN
	
    DELETE FROM tb_personsadresses WHERE idperson = pidperson AND idadress = pidadress;
    INSERT INTO tb_personsadresses (idperson, idadress) VALUES(pidperson, pidadress);
    
END