CREATE PROCEDURE sp_personscategories_save(
pidperson INT,
pidcategory INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_personscategories WHERE idperson = pidperson AND idcategory = pidcategory) THEN
    
		INSERT INTO tb_personscategories(idperson, idcategory) VALUES(pidperson, pidcategory);
        
	END IF;

END