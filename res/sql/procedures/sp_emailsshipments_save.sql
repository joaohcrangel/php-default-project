CREATE PROCEDURE sp_emailsshipments_save(
pidshipment INT,
pidemail INT,
pidcontact INT,
pdtsent DATETIME,
pdtreceived DATETIME,
pdtvisualized DATETIME,
pdtregister TIMESTAMP
)
BEGIN

    IF pidshipment = 0 THEN
    
        INSERT INTO tb_emailsshipments (idemail, idcontact, dtsent, dtreceived, dtvisualized, dtregister)
        VALUES(pidemail, pidcontact, pdtsent, pdtreceived, pdtvisualized, pdtregister);
        
        SET pidshipment = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_emailsshipments        
        SET 
            idemail = pidemail,
            idcontact = pidcontact,
            dtsent = pdtsent,
            dtreceived = pdtreceived,
            dtvisualized = pdtvisualized,
            dtregister = pdtregister        
        WHERE idshipment = pidshipment;

    END IF;

    CALL sp_emailsshipments_get(pidshipment);

END