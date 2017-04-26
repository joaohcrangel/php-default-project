CREATE PROCEDURE sp_contactstypes_save(
pidcontacttype INT,
pdescontacttype VARCHAR(64)
)
BEGIN

    IF pidcontacttype = 0 THEN
    
        INSERT INTO tb_contactstypes (descontacttype)
        VALUES(pdescontacttype);
        
        SET pidcontacttype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contactstypes        
        SET 
            descontacttype = pdescontacttype
        WHERE idcontacttype = pidcontacttype;

    END IF;

    CALL sp_contactstypes_get(pidcontacttype);

END