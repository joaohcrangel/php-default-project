CREATE PROCEDURE sp_personsdata_remove (
pidperson INT
)
BEGIN
	
	DELETE FROM tb_personsdata WHERE idperson = pidperson;
    
END