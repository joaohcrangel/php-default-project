CREATE PROCEDURE sp_materialstypes_save(
pidtype INT,
pdestype VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF pidtype = 0 THEN
    
        INSERT INTO tb_materialstypes (destype, dtregister)
        VALUES(pdestype, pdtregister);
        
        SET pidtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_materialstypes        
        SET 
            destype = pdestype,
            dtregister = pdtregister        
        WHERE idtype = pidtype;

    END IF;

    CALL sp_materialstypes_get(pidtype);

END;