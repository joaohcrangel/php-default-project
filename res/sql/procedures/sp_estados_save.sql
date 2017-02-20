CREATE PROCEDURE sp_estados_save(
pidestado INT,
pdesestado VARCHAR(64),
pdesuf CHAR(2),
pidpais INT
)
BEGIN

    IF pidestado = 0 THEN
    
        INSERT INTO tb_estados (desestado, desuf, idpais)
        VALUES(pdesestado, pdesuf, pidpais);
        
        SET pidestado = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_estados        
        SET 
            desestado = pdesestado,
            desuf = pdesuf,
            idpais = pidpais        
        WHERE idestado = pidestado;

    END IF;

    CALL sp_estados_get(pidestado);

END