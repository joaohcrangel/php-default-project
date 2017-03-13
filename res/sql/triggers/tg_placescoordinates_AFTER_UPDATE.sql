CREATE DEFINER = CURRENT_USER TRIGGER tg_placescoordinates_AFTER_UPDATE AFTER UPDATE ON tb_placescoordinates FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(NEW.idplace);
END