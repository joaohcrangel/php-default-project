CREATE PROCEDURE sp_formaspagamentos_remove(
pidformapagamento INT
)
BEGIN
	
	DELETE FROM tb_formaspagamentos WHERE idformapagamento = pidformapagamento;

END