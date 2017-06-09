CREATE PROCEDURE sp_transactionsaccountstypes_remove(
pidtype INT
)
BEGIN

    DELETE FROM tb_transactionsaccountstypes 
    WHERE idtype = pidtype;

END;