CREATE DEFINER = CURRENT_USER TRIGGER tg_placesaddresses_AFTER_INSERT AFTER INSERT ON tb_placesaddresses FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(NEW.idplace);
END