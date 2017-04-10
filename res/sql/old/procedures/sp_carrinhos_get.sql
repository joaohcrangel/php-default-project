CREATE PROCEDURE sp_carrinhos_get (
pidcarrinho INT
)
BEGIN
	
	SELECT a.*, b.despessoa FROM tb_carrinhos a
		INNER JOIN tb_pessoas b USING(idpessoa)
    WHERE idcarrinho = pidcarrinho;

END