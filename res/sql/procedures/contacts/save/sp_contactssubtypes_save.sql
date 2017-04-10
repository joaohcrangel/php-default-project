CREATE PROCEDURE sp_contactssubtypes_save(
pidcontactsubtype INT,
pdescontactsubtype VARCHAR(32),
pidcontacttype INT,
piduser INT
)
BEGIN

    IF pidcontactsubtype = 0 THEN
    
        INSERT INTO tb_contactssubtypes (descontactsubtype, idcontacttype, iduser)
        VALUES(pdescontactsubtype, pidcontacttype, piduser);
        
        SET pidcontactsubtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contactssubtypes        
        SET 
            descontactsubtype = pdescontactsubtype,
            idcontacttype = pidcontacttype,
            iduser = piduser
        WHERE idcontactsubtype = pidcontactsubtype;

    END IF;

    CALL sp_contactssubtypes_get(pidcontactsubtype);

END