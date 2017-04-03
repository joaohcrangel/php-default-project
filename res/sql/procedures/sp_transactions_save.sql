CREATE PROCEDURE sp_transactions_save(
pidtransaction INT,
pdestransaction VARCHAR(256),
pidtransactiontype INT,
pvltotal DECIMAL(10,2),
pdtpayment DATE,
pdtregister TIMESTAMP
)
BEGIN

    IF pidtransaction = 0 THEN
    
        INSERT INTO tb_transactions (destransaction, idtransactiontype, vltotal, dtpayment, dtregister)
        VALUES(pdestransaction, pidtransactiontype, pvltotal, pdtpayment, pdtregister);
        
        SET pidtransaction = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_transactions        
        SET 
            destransaction = pdestransaction,
            idtransactiontype = pidtransactiontype,
            vltotal = pvltotal,
            dtpayment = pdtpayment,
            dtregister = pdtregister        
        WHERE idtransaction = pidtransaction;

    END IF;

    CALL sp_transactions_get(pidtransaction);

END