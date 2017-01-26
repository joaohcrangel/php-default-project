CREATE PROCEDURE sp_produtosdados_remove(
pidproduto INT
)
BEGIN
	
	DELETE FROM tb_produtosdados WHERE idproduto = pidproduto;
    
END