CREATE PROCEDURE sp_documentstypes_save(
piddocumenttype INT,
pdesdocumenttype VARCHAR(64)
)
BEGIN

    IF piddocumenttype = 0 THEN
    
        INSERT INTO tb_documentstypes (desdocumenttype)
        VALUES(pdesdocumenttype);
        
        SET piddocumenttype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_documentstypes        
        SET 
            desdocumenttype = pdesdocumenttype
        WHERE iddocumenttype = piddocumenttype;

    END IF;

    CALL sp_documentstypes_get(piddocumenttype);

END