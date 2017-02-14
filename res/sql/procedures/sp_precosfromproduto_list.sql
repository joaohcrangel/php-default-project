CREATE PROCEDURE sp_precosfromproduto_list(
pidproduto INT
)
BEGIN

	SELECT * 
    FROM tb_produtosprecos
	INNER JOIN tb_produtos USING(idproduto)
    WHERE idproduto = pidproduto
    ORDER BY dtinicio DESC, dttermino DESC;

END