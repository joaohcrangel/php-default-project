CREATE DEFINER = CURRENT_USER TRIGGER tg_personsvalues_BEFORE_DELETE BEFORE DELETE ON tb_personsvalues FOR EACH ROW
BEGIN
	CALL sp_personsdata_remove(OLD.idperson);
END