CREATE PROCEDURE sp_emailsblacklists_save(
pidblacklist INT,
pidcontact INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidblacklist = 0 THEN
    
        INSERT INTO tb_emailsblacklists (idcontact, dtregister)
        VALUES(pidcontact, pdtregister);
        
        SET pidblacklist = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_emailsblacklists        
        SET 
            idcontact = pidcontact,
            dtregister = pdtregister        
        WHERE idblacklist = pidblacklist;

    END IF;

    CALL sp_emailsblacklists_get(pidblacklist);

END