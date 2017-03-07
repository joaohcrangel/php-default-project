CREATE PROCEDURE sp_adresses_remove(
pidadress INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_personsadresses WHERE idadress = pidadress) THEN
    
		DELETE FROM tb_personsadresses WHERE idadress = pidadress;
        
	END IF;

    DELETE FROM tb_adresses WHERE idadress = pidadress;

END