CREATE PROCEDURE sp_transactionsaccountstypes_get(
pidtype INT
)
BEGIN

    SELECT *    
    FROM tb_transactionsaccountstypes    
    WHERE idtype = pidtype;

END;