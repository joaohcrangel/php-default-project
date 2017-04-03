CREATE PROCEDURE sp_transactionstypes_get(
pidtransactiontype INT
)
BEGIN

    SELECT *    
    FROM tb_transactionstypes    
    WHERE idtransactiontype = pidtransactiontype;

END