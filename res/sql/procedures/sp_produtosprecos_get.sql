CREATE PROCEDURE sp_produtosprecos_get(
pidpreco INT
)
BEGIN
	
	SELECT * FROM tb_produtosprecos a
		INNER JOIN tb_produtos USING(idproduto)
	WHERE a.idpreco = pidpreco;
    
END