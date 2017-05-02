CREATE DEFINER = CURRENT_USER TRIGGER tg_productsprices_BEFORE_DELETE BEFORE DELETE ON tb_productsprices FOR EACH ROW
BEGIN
	CALL sp_productsdata_remove(OLD.idproduct);
END