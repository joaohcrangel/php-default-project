CREATE PROCEDURE sp_formaspagamentos_get(
pidformapagamento INT
)
BEGIN
	
	SELECT * FROM tb_formaspagamentos a INNER JOIN tb_gateways USING(idgateway)
    WHERE a.idformapagamento = pidformapagamento;

END