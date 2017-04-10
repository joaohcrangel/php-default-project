CREATE PROCEDURE sp_settingstypes_save(
pidsettingtype INT,
pdessettingtype VARCHAR(32)
)
BEGIN

    IF pidsettingtype = 0 THEN
    
        INSERT INTO tb_settingstypes (pdessettingtype)
        VALUES(pdessettingtype);
        
        SET pidsettingtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_settingstypes     
        SET 
            dessettingtype = pdessettingtype        
        WHERE idsettingtype = pidsettingtype;

    END IF;

    CALL sp_settingstypes_get(pidsettingtype);

END