CREATE DEFINER = CURRENT_USER TRIGGER tg_persons_BEFORE_DELETE BEFORE DELETE ON tb_persons FOR EACH ROW
BEGIN
	CALL sp_personsdata_remove(OLD.idpessoa);
END