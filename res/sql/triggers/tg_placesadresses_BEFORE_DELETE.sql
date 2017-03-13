CREATE DEFINER = CURRENT_USER TRIGGER tg_placesadresses_BEFORE_DELETE BEFORE DELETE ON tb_placesadresses FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(OLD.idplace);
END