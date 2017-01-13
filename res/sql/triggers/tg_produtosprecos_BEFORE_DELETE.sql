CREATE DEFINER = CURRENT_USER TRIGGER tg_produtosprecos_BEFORE_DELETE BEFORE DELETE ON tb_produtosprecos FOR EACH ROW
BEGIN
	CALL sp_produtosdados_remove(OLD.idproduto);
END