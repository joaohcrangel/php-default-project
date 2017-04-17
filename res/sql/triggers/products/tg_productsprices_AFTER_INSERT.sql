CREATE DEFINER = CURRENT_USER TRIGGER tg_productsprices_AFTER_INSERT AFTER INSERT ON tb_productsprices FOR EACH ROW
BEGIN
	CALL sp_productsdata_save(NEW.idproduct);
END