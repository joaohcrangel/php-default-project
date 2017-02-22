CREATE PROCEDURE sp_pessoascategoriastipos_save(
pidcategoria INT,
pdescategoria VARCHAR(32)
)
BEGIN

    IF pidcategoria = 0 THEN
    
        INSERT INTO tb_pessoascategoriastipos (descategoria)
        VALUES(pdescategoria);
        
        SET pidcategoria = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_pessoascategoriastipos        
        SET 
            descategoria = pdescategoria        
        WHERE idcategoria = pidcategoria;

    END IF;

    CALL sp_pessoascategoriastipos_get(pidcategoria);

END