CREATE PROCEDURE sp_produtosprecos_remove(
pidpreco INT
)
BEGIN
	
	DELETE FROM tb_produtosprecos WHERE idpreco = pidpreco;
    
END