CREATE DEFINER = CURRENT_USER TRIGGER tb_documentos_BEFORE_DELETE BEFORE DELETE ON tb_documentos FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(OLD.idpessoa);
END