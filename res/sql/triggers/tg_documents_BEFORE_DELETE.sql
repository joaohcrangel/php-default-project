CREATE DEFINER = CURRENT_USER TRIGGER tg_documents_BEFORE_DELETE BEFORE DELETE ON tb_documents FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(OLD.idperson);
END