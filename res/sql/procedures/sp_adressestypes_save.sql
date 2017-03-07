CREATE PROCEDURE sp_adressestypes_save(
pidadresstype INT,
pdesadresstype VARCHAR(64)
)
BEGIN

    IF pidadresstype = 0 THEN
    
        INSERT INTO tb_adressestypes (desadresstype)
        VALUES(pdesadresstype);
        
        SET pidadresstype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_adressestypes        
        SET 
            desadresstype = pdesadresstype
        WHERE idadresstype = pidadresstype;

    END IF;

    CALL sp_adressestypes_get(pidadresstype);

END