CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhoscupons_AFTER_INSERT AFTER INSERT ON tb_carrinhoscupons FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(NEW.idcarrinho);
END