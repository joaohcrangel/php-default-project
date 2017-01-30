CREATE PROCEDURE sp_carrinhosfretes_get(
pidcarrinho INT
)
BEGIN

    SELECT *    
    FROM tb_carrinhosfretes    
    WHERE idcarrinho = pidcarrinho;

END