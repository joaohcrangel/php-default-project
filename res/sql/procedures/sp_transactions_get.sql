CREATE PROCEDURE sp_transactions_get(
pidtransaction INT
)
BEGIN

    SELECT *    
    FROM tb_transactions    
    WHERE idtransaction = pidtransaction;

END