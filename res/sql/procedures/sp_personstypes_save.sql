CREATE PROCEDURE sp_personstypes_save(
pidpersontype INT,
pdespersontype VARCHAR(64)
)
BEGIN

    IF pidpersontype = 0 THEN
    
        INSERT INTO tb_personstypes (despersontype)
        VALUES(pdespersontype);
        
        SET pidpersontype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personstypes        
        SET 
            despersontype = pdespersontype                   
        WHERE idpersontype = pidpersontype;

    END IF;

    CALL sp_personstypes_get(pidpersontype);

END