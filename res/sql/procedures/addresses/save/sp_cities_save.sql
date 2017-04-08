CREATE PROCEDURE sp_cities_save(
pidcity INT,
pdescity VARCHAR(128),
pidstate INT
)
BEGIN

    IF pidcity = 0 THEN
    
        INSERT INTO tb_cities (descity, idstate)
        VALUES(pdescity, pidstate);
        
        SET pidcity = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_cities        
        SET 
            descity = pdescity,
            idstate = pidstate
        WHERE idcity = pidcity;

    END IF;

    CALL sp_cities_get(pidcity);

END