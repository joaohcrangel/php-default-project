CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhosprodutos_AFTER_DELETE AFTER DELETE ON tb_carrinhosprodutos FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(OLD.idcarrinho);
END