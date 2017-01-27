CREATE PROCEDURE sp_carrinhosfretes_remove(
pidcarrinho INT
)
BEGIN

    DELETE FROM tb_carrinhosfretes 
    WHERE idcarrinho = pidcarrinho;

END