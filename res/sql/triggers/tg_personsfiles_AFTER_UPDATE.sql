CREATE DEFINER = CURRENT_USER TRIGGER tg_personsfiles_AFTER_UPDATE AFTER UPDATE ON tb_personsfiles FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(NEW.idperson);
END