CREATE DEFINER = CURRENT_USER TRIGGER tg_personsfiles_BEFORE_DELETE BEFORE DELETE ON tb_personsfiles FOR EACH ROW
BEGIN
	CALL sp_personsdata_remove(OLD.idperson);
END