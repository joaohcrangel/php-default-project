CREATE DEFINER = CURRENT_USER TRIGGER tg_placesaddresses_BEFORE_DELETE BEFORE DELETE ON tb_placesaddresses FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(OLD.idplace);
END