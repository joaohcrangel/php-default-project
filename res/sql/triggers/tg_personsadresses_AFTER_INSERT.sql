CREATE DEFINER = CURRENT_USER TRIGGER tg_personsadresses_AFTER_INSERT AFTER INSERT ON tb_personsadresses FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(NEW.idperson);
END