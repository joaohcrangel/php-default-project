CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhosfretes_AFTER_DELETE AFTER DELETE ON tb_carrinhosfretes FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(OLD.idcarrinho);
END