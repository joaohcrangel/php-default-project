CREATE PROCEDURE sp_transactions_remove(
pidtransaction INT
)
BEGIN

    DELETE FROM tb_transactions 
    WHERE idtransaction = pidtransaction;

END