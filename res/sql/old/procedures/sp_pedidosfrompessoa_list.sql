CREATE PROCEDURE sp_pedidosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT a.*, b.*, c.desformapedido, d.* FROM tb_pedidos a
		INNER JOIN tb_pessoas b USING(idpessoa)
        INNER JOIN tb_formaspagamentos c ON a.idformapedido = c.idformapedido
        INNER JOIN tb_pedidosstatus d ON a.idstatus = d.idstatus
	WHERE a.idpessoa = pidpessoa;

END