CREATE DEFINER = CURRENT_USER TRIGGER tg_placescoordinates_BEFORE_DELETE BEFORE DELETE ON tb_placescoordinates FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(OLD.idplace);
END