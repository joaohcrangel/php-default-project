CREATE DEFINER = CURRENT_USER TRIGGER tg_personsaddresses_AFTER_INSERT AFTER INSERT ON tb_personsaddresses FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(NEW.idperson);
END