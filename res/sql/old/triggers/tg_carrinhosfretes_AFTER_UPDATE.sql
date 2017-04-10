CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhosfretes_AFTER_UPDATE AFTER UPDATE ON tb_carrinhosfretes FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(NEW.idcarrinho);
END