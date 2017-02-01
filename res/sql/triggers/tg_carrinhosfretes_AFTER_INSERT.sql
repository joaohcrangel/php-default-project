CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhosfretes_AFTER_INSERT AFTER INSERT ON tb_carrinhosfretes FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(NEW.idcarrinho);
END