CREATE PROCEDURE sp_personsaddresses_save(
pidperson INT,
pidaddress INT
)
BEGIN
	
    DELETE FROM tb_personsaddresses WHERE idperson = pidperson AND idaddress = pidaddress;
    INSERT INTO tb_personsaddresses (idperson, idaddress) VALUES(pidperson, pidaddress);
    
END