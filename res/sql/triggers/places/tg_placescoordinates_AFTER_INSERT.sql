CREATE DEFINER = CURRENT_USER TRIGGER tg_placescoordinates_AFTER_INSERT AFTER INSERT ON tb_placescoordinates FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(NEW.idplace);
END