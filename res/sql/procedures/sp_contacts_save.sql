CREATE PROCEDURE sp_contacts_save(
pidcontact INT,
pidcontactsubtype INT,
pidperson INT,
pdescontact VARCHAR(128),
pinprincipal BIT
)
BEGIN

    IF pidcontact = 0 THEN
    
        INSERT INTO tb_contacts (idcontactsubtype, idperson, descontact, inprincipal)
        VALUES(pidcontactsubtype, pidperson, pdescontact, pinprincipal);
        
        SET pidcontact = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contacts        
        SET 
            idcontactsubtype = pidcontactsubtype,
            idperson = pidperson,
            descontact = pdescontact,
            inprincipal = pinprincipal
        WHERE idcontact = pidcontact;

    END IF;

    CALL sp_contacts_get(pidcontact);

END