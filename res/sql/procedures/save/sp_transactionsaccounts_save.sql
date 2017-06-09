CREATE PROCEDURE sp_transactionsaccounts_save(
pidaccount INT,
pdesaccount VARCHAR(64),
pidtype INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidaccount = 0 THEN
    
        INSERT INTO tb_transactionsaccounts (desaccount, idtype, dtregister)
        VALUES(pdesaccount, pidtype, pdtregister);
        
        SET pidaccount = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_transactionsaccounts        
        SET 
            desaccount = pdesaccount,
            idtype = pidtype,
            dtregister = pdtregister        
        WHERE idaccount = pidaccount;

    END IF;

    CALL sp_transactionsaccounts_get(pidaccount);

END;