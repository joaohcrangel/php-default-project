CREATE DEFINER = CURRENT_USER TRIGGER tg_personsvalues_AFTER_INSERT AFTER INSERT ON tb_personsvalues FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(NEW.idperson);
END