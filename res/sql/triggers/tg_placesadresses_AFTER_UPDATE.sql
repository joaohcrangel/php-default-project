CREATE DEFINER = CURRENT_USER TRIGGER tg_placesadresses_AFTER_UPDATE AFTER UPDATE ON tb_placesadresses FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(NEW.idplace);
END