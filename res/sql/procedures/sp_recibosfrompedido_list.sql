CREATE PROCEDURE sp_recibosfrompedido_list(
pidpedido INT
)
BEGIN

	SELECT * FROM tb_pedidosrecibos
		INNER JOIN tb_pedidos USING(idpedido)
	WHERE idpedido = pidpedido;

END