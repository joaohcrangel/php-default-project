CREATE PROCEDURE sp_produtotipo_remove(
pidprodutotipo INT
)
BEGIN

	DELETE FROM tb_produtostipos WHERE idprodutotipo = pidprodutotipo;

END