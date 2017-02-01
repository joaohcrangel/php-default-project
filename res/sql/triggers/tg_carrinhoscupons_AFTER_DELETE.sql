CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhoscupons_AFTER_DELETE AFTER DELETE ON tb_carrinhoscupons FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(OLD.idcarrinho);
END