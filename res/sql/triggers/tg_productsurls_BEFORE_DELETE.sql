CREATE DEFINER = CURRENT_USER TRIGGER tg_productsurls_BEFORE_DELETE BEFORE DELETE ON tb_productsurls FOR EACH ROW
BEGIN
	CALL sp_productsdata_remove(OLD.idproduct);
END