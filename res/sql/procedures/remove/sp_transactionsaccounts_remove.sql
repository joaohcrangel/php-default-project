CREATE PROCEDURE sp_transactionsaccounts_remove(
pidaccount INT
)
BEGIN

    DELETE FROM tb_transactionsaccounts 
    WHERE idaccount = pidaccount;

END;