CREATE PROCEDURE sp_emailsattachments_save(
pidemail INT,
pidfile INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidemail = 0 THEN
    
        INSERT INTO tb_emailsattachments (dtregister)
        VALUES(pdtregister);
        
        SET pidemail = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_emailsattachments        
        SET 
            dtregister = pdtregister        
        WHERE idemail = pidemail;

    END IF;

    CALL sp_emailsattachments_get(pidemail);

END