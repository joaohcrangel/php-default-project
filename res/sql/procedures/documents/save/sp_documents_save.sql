CREATE PROCEDURE sp_documents_save(
piddocument INT,
piddocumenttype INT,
pidperson INT,
pdesdocument VARCHAR(64)
)
BEGIN

    IF piddocument = 0 THEN
    
        INSERT INTO tb_documents (iddocumenttype, idperson, desdocument)
        VALUES(piddocumenttype, pidperson, pdesdocument);
        
        SET piddocument = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_documents        
        SET 
            iddocumenttype = piddocumenttype,
            idperson = pidperson,
            desdocument = pdesdocument
        WHERE iddocument = piddocument;

    END IF;

    CALL sp_documents_get(piddocument);

END