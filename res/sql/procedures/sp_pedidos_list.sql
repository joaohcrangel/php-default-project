CREATE PROCEDURE sp_pedidos_list()
BEGIN
	
	SELECT * FROM tb_pedidos a
		INNER JOIN tb_pessoas b ON a.idpessoa = b.idpessoa
        INNER JOIN tb_formaspagamentos c ON a.idformapedido = c.idformapedido
        INNER JOIN tb_pedidosstatus d ON a.idstatus = d.idstatus;
    
END