CREATE DEFINER = CURRENT_USER TRIGGER tg_users_BEFORE_DELETE BEFORE DELETE ON tb_users FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(OLD.idperson);
END