CREATE PROCEDURE sp_cidades_save(
pidcidade INT,
pdescidade VARCHAR(128),
pidestado INT
)
BEGIN

    IF pidcidade = 0 THEN
    
        INSERT INTO tb_cidades (descidade, idestado)
        VALUES(pdescidade, pidestado);
        
        SET pidcidade = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_cidades        
        SET 
            descidade = pdescidade,
            idestado = pidestado        
        WHERE idcidade = pidcidade;

    END IF;

    CALL sp_cidades_get(pidcidade);

END