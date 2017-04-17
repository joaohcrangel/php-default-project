CREATE PROCEDURE sp_cuponsfromcarrinho_list(
pidcarrinho INT
)
BEGIN

	SELECT a.*, b.idcarrinho, c.descupomtipo FROM tb_cupons a
		INNER JOIN tb_carrinhoscupons b ON a.idcupom = b.idcupom
        INNER JOIN tb_cuponstipos c ON a.idcupomtipo = c.idcupomtipo
	WHERE b.idcarrinho = pidcarrinho;

END