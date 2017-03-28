CREATE PROCEDURE sp_contacts_save(
pidcontact INT,
pidcontactsubtype INT,
pidperson INT,
pdescontact VARCHAR(128),
pinmain BIT
)
BEGIN

    IF pidcontact = 0 THEN
    
        INSERT INTO tb_contacts (idcontactsubtype, idperson, descontact, inmain)
        VALUES(pidcontactsubtype, pidperson, pdescontact, pinmain);
        
        SET pidcontact = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contacts        
        SET 
            idcontactsubtype = pidcontactsubtype,
            idperson = pidperson,
            descontact = pdescontact,
            inmain = pinmain
        WHERE idcontact = pidcontact;

    END IF;

    CALL sp_contacts_get(pidcontact);

END