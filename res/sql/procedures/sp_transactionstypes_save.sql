CREATE PROCEDURE sp_transactionstypes_save(
pidtransactiontype INT,
pdestransactiontype VARCHAR(32),
pdtregister TIMESTAMP
)
BEGIN

    IF pidtransactiontype = 0 THEN
    
        INSERT INTO tb_transactionstypes (destransactiontype, dtregister)
        VALUES(pdestransactiontype, pdtregister);
        
        SET pidtransactiontype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_transactionstypes        
        SET 
            destransactiontype = pdestransactiontype,
            dtregister = pdtregister        
        WHERE idtransactiontype = pidtransactiontype;

    END IF;

    CALL sp_transactionstypes_get(pidtransactiontype);

END