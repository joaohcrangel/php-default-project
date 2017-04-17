CREATE DEFINER = CURRENT_USER TRIGGER tg_cartsproducts_AFTER_UPDATE AFTER UPDATE ON tb_cartsproducts FOR EACH ROW
BEGIN
	CALL sp_cartsdata_save(NEW.idcart);
END