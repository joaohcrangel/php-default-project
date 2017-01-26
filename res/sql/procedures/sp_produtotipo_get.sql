CREATE PROCEDURE sp_produtotipo_get(
pidprodutotipo INT
)
BEGIN

	SELECT * FROM tb_produtostipos WHERE idprodutotipo = pidprodutotipo;

END