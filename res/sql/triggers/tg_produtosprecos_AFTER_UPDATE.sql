CREATE DEFINER = CURRENT_USER TRIGGER tg_produtosprecos_AFTER_UPDATE AFTER UPDATE ON tb_produtosprecos FOR EACH ROW
BEGIN
	CALL sp_produtosdados_save(NEW.idproduto);
END