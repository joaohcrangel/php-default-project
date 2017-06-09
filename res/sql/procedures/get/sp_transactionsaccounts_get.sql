CREATE PROCEDURE sp_transactionsaccounts_get(
pidaccount INT
)
BEGIN

    SELECT *    
    FROM tb_transactionsaccounts    
    WHERE idaccount = pidaccount;

END;