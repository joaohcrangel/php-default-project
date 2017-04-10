CREATE PROCEDURE sp_coursessections_remove(
idsection INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_coursessections WHERE idsection = pidsection) THEN
    
		DELETE FROM tb_coursescurriculums WHERE idsection = pidsection;
        
	END IF;

    DELETE FROM tb_coursessections 
    WHERE idsection = pidsection;

END