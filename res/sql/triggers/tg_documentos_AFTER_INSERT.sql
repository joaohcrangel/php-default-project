CREATE DEFINER = CURRENT_USER TRIGGER tg_documentos_AFTER_INSERT AFTER INSERT ON tb_documentos FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(NEW.idpessoa);
END