CREATE PROCEDURE sp_lugares_remove(
pidlugar INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_lugarescoordenadas WHERE idlugar = pidlugar) THEN
    
		DELETE FROM tb_lugarescoordenadas WHERE idlugar = pidlugar;
        
	END IF;
    
    IF EXISTS(SELECT * FROM tb_lugareshorarios WHERE idlugar = pidlugar) THEN
    
		DELETE FROM tb_lugareshorarios WHERE idlugar = pidlugar;
        
	END IF;

	DELETE FROM tb_lugares WHERE idlugar = pidlugar;

END