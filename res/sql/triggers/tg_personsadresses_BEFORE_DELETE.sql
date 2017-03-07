CREATE DEFINER = CURRENT_USER TRIGGER tg_personsadresses_BEFORE_DELETE BEFORE DELETE ON `tb_personsadresses` FOR EACH ROW
BEGIN
	CALL sp_personsdata_save(OLD.idperson);
END
