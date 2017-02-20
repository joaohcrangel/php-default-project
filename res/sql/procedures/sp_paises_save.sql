CREATE PROCEDURE sp_paises_save(
pidpais INT,
pdespais VARCHAR(64)
)
BEGIN

    IF pidpais = 0 THEN
    
        INSERT INTO tb_paises (despais)
        VALUES(pdespais);
        
        SET pidpais = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_paises        
        SET 
            despais = pdespais        
        WHERE idpais = pidpais;

    END IF;

    CALL sp_paises_get(pidpais);

END