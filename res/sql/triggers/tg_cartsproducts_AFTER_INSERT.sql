CREATE DEFINER = CURRENT_USER TRIGGER tg_cartsproducts_AFTER_INSERT AFTER INSERT ON tb_cartsproducts FOR EACH ROW
BEGIN
	CALL sp_cartsdata_save(NEW.idcart);
END