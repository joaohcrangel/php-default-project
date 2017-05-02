CREATE DEFINER = CURRENT_USER TRIGGER tg_personsaddresses_BEFORE_DELETE BEFORE DELETE ON `tb_personsaddresses` FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(OLD.idperson);
END
