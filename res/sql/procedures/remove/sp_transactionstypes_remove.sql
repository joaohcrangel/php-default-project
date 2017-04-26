CREATE PROCEDURE sp_transactionstypes_remove(
pidtransactiontype INT
)
BEGIN

    DELETE FROM tb_transactionstypes 
    WHERE idtransactiontype = pidtransactiontype;

END