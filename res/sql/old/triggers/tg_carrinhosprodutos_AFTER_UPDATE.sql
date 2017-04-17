CREATE DEFINER = CURRENT_USER TRIGGER tg_carrinhosprodutos_AFTER_UPDATE AFTER UPDATE ON tb_carrinhosprodutos FOR EACH ROW
BEGIN
	CALL sp_carrinhosdados_save(NEW.idcarrinho);
END