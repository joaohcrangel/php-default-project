CREATE PROCEDURE sp_transactionsaccountstypes_save(
pidtype INT,
pdestype VARCHAR(32),
pdtregister TIMESTAMP
)
BEGIN

    IF pidtype = 0 THEN
    
        INSERT INTO tb_transactionsaccountstypes (destype, dtregister)
        VALUES(pdestype, pdtregister);
        
        SET pidtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_transactionsaccountstypes        
        SET 
            destype = pdestype,
            dtregister = pdtregister        
        WHERE idtype = pidtype;

    END IF;

    CALL sp_transactionsaccountstypes_get(pidtype);

END;